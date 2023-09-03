<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoriesController extends Controller
{
   public function index(Category $category)
   {
      $res = Category::where('is_disabled', false)->get();

      $result = array(
         "categories" => $res,
         "defaultCategory" => $res[0]
      );

      return response($result, 200);
   }
}
