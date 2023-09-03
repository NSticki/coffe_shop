<?php


namespace App\Services\Integration;


use App\Models\Category;
use App\Models\Category_images;
use App\Models\Option;
use App\Models\Option_categories;
use App\Models\Product;
use App\Models\Product_images;
use App\Models\Product_options;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IikoCatalog
{
    /**
     * Run store methods chain.
     * @param $data
     * @throws Exception
     */
    public function store($data)
    {
        if (!empty($data['groups'])) {
            $this->storeCategories($data['groups']);
        }

        if (!empty($data['products'])) {
            $this->storeOptionsAndProducts($data['products']);
        }
    }

    /**
     * Store Options and Products
     *
     * @param $data
     * @return void
     * @throws Exception
     */
    public function storeOptionsAndProducts($data)
    {
        if (!empty($data)) {
            $modifiers = array_filter($data, function ($element) {
                if (strtolower($element['type']) == 'modifier') {
                    return $element;
                }
                return false;
            });
            $insert = [];
            array_walk($modifiers, function ($element, $key) use (&$insert) {
                $parent_id = Option_categories::where('guid', $element['parentGroup'])->pluck('id')->first();

                $insert[$key] = [
                    'guid' => $element['id'],
                    'parent_id' => $parent_id,
                    'name' => $element['name'],
                    'price' => $element['sizePrices'][0]['price']['currentPrice'],
                    'weight' => $element['weight'],
                ];

                if ($element['sizePrices'][0]['price']['currentPrice'] >= 0) {
                    $insert[$key]['prefix'] = '+';
                } else {
                    $insert[$key]['prefix'] = '-';
                }

            });

            Option::upsert($insert, ['guid'], ['guid', 'parent_id', 'name', 'prefix', 'price', 'weight']);

            $products = array_filter($data, function ($element) {
                if (strtolower($element['type']) == 'dish') {
                    return $element;
                }
                return false;
            });

            $insert = [];
            foreach ($products as $product) {
                $category_id = Category::where('guid', $product['parentGroup'])->pluck('id')->first();

                $insert[] = [
                    'price' => $product['sizePrices'][0]['price']['currentPrice'],
                    'product_name' => $product['name'],
                    'guid' => $product['id'],
                    'category_id' => $category_id ? $category_id : 0,
                    'sort_order' => $product['order'],
                    'product_description' => $product['description'],
                    'weight' => $product['weight'],
                    'fatAmount' => $product['fatAmount'],
                    'proteinsAmount' => $product['proteinsAmount'],
                    'carbohydratesAmount' => $product['carbohydratesAmount'],
                    'energyAmount' => $product['energyAmount'],
                ];

            }
            Product::upsert($insert, ['guid'], ['product_name', 'price', 'category_id', 'sort_order', 'product_description', 'weight', 'fatAmount', 'proteinsAmount', 'carbohydratesAmount', 'energyAmount']);
            $this->insertProductImages($products);


            Product_options::truncate();
            foreach ($products as $product) {
                $id = Product::where('guid', $product['id'])->pluck('id')->first();
                $product_options = array();

                if (!empty($product['groupModifiers'])) {
                    foreach ($product['groupModifiers'] as $groupModifier) {
                        DB::table('option_categories')
                            ->where('guid', $groupModifier['id'])
                            ->update([
                                'required' => $groupModifier['required'],
                                'min_amount' => $groupModifier['minAmount'],
                                'max_amount' => $groupModifier['maxAmount'],
                            ]);

                        foreach ($groupModifier['childModifiers'] as $item) {
                            $product_options[] = $item['id'];
                        }
                    }
                }

                foreach ($product['modifiers'] as $modifier) {
                    $product_options[] = $modifier['id'];
                }


                $insert = [];

                foreach ($product_options as $option) {
                    $guid = Option::where('guid', $option)->pluck('id')->first();
                    $insert[] = [
                        'product_id' => $id,
                        'option_id' => $guid,
                    ];
                }
                DB::table('product_options')->insert($insert);
            }

        }
    }

    /**
     * Parse and save product images.
     *
     * @param $products
     * @return void
     * @throws Exception
     */
    public function insertProductImages($products)
    {
        Product_images::truncate();

        /* Delete previous image */
        $files = Storage::disk('products')->allFiles();
        Storage::disk('products')->delete($files);

        foreach ($products as $product) {
            if (!empty($product['imageLinks'])) {
                $id = Product::where('guid', $product['id'])->pluck('id')->first();

                try {
                    $content = file_get_contents(end($product['imageLinks']));
                    $name = bin2hex(random_bytes(20)) . '.' . pathinfo(end($product['imageLinks']), PATHINFO_EXTENSION);

                    Storage::disk('products')->put($name, $content);
                    Product_images::insert([
                        'original_url' => end($product['imageLinks']),
                        'product_id' => $id,
                        'image_url' => $name,
                    ]);
                } catch (Exception $e) {
                    Log::channel('iiko')->info("[ERROR]  -->" . $e->getMessage());
                }
            }
        }
    }

    /**
     * Parse and save categories images.
     *
     * @param $categories
     * @return void
     * @throws Exception
     */
    public function insertCategoryImages($categories)
    {
        Category_images::truncate();

        /* Delete previous image */
        $files = Storage::disk('categories')->allFiles();
        Storage::disk('categories')->delete($files);

        foreach ($categories as $category) {
            if (!empty($category['imageLinks'])) {
                $id = Category::where('guid', $category['id'])->pluck('id')->first();

                try {
                    $content = file_get_contents(end($category['imageLinks']));
                    $name = bin2hex(random_bytes(20)) . '.' . pathinfo(end($category['imageLinks']), PATHINFO_EXTENSION);

                    Storage::disk('categories')->put($name, $content);
                    Category_images::upsert([
                        'original_url' => end($category['imageLinks']),
                        'category_id' => $id,
                        'image_url' => $name,
                    ], ['category_id'], ['original_url', 'image_url']);
                } catch (Exception $e) {
                    Log::channel('iiko')->info("[ERROR]  -->" . $e->getMessage());
                }




            }
        }
    }


    /**
     * Method to store Categories and Option categories.
     *
     * @param void
     * @throws Exception
     */
    public function storeCategories($data)
    {
        $categories = array();
        $modifiers = array();

        foreach ($data as $key => $value) {
            if ($value['isGroupModifier'] == 1) {
                $modifiers[] = $data[$key];
            } else {
                $categories[] = $data[$key];
            }
        }

        $insert = [];

        foreach ($categories as $category) {

            $parent_id = $category['id'] == $category['parentGroup'] ? null : $category['parentGroup'];

            $insert[] = [
                'guid' => $category['id'],
                'name' => $category['name'],
                'sort_order' => $category['order'],
                'parent_id' => $parent_id,
            ];

        }

        Category::upsert($insert, ['guid'], ['guid', 'name', 'sort_order', 'parent_id']);

        $insert = [];

        array_walk($modifiers, function ($element) use (&$insert) {

            $parent_id = $element['id'] == $element['parentGroup'] ? null : $element['parentGroup'];
            $insert[] = [
                'guid' => $element['id'],
                'name' => $element['name'],
                'sort_order' => $element['order'],
                'parent_id' => $parent_id,
            ];
        });

        Option_categories::upsert($insert, ['guid'], ['guid', 'name', 'sort_order', 'parent_id']);
        $this->insertCategoryImages($data);
    }
}
