<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use App\Models\Order;
use App\Models\Order_options;
use App\Models\Order_products;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $data = array();
        $data['title'] = 'Заказы';
        $data['orders'] = Order::orderBy('id')->paginate(15);
        return view('app.orders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $data = array();
        $data['title'] = 'Заказ';
        return view('app.orders.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->request->add(['created_at' => Carbon::parse(time())]);
        $order = new Order($request->all());
        $order->save();
        return redirect(route('orders.index'))
            ->with('message', "Заказ создан.");
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return Application|Factory|View
     */
    public function show(Order $order)
    {
        $data['order'] = $order;
        $items = Order_products::where('order_id', $order->id)->get()->toArray();

        $data['order_items'] = array();
        $product_guids = array();

        foreach ($items as $item) {
            $product_guids[] = $item['product_guid'];
            $options = Order_options::where('order_id', $order->id)->where('product_guid', $item['product_guid'])->get();

            $option_array = array();

            foreach ($options as $option) {
                $option_array[] = $option;
            }
            $item['name_product'];
            $item['price_product'];

            $products = $item;
            $products['amount'] = $item['amount'];
            $products['modifiers'] = $option_array;
            $data['order_items'][] = $products;
        }
        return view('app.orders.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order  $order
     * @return Response
     */
    public function edit(Order $order)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Order  $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy(int $id)
    {
        Order::destroy($id);
        return redirect(route('orders.index'))
            ->with('message', "Заказ удален.");
    }
}
