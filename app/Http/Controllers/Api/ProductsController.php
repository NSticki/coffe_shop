<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
   public function index(Request $request, Product $product)
   {
      $id = $request->get('id');
      if(!isset($id) || empty($id)) return response(array("message" => "'id' is missing"), 400);

      $result["products"] = $product->where("category_id", $id)->where("is_disabled", false)->orderBy("sort_order")->get();
      foreach ($result['products'] as $index => $product){
          $product_image = Product::find($product['id'])->images->last();
          if (!empty($product_image['image_url'])) {
              $image = $product_image['image_url'];
              $result['products'][$index]['image'] = asset('/storage/images/products/'.$image);
          }
      }
      return response($result, 200);
   }
}
