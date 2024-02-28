<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Base\Facades\MetaBox;
use Botble\Slug\Facades\SlugHelper;

class ProductCategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('product-categories');

        $categories = [
            [
                'name' => 'Fruits & Vegetables',
                'is_featured' => true,
                'image' => 'product-categories/1.png',
                'icon' => 'icon-star',
                'children' => [
                    [
                        'name' => 'Fruits',
                        'children' => [
                            ['name' => 'Apples'],
                            ['name' => 'Bananas'],
                            ['name' => 'Berries'],
                            ['name' => 'Oranges & Easy Peelers'],
                            ['name' => 'Grapes'],
                            ['name' => 'Lemons & Limes'],
                            ['name' => 'Peaches & Nectarines'],
                            ['name' => 'Pears'],
                            ['name' => 'Melon'],
                            ['name' => 'Avocados'],
                            ['name' => 'Plums & Apricots'],
                        ],
                    ],
                    [
                        'name' => 'Vegetables',
                        'children' => [
                            ['name' => 'Potatoes'],
                            ['name' => 'Carrots & Root Vegetables'],
                            ['name' => 'Broccoli & Cauliflower'],
                            ['name' => 'Cabbage, Spinach & Greens'],
                            ['name' => 'Onions, Leeks & Garlic'],
                            ['name' => 'Mushrooms'],
                            ['name' => 'Tomatoes'],
                            ['name' => 'Beans, Peas & Sweetcorn'],
                            ['name' => 'Freshly Drink Orange Juice'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Breads Sweets',
                'is_featured' => true,
                'image' => 'product-categories/2.png',
                'icon' => 'icon-bread',
                'children' => [
                    [
                        'name' => 'Crisps, Snacks & Nuts',
                        'children' => [
                            ['name' => 'Crisps & Popcorn'],
                            ['name' => 'Nuts & Seeds'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Cereal Bars'],
                            ['name' => 'Breadsticks & Pretzels'],
                            ['name' => 'Fruit Snacking'],
                            ['name' => 'Rice & Corn Cakes'],
                            ['name' => 'Protein & Energy Snacks'],
                            ['name' => 'Toddler Snacks'],
                            ['name' => 'Meat Snacks'],
                            ['name' => 'Beans'],
                            ['name' => 'Lentils'],
                            ['name' => 'Chickpeas'],
                        ],
                    ],
                    [
                        'name' => 'Tins & Cans',
                        'children' => [
                            ['name' => 'Tomatoes'],
                            ['name' => 'Baked Beans, Spaghetti'],
                            ['name' => 'Fish'],
                            ['name' => 'Beans & Pulses'],
                            ['name' => 'Fruit'],
                            ['name' => 'Coconut Milk & Cream'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Olives'],
                            ['name' => 'Sweetcorn'],
                            ['name' => 'Carrots'],
                            ['name' => 'Peas'],
                            ['name' => 'Mixed Vegetables'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Frozen Seafoods',
                'is_featured' => true,
                'image' => 'product-categories/3.png',
                'icon' => 'icon-hamburger',
            ],
            [
                'name' => 'Raw Meats',
                'is_featured' => true,
                'image' => 'product-categories/4.png',
                'icon' => 'icon-steak',
            ],
            [
                'name' => 'Wines & Alcohol Drinks',
                'is_featured' => true,
                'image' => 'product-categories/5.png',
                'icon' => 'icon-glass',
                'children' => [
                    [
                        'name' => 'Ready Meals',
                        'children' => [
                            ['name' => 'Meals for 1'],
                            ['name' => 'Meals for 2'],
                            ['name' => 'Indian'],
                            ['name' => 'Italian'],
                            ['name' => 'Chinese'],
                            ['name' => 'Traditional British'],
                            ['name' => 'Thai & Oriental'],
                            ['name' => 'Mediterranean & Moroccan'],
                            ['name' => 'Mexican & Caribbean'],
                            ['name' => 'Lighter Meals'],
                            ['name' => 'Lunch & Veg Pots'],
                        ],
                    ],
                    [
                        'name' => 'Salad & Herbs',
                        'children' => [
                            ['name' => 'Salad Bags'],
                            ['name' => 'Cucumber'],
                            ['name' => 'Tomatoes'],
                            ['name' => 'Lettuce'],
                            ['name' => 'Lunch Salad Bowls'],
                            ['name' => 'Lunch Salad Bowls'],
                            ['name' => 'Fresh Herbs'],
                            ['name' => 'Avocados'],
                            ['name' => 'Peppers'],
                            ['name' => 'Coleslaw & Potato Salad'],
                            ['name' => 'Spring Onions'],
                            ['name' => 'Chilli, Ginger & Garlic'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Tea & Coffee',
                'is_featured' => true,
                'image' => 'product-categories/6.png',
                'icon' => 'icon-teacup',
            ],
            [
                'name' => 'Milks and Dairies',
                'is_featured' => true,
                'image' => 'product-categories/7.png',
                'icon' => 'icon-coffee-cup',
            ],
            [
                'name' => 'Pet Foods',
                'is_featured' => true,
                'image' => 'product-categories/8.png',
                'icon' => 'icon-hotdog',
            ],
            [
                'name' => 'Food Cupboard',
                'is_featured' => true,
                'image' => 'product-categories/1.png',
                'icon' => 'icon-cheese',

            ],
        ];

        ProductCategory::query()->truncate();
        Slug::query()->where('reference_type', ProductCategory::class)->delete();
        MetaBoxModel::query()->where('reference_type', ProductCategory::class)->delete();

        foreach ($categories as $index => $item) {
            $this->createCategoryItem($index, $item);
        }

        // Translations
        DB::table('ec_product_categories_translations')->truncate();

        $translations = [
            [
                'name' => 'Rau củ quả',
                'children' => [
                    [
                        'name' => 'Trái cây',
                        'children' => [
                            ['name' => 'Táo'],
                            ['name' => 'Chuối'],
                            ['name' => 'Quả Mọng'],
                            ['name' => 'Cam'],
                            ['name' => 'Nho'],
                            ['name' => 'Chanh'],
                            ['name' => 'Quả Đào'],
                            ['name' => 'Lê'],
                            ['name' => 'Dưa Gang'],
                            ['name' => 'Bơ'],
                            ['name' => 'Mận & Mơ'],
                        ],
                    ],
                    [
                        'name' => 'Rau',
                        'children' => [
                            ['name' => 'Khoai Tây'],
                            ['name' => 'Cà rốt'],
                            ['name' => 'Bông cải xanh & súp lơ trắng'],
                            ['name' => 'Bắp cải, rau bina & rau xanh'],
                            ['name' => 'Hành tây, tỏi tây'],
                            ['name' => 'Nấm'],
                            ['name' => 'Cà chua'],
                            ['name' => 'Đậu, Đậu Hà Lan & Bắp rang bơ'],
                            ['name' => 'Nước uống tươi'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Bánh mì kẹo',
                'children' => [
                    [
                        'name' => 'Crisps, Snack & Nuts',
                        'children' => [
                            ['name' => 'Khoai tây chiên giòn & bỏng ngô'],
                            ['name' => 'Nuts & Seeds'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Cereal Bars'],
                            ['name' => 'Bánh mì que & Pretzels'],
                            ['name' => 'Fruit Snacking'],
                            ['name' => 'Bánh gạo'],
                            ['name' => 'Protein & Energy Snacks'],
                            ['name' => 'Toddler Snacks'],
                            ['name' => 'Meat Snacks'],
                            ['name' => 'Đậu'],
                            ['name' => 'Lentils'],
                            ['name' => 'Chickpeas'],
                        ],
                    ],
                    [
                        'name' => 'Tins & Cans',
                        'children' => [
                            ['name' => 'Khoai tây'],
                            ['name' => 'Baked Beans, Spaghetti'],
                            ['name' => 'Cá'],
                            ['name' => 'Đậu & Pulses'],
                            ['name' => 'Trái cây'],
                            ['name' => 'Coconut Milk & Cream'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Olives'],
                            ['name' => 'Sweetcorn'],
                            ['name' => 'Cà rốt'],
                            ['name' => 'Đậu Hà Lan'],
                            ['name' => 'Mixed Vegetables'],
                        ],
                    ],
                ],
            ],
            ['name' => 'Hải sản đông lạnh'],
            ['name' => 'Thịt sống'],
            [
                'name' => 'Rượu & Đồ uống có cồn',
                'children' => [
                    [
                        'name' => 'Ready Meals',
                        'children' => [
                            ['name' => 'Meals for 1'],
                            ['name' => 'Meals for 2'],
                            ['name' => 'Indian'],
                            ['name' => 'Italian'],
                            ['name' => 'Chinese'],
                            ['name' => 'Traditional British'],
                            ['name' => 'Thai & Oriental'],
                            ['name' => 'Mediterranean & Moroccan'],
                            ['name' => 'Mexican & Caribbean'],
                            ['name' => 'Lighter Meals'],
                            ['name' => 'Lunch & Veg Pots'],
                        ],
                    ],
                    [
                        'name' => 'Salad & thảo mộc',
                        'children' => [
                            ['name' => 'Túi đựng salad'],
                            ['name' => 'Quả dưa chuột'],
                            ['name' => 'Cà chua'],
                            ['name' => 'Rau xà lách'],
                            ['name' => 'Lunch Salad Bowls'],
                            ['name' => 'Fresh Herbs'],
                            ['name' => 'Avocados'],
                            ['name' => 'Peppers'],
                            ['name' => 'Coleslaw & Potato Salad'],
                            ['name' => 'Spring Onions'],
                            ['name' => 'Chilli, Ginger & Garlic'],
                        ],
                    ],
                ],
            ],
            ['name' => 'Trà & Cà phê'],
            ['name' => 'Sữa và các loại sữa'],
            ['name' => 'Thức ăn cho thú cưng'],
            ['name' => 'Tủ đựng thức ăn'],
        ];

        $count = 1;
        foreach ($translations as $translation) {
            $this->createCategoryItemTrans($count, $translation);
        }
    }

    /**
     * @param int $index
     * @param array $category
     * @param int $parentId
     */
    protected function createCategoryItem(int $index, array $category, int $parentId = 0): void
    {
        $category['parent_id'] = $parentId;
        $category['order'] = $index;

        if (Arr::has($category, 'children')) {
            $children = $category['children'];
            unset($category['children']);
        } else {
            $children = [];
        }

        $createdCategory = ProductCategory::query()->create(Arr::except($category, ['icon']));

        Slug::query()->create([
            'reference_type' => ProductCategory::class,
            'reference_id' => $createdCategory->id,
            'key' => Str::slug($createdCategory->name),
            'prefix' => SlugHelper::getPrefix(ProductCategory::class),
        ]);

        if (isset($category['icon'])) {
            MetaBox::saveMetaBoxData($createdCategory, 'icon', $category['icon']);
        }

        if ($children) {
            foreach ($children as $childIndex => $child) {
                $this->createCategoryItem($childIndex, $child, $createdCategory->id);
            }
        }
    }

    protected function createCategoryItemTrans(int &$count, array $translation): void
    {
        $translation['lang_code'] = 'vi';
        $translation['ec_product_categories_id'] = $count;

        DB::table('ec_product_categories_translations')->insert(Arr::except($translation, ['children']));

        $count++;

        if (Arr::get($translation, 'children')) {
            foreach ($translation['children'] as $child) {
                $this->createCategoryItemTrans($count, $child);
            }
        }
    }
}
