<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\False_;

class ReviewController extends Controller
{
	public function index()
	{
		$data['title'] = 'Отзывы';
		$data['reviews'] = Review::orderBy('id', 'DESC')->paginate(15);

		return view('app.reviews.index', compact('data'));
	}

	public function create()
	{
		return false;
	}

	public function show($id)
	{
		$data['review'] = Review::where('id', $id)->get()->last();

		return view('app.reviews.show', compact('data'));
	}
}