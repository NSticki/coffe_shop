<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */

    public const VALIDATION = [
        'store_name' => 'required',
        'time_from' => 'required',
        'time_to' => 'required',
    ];

    public const VALIDATION_MESSAGES = [
        'required' => 'Заполните поле',
        'integer' => 'Поле должно являться числом',
    ];

    public function index()
    {
        $data = array();
        $table = Store::orderBy('updated_at', 'DESC')->paginate(15);

        $data['stores'] = $table;
        $data['title'] = 'Магазины';

        return view('app.stores.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $data = array();
        $data['stores'] = Store::orderBy('id', 'ASC')->get();
        $data['title'] = 'Магазин';

        return view('app.stores.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);

        $table = new Store([
            'store_name' => $request->get('store_name'),
            'store_address' => $request->get('store_address'),
            'store_phone' => $request->get('store_phone'),
            'time_from' => $request->get('time_from'),
            'time_to' => $request->get('time_to'),
        ]);

        if ($table->save()) {
            return redirect(route('stores.index'))->with('message', "Магазин \"{$request->get('store_name')}\" добавлен.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Store $store
     * @return Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Store $store
     * @return Application|Factory|View|Response
     */
    public function edit(Store $store)
    {
        $data = array();
        $data['store'] = $store;
        $data['title'] = $store['store_name'];

        return view('app.stores.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Store $store
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Store $store)
    {
        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);
        $store->update($request->all());
        return redirect(route('stores.index'))
            ->with('message', "Магазин обновлен.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $info = Store::where('id', '=', $id)->pluck('store_name');
        Store::destroy($id);
        return redirect()->route('stores.index')->with('message', "Магазин \"{$info[0]}\" удален.");
    }
}
