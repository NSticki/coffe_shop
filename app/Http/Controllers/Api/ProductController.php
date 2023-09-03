<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Option_categories;
use App\Models\Product_options;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $id = $request->get('id');
        if (!isset($id) || empty($id)) return response(array("message" => "'id' is missing"), 400);

        $result["product"] = $product->where("id", $id)->orderBy("sort_order")->get()->first();
        $product_image = Product::find($id)->images->last();
        if (!empty($product_image['image_url'])) {
            $image = $product_image['image_url'];
            $result['product']['image'] = asset('/storage/images/products/'.$image);
        }

        $options_to_product = Product_options::where('product_id', $id)->get();

        $options_categories = Option_categories::all()->toArray();

        foreach ($options_to_product as $value){
            $option = Option::where('id', $value['option_id'])->first();
            $key = array_search($option['parent_id'],array_column($options_categories, 'id'));

            if(isset($option['is_disabled']) && $option['is_disabled'] == true) continue;

            $options_categories[$key]['values'][] = $option;
        }

        foreach ($options_categories as $i => $category){
            if (empty($category['values']) || $category['is_disabled']) {
                unset($options_categories[$i]);
            }
        }
        $options_categories = array_values($options_categories);
        $result['product']['options'] = $options_categories;


        return response($result, 200);
    }
}
