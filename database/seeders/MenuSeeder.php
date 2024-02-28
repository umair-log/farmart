<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Language\Models\LanguageMeta;
use Botble\Menu\Models\Menu as MenuModel;
use Botble\Menu\Models\MenuLocation;
use Botble\Menu\Models\MenuNode;
use Botble\Page\Models\Page;
use Illuminate\Support\Arr;
use Menu;

class MenuSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = [
            'en_US' => [
                [
                    'name' => 'Main menu',
                    'slug' => 'main-menu',
                    'location' => 'main-menu',
                    'items' => [
                        [
                            'title' => 'Special Prices',
                            'url' => '/products/smart-watches',
                            'icon_font' => 'icon icon-tag',
                        ],
                        [
                            'title' => 'Pages',
                            'url' => '#',
                            'children' => [
                                [
                                    'title' => 'About us',
                                    'reference_id' => 2,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Terms Of Use',
                                    'reference_id' => 3,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Terms & Conditions',
                                    'reference_id' => 4,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Refund Policy',
                                    'reference_id' => 5,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Coming soon',
                                    'reference_id' => 12,
                                    'reference_type' => Page::class,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Shop',
                            'url' => '/products',
                            'children' => [
                                [
                                    'title' => 'All products',
                                    'url' => '/products',
                                ],
                                [
                                    'title' => 'Products Of Category',
                                    'reference_id' => 15,
                                    'reference_type' => ProductCategory::class,
                                ],
                                [
                                    'title' => 'Product Single',
                                    'url' => '/products/beat-headphone',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Stores',
                            'url' => '/stores',
                        ],
                        [
                            'title' => 'Blog',
                            'reference_id' => 6,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'FAQs',
                            'reference_id' => 7,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Contact',
                            'reference_id' => 8,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Header menu',
                    'slug' => 'header-menu',
                    'location' => 'header-navigation',
                    'items' => [
                        [
                            'title' => 'About Us',
                            'reference_id' => 2,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Wishlist',
                            'url' => 'wishlist',
                        ],
                        [
                            'title' => 'Order Tracking',
                            'url' => 'orders/tracking',
                        ],
                    ],
                ],
                [
                    'name' => 'Useful Links',
                    'slug' => 'useful-links',
                    'items' => [
                        [
                            'title' => 'Terms Of Use',
                            'reference_id' => 3,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Terms & Conditions',
                            'reference_id' => 4,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Refund Policy',
                            'reference_id' => 5,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'FAQs',
                            'reference_id' => 7,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => '404 Page',
                            'url' => '/nothing',
                        ],
                    ],
                ],
                [
                    'name' => 'Help Center',
                    'slug' => 'help-center',
                    'items' => [
                        [
                            'title' => 'About us',
                            'reference_id' => 2,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Affiliate',
                            'reference_id' => 10,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Career',
                            'reference_id' => 11,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Contact us',
                            'reference_id' => 8,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Business',
                    'slug' => 'business',
                    'items' => [
                        [
                            'title' => 'Our blog',
                            'reference_id' => 6,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Cart',
                            'url' => '/cart',
                        ],
                        [
                            'title' => 'My account',
                            'url' => '/customer/overview',
                        ],
                        [
                            'title' => 'Shop',
                            'url' => '/products',
                        ],
                    ],
                ],
            ],
            'vi' => [
                [
                    'name' => 'Menu chính',
                    'slug' => 'menu-chinh',
                    'location' => 'main-menu',
                    'items' => [
                        [
                            'title' => 'Trang chủ',
                            'url' => '/',
                        ],
                        [
                            'title' => 'Trang',
                            'url' => '#',
                            'children' => [
                                [
                                    'title' => 'Về chúng tôi',
                                    'reference_id' => 2,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Điều khoản sử dụng',
                                    'reference_id' => 3,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Điều khoản và quy định',
                                    'reference_id' => 4,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Chính sách hoàn hàng',
                                    'reference_id' => 5,
                                    'reference_type' => Page::class,
                                ],
                                [
                                    'title' => 'Sắp ra mắt',
                                    'reference_id' => 12,
                                    'reference_type' => Page::class,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Sản phẩm',
                            'url' => '/products',
                            'children' => [
                                [
                                    'title' => 'Tất cả sản phẩm',
                                    'url' => '/products',
                                ],
                                [
                                    'title' => 'Danh mục sản phẩm',
                                    'reference_id' => 15,
                                    'reference_type' => ProductCategory::class,
                                ],
                                [
                                    'title' => 'Sản phẩm chi tiết',
                                    'url' => '/products/beat-headphone',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Cửa hàng',
                            'url' => '/stores',
                        ],
                        [
                            'title' => 'Tin tức',
                            'reference_id' => 6,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'FAQs',
                            'reference_id' => 7,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Liên hệ',
                            'reference_id' => 8,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Liên kết hữu ích',
                    'slug' => 'lien-ket-huu-ich',
                    'items' => [
                        [
                            'title' => 'Điều khoản sử dụng',
                            'reference_id' => 3,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Điều khoản và quy định',
                            'reference_id' => 4,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Chính sách hoàn hàng',
                            'reference_id' => 5,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'FAQs',
                            'reference_id' => 6,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => '404 Page',
                            'url' => '/nothing',
                        ],
                    ],
                ],
                [
                    'name' => 'Menu trên cùng',
                    'slug' => 'menu-tren-cung',
                    'location' => 'header-navigation',
                    'items' => [
                        [
                            'title' => 'Về chúng tôi',
                            'reference_id' => 2,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Danh sách ưa thích',
                            'url' => 'wishlist',
                        ],
                        [
                            'title' => 'Theo dõi đơn hàng',
                            'url' => 'orders/tracking',
                        ],
                    ],
                ],
                [
                    'name' => 'Trung tâm trợ giúp',
                    'slug' => 'trung-tam-tro-giup',
                    'items' => [
                        [
                            'title' => 'Về chúng tôi',
                            'reference_id' => 2,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Tiếp thị liên kết',
                            'reference_id' => 10,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Tuyển dụng',
                            'reference_id' => 11,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Liên hệ',
                            'reference_id' => 8,
                            'reference_type' => Page::class,
                        ],
                    ],
                ],
                [
                    'name' => 'Doanh nghiệp',
                    'slug' => 'doanh-nghiep',
                    'items' => [
                        [
                            'title' => 'Tin tức',
                            'reference_id' => 6,
                            'reference_type' => Page::class,
                        ],
                        [
                            'title' => 'Giỏ hàng',
                            'url' => '/cart',
                        ],
                        [
                            'title' => 'Tài khoản',
                            'url' => '/customer/overview',
                        ],
                        [
                            'title' => 'Sản phẩm',
                            'url' => '/products',
                        ],
                    ],
                ],
            ],
        ];

        MenuModel::query()->truncate();
        MenuLocation::query()->truncate();
        MenuNode::query()->truncate();
        MetaBoxModel::query()->where('reference_type', MenuNode::class)->delete();
        LanguageMeta::query()->where('reference_type', MenuModel::class)->delete();
        LanguageMeta::query()->where('reference_type', MenuLocation::class)->delete();

        foreach ($data as $locale => $menus) {
            foreach ($menus as $index => $item) {
                $menu = MenuModel::query()->create(Arr::except($item, ['items', 'location']));

                if (isset($item['location'])) {
                    $menuLocation = MenuLocation::query()->create([
                        'menu_id' => $menu->id,
                        'location' => $item['location'],
                    ]);

                    $originValue = LanguageMeta::query()->where([
                        'reference_id' => $locale == 'en_US' ? $menu->id : $menu->id + 3,
                        'reference_type' => MenuLocation::class,
                    ])->value('lang_meta_origin');

                    LanguageMeta::saveMetaData($menuLocation, $locale, $originValue);
                }

                foreach ($item['items'] as $menuNode) {
                    $this->createMenuNode($index, $menuNode, $locale, $menu->id);
                }

                $originValue = null;

                if ($locale !== 'en_US') {
                    $originValue = LanguageMeta::query()->where([
                        'reference_id' => $index + 1,
                        'reference_type' => MenuModel::class,
                    ])->value('lang_meta_origin');
                }

                LanguageMeta::saveMetaData($menu, $locale, $originValue);
            }
        }

        Menu::clearCacheMenuItems();
    }

    /**
     * @param int $index
     * @param array $menuNode
     * @param string $locale
     * @param int $menuId
     * @param int $parentId
     */
    protected function createMenuNode(int $index, array $menuNode, string $locale, int $menuId, int $parentId = 0): void
    {
        $menuNode['menu_id'] = $menuId;
        $menuNode['parent_id'] = $parentId;

        if (isset($menuNode['url'])) {
            $menuNode['url'] = str_replace(url(''), '', $menuNode['url']);
        }

        if (Arr::has($menuNode, 'children')) {
            $children = $menuNode['children'];
            $menuNode['has_child'] = true;

            unset($menuNode['children']);
        } else {
            $children = [];
            $menuNode['has_child'] = false;
        }

        $createdNode = MenuNode::query()->create($menuNode);

        if ($children) {
            foreach ($children as $child) {
                $this->createMenuNode($index, $child, $locale, $menuId, $createdNode->id);
            }
        }
    }
}
