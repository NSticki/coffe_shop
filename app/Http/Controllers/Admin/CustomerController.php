<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\False_;

class CustomerController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Покупатели';
        $data['users'] = Customer::orderBy('id', 'DESC')->paginate(15);

        return view('app.customers.index', compact('data'));
    }


    /**
     * @return false
     */
    public function create()
    {
        return false;
    }

    public function show($id)
    {
        $data['customer'] = Customer::where('id', $id)->get()->last();

        return view('app.customers.show', compact('data'));
    }

}
