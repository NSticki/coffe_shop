<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Option_categories;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class OptionCategoryController extends Controller
{

    public const VALIDATION = [
        'name' => 'required',
        'sort_order' => 'required|integer',
    ];

    public const VALIDATION_MESSAGES = [
        'required' => 'Заполните поле',
        'integer' => 'Поле должно являться числом'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = array();
        $data['title'] = 'Опции';
        $data['options'] = Option_categories::orderBy('id')->paginate(15);
        return view('app.options.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|
     */
    public function create()
    {
        $data = array();
        $data['title'] = 'Опция';
        $data['options'] = Option_categories::all();

        return view('app.options.create', compact('data'));
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);
        $category = new Option_categories([
            'name' => $request->get('name'),
            'parent_id' => $request->get('parent_id'),
            'sort_order' => $request->get('sort_order'),
            'is_disabled' => $request->get('is_disabled')
        ]);
        $category->save();

        $options = array();
        foreach ($request->get('options') as $option) {
            $options[] = [
                'name' => $option['name'],
                'guid' => $option['guid'],
                'parent_id' => $category->id,
                'prefix' => $option['prefix'],
                'price' => $option['price'],
                'weight' => $option['weight'],
                'is_disabled' => $option['is_disabled']
            ];
        }

        Option::insert($options);

        return redirect(route('options.index'))
            ->with('message', "Опция \"{$request->get('name')}\" добавлена.");
    }


    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $data = array();
        $data['option'] = Option_categories::where('id', $id)->first();
        $data['title'] = isset($data['option']->name) ? $data['option']->name : 'Опция';
        $data['options'] = Option_categories::all();
        $data['modifiers'] = Option::where('parent_id', $id)->get();

        return view('app.options.update', compact('data'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);

        Option_categories::find($id)->update([
            'name' => $request->get('name'),
            'parent_id' => $request->get('parent_id'),
            'sort_order' => $request->get('sort_order'),
            'min_amount' => $request->get('min_amount'),
            'max_amount' => $request->get('max_amount'),
            'required' => $request->get('required') == 1 ? 1 : null,
            'is_disabled' => $request->get('is_disabled') ? true : false
        ]);

        $options = array();
        foreach ($request->get('options') as $option) {
            $options[] = [
                'name' => $option['name'],
                'guid' => $option['guid'],
                'parent_id' => $id,
                'prefix' => $option['prefix'],
                'price' => $option['price'],
                'weight' => $option['weight'],
                'is_disabled' => (isset($option['is_disabled']) && $option['is_disabled'] ? true : false)
            ];
        }

        Option::upsert($options, ['guid'], ['name', 'prefix', 'price', 'weight', 'is_disabled']);

        return redirect(route('options.index'))
            ->with('message', "Опция \"{$request->get('name')}\" обновлена.");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Option_categories::destroy($id);
        return redirect()->route('options.index');
    }
}
