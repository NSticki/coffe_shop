<?php

namespace App\Services\Integration;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Carbon\Carbon;

class IikoStores extends Controller
{
    public function save($data)
    {
        foreach ($data['terminalGroups'] as $terminalGroups) {
            foreach ($terminalGroups['items'] as $store) {
                print_r($store);
                $insert = [
                    'guid' => $store['id'],
                    'store_name' => $store['name'],
                    'store_address' => $store['address'],
                    'time_from' => Carbon::now()->toTimeString(),
                    'time_to' => Carbon::now()->toTimeString(),
                ];

                Store::upsert($insert, ['guid'], ['store_name', 'store_address']);
            }
        }
    }
}
