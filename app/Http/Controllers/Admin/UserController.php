<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\User_role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public const VALIDATION = [
        'name' => 'required',
        'password' => 'required|same:password-confirm|min:6',
        'email' => 'required|email'
    ];
    public const VALIDATION_MESSAGES = [
        'required' => 'Заполните поле',
        'email' => 'Введите корректный email',
        'same' => 'Пароли не совпадают',
        'unique' => 'Данный email уже занят',
        'min' => 'Пароль должен быть длинее 6 символов'
    ];

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Пользователи';
        $data['users'] = User::orderBy('id', 'DESC')->paginate(15);

        return view('app.users.index', compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = array();
        $data['title'] = 'Новый Пользователь';
        $data['user_roles'] = User_role::all();

        return view('app.users.create', compact('data'));
    }

    /**
     * @param UserRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(UserRequest $request)
    {
        $this->validate($request,self::VALIDATION,self::VALIDATION_MESSAGES);
        $user = new User([
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'telephone' => $request->get('telephone'),
            'password' => Hash::make($request->get('password')),
            'role_id' => $request->get('role_id'),
        ]);

        if ($user->save()) {
            return redirect(route('users.index'))
                ->with('message', "Пользователь \"{$request->get('name')}\" добавлен.");
        }
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $data = array();
        $data['user'] = $user;
        $data['user_roles'] = User_role::all();
        return view('app.users.update', compact('data'));
    }

    /**
     * @param $id
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update($id, UserRequest $request)
    {
        $request->validated();
        $user = User::where('id', $id)->first();
        $insert = [
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'telephone' => $request->get('telephone'),
            'email' => $request->get('email'),

            'role_id' => $request->get('role_id'),
        ];

        User::find($id)->update($insert);
        return redirect()->route('users.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        User::destroy($id);
        return redirect()->route('users.index');
    }
}
