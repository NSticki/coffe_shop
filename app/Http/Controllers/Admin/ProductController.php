<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Option;
use App\Models\Option_categories;
use App\Models\Product;
use App\Models\Product_images;
use App\Models\Product_options;
use App\Models\Product_to_store;
use App\Models\Store;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use function Couchbase\defaultDecoder;

class ProductController extends Controller
{

    public const VALIDATION = [
        'product_name' => 'required',
        'sort_order' => 'required|integer',
    ];

    public const VALIDATION_MESSAGES = [
        'required' => 'Заполните поле',
        'integer' => 'Поле должно являться числом'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $data = array();
        $data['title'] = 'Товары';
        $data['products'] = Product::orderBy('id')->paginate(15);
        return view('app.products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return Application|Factory|View|Response
     */
    public function create(Product $product)
    {
        $data = array();
        $data['title'] = 'Товар';
        $data['categories'] = Category::orderBy('sort_order', 'ASC')->get();
        $data['stores'] = Store::all();
        $data['option_categories'] = $this->getOptions();

        return view('app.products.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);
        $table = new Product($request->all());

        if ($table->save()) {
            $to_store = array();
            if (!empty($request->get('stores_id'))) {
                foreach ($request->get('stores_id') as $store) {
                    $to_store[] = array(
                        'product_id' => $table->id,
                        'store_id' => $store);
                }

                Product_to_store::insert($to_store);
            }

            if ($request->product_images) {
                $path = $request->product_images->store('/', 'products');
                Product_images::updateOrCreate([
                    'product_id' => $table->id,
                    'image_url' => $path,
                ]);
            }

            if (!empty($request->get('options'))) {
                $options = [];

                foreach ($request->get('options') as $option) {
                    $options[] = [
                        'product_id' => $table->id,
                        'option_id' => $option,
                    ];
                }

                Product_options::insert($options);
            }


            return redirect(route('products.index'))
                ->with('message', "Товар \"{$request->get('product_name')}\" добавлена.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View|Response
     */
    public function edit(Product $product)
    {
        $data = array();
        $data['product'] = $product;
        $data['categories'] = Category::orderBy('sort_order', 'ASC')->get();
        $data['title'] = isset($product->product_name) ? $product->product_name : '';
        $data['stores'] = isset($product->id) ? $this->getStores($product->id) : '';
        $data['images'] = Product::find($product->id)->images->last();
        $options_list = isset($product->id) ? Product_options::where('product_id',$product->id)->get()->toArray() : '';
        $options = [];
        array_walk($options_list, function ($value) use (&$options) {
            $options[] = $value['option_id'];
        });

        $option_categories = $this->getOptions();
        foreach ($option_categories as $key => $option_category){

            foreach ($option_category['options'] as $i => $option){
                if (in_array($option['id'],$options)) {
                    $option_categories[$key]['options'][$i]['selected'] = true;
                    $option_categories[$key]['selected'] = true;
                }
            }

        }
        $data['option_categories'] = $option_categories;

        return view('app.products.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     * @throws ValidationException
     */
    public function update($id, Request $request)
    {

        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);

        $data = $request->all();
        if(!isset($data['is_disabled'])) {
            $data['is_disabled'] = false;
        }

        Product::find($id)->update($data);
        if (!empty($stores = $request->get('stores_id'))) {
            $this->editProductToStore($id, $stores);
        }

        if (!empty($request->get('options'))) {
            Product_options::where('product_id',$id)->delete();
            $options = [];

            foreach ($request->get('options') as $option) {
                $options[] = [
                    'product_id' => $id,
                    'option_id' => $option,
                ];
            }

            Product_options::insert($options);
        }

        if ($request->product_images) {
            $path = $request->product_images->store('/', 'products');
            Product_images::updateOrCreate([
                'product_id' => $id,
                'image_url' => $path,
            ]);
        }
        return redirect(route('products.index'))
            ->with('message', "Товар обновлен.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $info = Product::where('id', '=', $id)->pluck('product_name');
        Product::destroy($id);
        return redirect()->route('products.index')->with('message', "Товар \"{$info[0]}\" удален.");
    }

    /**
     * Get Stores collection with status.
     * @param $product_id
     * @return Store[]|Collection
     */
    public function getStores(int $product_id)
    {
        $stores = Store::all();
        $product_to_store = Product_to_store::where('product_id', $product_id)->get();
        if (!empty($product_to_store)) {
            foreach ($stores as $key => $store) {
                foreach ($product_to_store as $item) {
                    if ($store->id == $item->store_id) {
                        $stores[$key]['checked'] = true;
                    }
                }
            }
        }
        return $stores;
    }

    /**
     * Get list of options
     *
     * @return array
     */
    public function getOptions()
    {
        $option_categories = Option_categories::all()->toArray();
        foreach ($option_categories as $key => $option_category) {
            $options = Option::where('parent_id', $option_category['id'])->get();
            $option_categories[$key]['options'] = $options->toArray();
        }
        return $option_categories;
    }

    /**
     * Insert or update product_to_store schema.
     * @param int $id
     * @param $stores
     */
    public function editProductToStore(int $id, $stores)
    {
        Product_to_store::where('id', $id)->delete();
        array_walk($stores, function ($item) use ($id) {
            if ($item > 0) {
                $table = new Product_to_store([
                    'product_id' => $id,
                    'store_id' => $item,
                ]);
                $table->save();
            }
        });
    }
}
