<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        $this->call([
            LanguageSeeder::class,
            BrandSeeder::class,
            CurrencySeeder::class,
            ProductCategorySeeder::class,
            ProductCollectionSeeder::class,
            ProductLabelSeeder::class,
            ProductSeeder::class,
            ProductAttributeSeeder::class,
            CustomerSeeder::class,
            ReviewSeeder::class,
            TaxSeeder::class,
            ProductTagSeeder::class,
            FlashSaleSeeder::class,
            ShippingSeeder::class,
            ContactSeeder::class,
            BlogSeeder::class,
            SimpleSliderSeeder::class,
            PageSeeder::class,
            AdsSeeder::class,
            FaqSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            StoreLocatorSeeder::class,
            MenuSeeder::class,
            ThemeOptionSeeder::class,
            WidgetSeeder::class,
            ProductOptionSeeder::class,
        ]);

        if (is_plugin_active('marketplace')) {
            $this->call(MarketplaceSeeder::class);
        }

        $this->call(OrderEcommerceSeeder::class);

        $this->finished();
    }
}
