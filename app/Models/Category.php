<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
        'parent_id',
        'guid',
        'is_disabled'
    ];

    public function getCategoriesList()
    {
        $categories = self::orderBy('sort_order', 'ASC')->paginate(15);
        $table = self::orderBy('sort_order', 'ASC')->get();

        foreach ($categories as $key => $item) {
            if ($item['parent_id'] == NULL) {
                $categories[$key]['parent_name'] = "Главная";
            } else {
                $i = array_search($item['parent_id'], array_column($table->toArray(), 'guid'));
                $categories[$key]['parent_name'] = $table[$i]['name'];
            }
        }
        return $categories;
    }
}
