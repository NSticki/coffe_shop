<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class InformationController extends Controller
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

        $data['title'] = 'Информационные страницы';
        $data['info'] = Information::orderBy('id', 'DESC')->paginate(15);
        $data['code'] = Information::orderBy('id');

        return view('app.information.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $data = array();
        $data['title'] = 'Новая страница';

        return view('app.information.create', compact('data'));
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

        $table = new Information([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'code' => $request->get('code'),
        ]);

        if ($table->save()) {
            return redirect(route('info.index'))
                ->with('message', "Страница \"{$request->get('title')}\" создана.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Information $information
     * @return Response
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Information $info
     * @return Application|Factory|View|Response
     */
    public function edit(Information $info)
    {
        $data['info'] = $info;
        return view('app.information.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);
        Information::find($id)->update($request->all());
        return redirect(route('info.index'))
            ->with('message', "Страница '".$request->get('title')."' обновлена.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $info = Information::where('id', '=', $id)->pluck('title');
        Information::destroy($id);
        return redirect()->route('info.index')->with('message', "Страница \"{$info[0]}\" удалена.");
    }
}
