<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */

    public const VALIDATION = [
        'name' => 'required',
        'sort_order' => 'required|integer',
    ];

    public const VALIDATION_MESSAGES = [
        'required' => 'Заполните поле',
        'integer' => 'Поле должно являться числом'
    ];

    public function index(Category $category)
    {
        $data = array();

        $data['categories'] = $category->getCategoriesList();
        $data['title'] = 'Категории';


        return view('app.categories.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create()
    {

        $data = array();
        $data['categories'] = Category::orderBy('sort_order', 'ASC')->get();
        $data['title'] = 'Категория';

        return view('app.categories.create', compact('data'));
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

        $table = new Category([
            'name' => $request->get('name'),
            'parent_id' => intval($request->get('parent_id')),
            'sort_order' => $request->get('sort_order'),
            'is_disabled' => $request->get('is_disabled')
        ]);

        if ($table->save()) {
            return redirect(route('categories.index'))
                ->with('message', "Категория \"{$request->get('name')}\" добавлена.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return bool
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Category $category)
    {

        $data = array();
        $data['category'] = $category;
        $categories = Category::orderBy('sort_order', 'ASC')->get();
        $filter = array_filter($categories->toArray(), function ($item) use ($category, $categories) {
            if ($item['id'] != $category->id) return true;
        });
        $data['categories'] = $filter;
        $data['title'] = 'Категория';

        return view('app.categories.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);

        $data = $request->all();
        if(!isset($data['is_disabled']))
        {
            $data['is_disabled'] = false;
        }

        $category->update($data);
        return redirect(route('categories.index'))
            ->with('message', "Категория обновлена.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy(int $id)
    {
        $info = Category::where('id', '=', $id)->pluck('name');
        Category::destroy($id);
        return redirect()->route('categories.index')->with('message', "Категория \"{$info[0]}\" удалена.");
    }
}
