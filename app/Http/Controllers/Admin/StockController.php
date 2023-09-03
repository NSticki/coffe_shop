<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    public const VALIDATION = [
        'title' => 'required',
        'content' => 'required',
    ];

    public const VALIDATION_MESSAGES = [
        'required' => 'Заполните поле',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $data = array();

        $data['title'] = 'Акции';
        $data['stocks'] = Stock::orderBy('id', 'DESC')->paginate(15);

        return view('app.stocks.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $data = array();
        $data['title'] = 'Новая акция';

        return view('app.stocks.create', compact('data'));
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

        $table = new Stock([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        if ($table->save()) {
            return redirect(route('stocks.index'))
                ->with('message', "Акция \"{$request->get('title')}\" создана.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Stock $stock
     * @return Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Stock $stock
     * @return Application|Factory|View|Response
     */
    public function edit(Stock $stock)
    {
        $data['stock'] = $stock;
        return view('app.stocks.update', compact('data'));
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
        Stock::find($id)->update($request->all());
        return redirect(route('stocks.index'))
            ->with('message', "Акция '".$request->get('title')."' обновлена.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id)
    {
        $info = Stock::where('id', '=', $id)->pluck('title');
        Stock::destroy($id);
        return redirect()->route('stocks.index')->with('message', "Акция \"{$info[0]}\" удалена.");
    }
}
