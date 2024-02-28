<?php

namespace Database\Seeders;

use Botble\Ecommerce\Models\StoreLocator;
use Botble\Setting\Models\Setting;
use Illuminate\Database\Seeder;

class StoreLocatorSeeder extends Seeder
{
    public function run(): void
    {
        StoreLocator::query()->truncate();

        $storeLocator = StoreLocator::query()->create([
            'name' => 'Farmart',
            'email' => 'sales@botble.com',
            'phone' => '1800979769',
            'address' => '502 New Street',
            'state' => 'Brighton VIC',
            'city' => 'Brighton VIC',
            'country' => 'AU',
            'is_primary' => 1,
            'is_shipping_location' => 1,
        ]);

        Setting::query()->whereIn('key', [
            'ecommerce_store_name',
            'ecommerce_store_phone',
            'ecommerce_store_address',
            'ecommerce_store_state',
            'ecommerce_store_city',
            'ecommerce_store_country',
        ])->delete();

        Setting::query()->insertOrIgnore([
            [
                'key' => 'ecommerce_store_name',
                'value' => $storeLocator->name,
            ],
            [
                'key' => 'ecommerce_store_phone',
                'value' => $storeLocator->phone,
            ],
            [
                'key' => 'ecommerce_store_address',
                'value' => $storeLocator->address,
            ],
            [
                'key' => 'ecommerce_store_state',
                'value' => $storeLocator->state,
            ],
            [
                'key' => 'ecommerce_store_city',
                'value' => $storeLocator->city,
            ],
            [
                'key' => 'ecommerce_store_country',
                'value' => $storeLocator->country,
            ],
        ]);
    }
}
