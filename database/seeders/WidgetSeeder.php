<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Widget\Models\Widget as WidgetModel;
use Theme;

class WidgetSeeder extends BaseSeeder
{
    public function run(): void
    {
        WidgetModel::query()->truncate();

        $data = [
            'en_US' => [
                [
                    'widget_id' => 'SiteInfoWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'SiteInfoWidget',
                        'name' => 'Farmart – Your Online Foods & Grocery',
                        'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed finibus viverra iaculis. Etiam vulputate et justo eget scelerisque.',
                        'phone' => '(+965) 7492-4277',
                        'address' => '959 Homestead Street Eastlake, NYC',
                        'email' => 'support@farmart.com',
                        'working_time' => 'Mon - Fri: 07AM - 06PM',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Useful Links',
                        'menu_id' => 'useful-links',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Help Center',
                        'menu_id' => 'help-center',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Business',
                        'menu_id' => 'business',
                    ],
                ],
                [
                    'widget_id' => 'NewsletterWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'NewsletterWidget',
                        'title' => 'Newsletter',
                        'subtitle' => 'Register now to get updates on promotions and coupon. Don’t worry! We not spam',
                    ],
                ],
                [
                    'widget_id' => 'BlogSearchWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'BlogSearchWidget',
                        'name' => 'Search',
                    ],
                ],
                [
                    'widget_id' => 'BlogCategoriesWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'BlogCategoriesWidget',
                        'name' => 'Categories',
                    ],
                ],
                [
                    'widget_id' => 'RecentPostsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'RecentPostsWidget',
                        'name' => 'Recent Posts',
                    ],
                ],
                [
                    'widget_id' => 'BlogTagsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'BlogTagsWidget',
                        'name' => 'Popular Tags',
                    ],
                ],
                [
                    'widget_id' => 'SiteFeaturesWidget',
                    'sidebar_id' => 'pre_footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'SiteFeaturesWidget',
                        'title' => 'Site Features',
                        'data' => [
                            1 => [
                                'icon' => 'general/icon-rocket.png',
                                'title' => 'Free Shipping',
                                'subtitle' => 'For all orders over $200',
                            ],
                            2 => [
                                'icon' => 'general/icon-reload.png',
                                'title' => '1 & 1 Returns',
                                'subtitle' => 'Cancellation after 1 day',
                            ],
                            3 => [
                                'icon' => 'general/icon-protect.png',
                                'title' => '100% Secure Payment',
                                'subtitle' => 'Guarantee secure payments',
                            ],
                            4 => [
                                'icon' => 'general/icon-support.png',
                                'title' => '24/7 Dedicated Support',
                                'subtitle' => 'Anywhere & anytime',
                            ],
                            5 => [
                                'icon' => 'general/icon-tag.png',
                                'title' => 'Daily Offers',
                                'subtitle' => 'Discount up to 70% OFF',
                            ],
                        ],
                    ],
                ],
                [
                    'widget_id' => 'AdsWidget',
                    'sidebar_id' => 'products_list_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'AdsWidget',
                        'title' => 'Ads',
                        'ads_key' => 'ZDOZUZZIU7FZ',
                        'background' => 'general/background.jpg',
                        'size' => 'full-width',
                    ],
                ],
                [
                    'widget_id' => 'SiteFeaturesWidget',
                    'sidebar_id' => 'product_detail_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'SiteFeaturesWidget',
                        'title' => 'Site Features',
                        'data' => [
                            1 => [
                                'icon' => 'general/icon-rocket.png',
                                'title' => 'Free Shipping',
                                'subtitle' => 'For all orders over $200',
                            ],
                            2 => [
                                'icon' => 'general/icon-reload.png',
                                'title' => '1 & 1 Returns',
                                'subtitle' => 'Cancellation after 1 day',
                            ],
                            3 => [
                                'icon' => 'general/icon-protect.png',
                                'title' => 'Secure Payment',
                                'subtitle' => 'Guarantee secure payments',
                            ],
                        ],
                    ],
                ],
                [
                    'widget_id' => 'SiteInfoWidget',
                    'sidebar_id' => 'product_detail_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'SiteInfoWidget',
                        'name' => 'Store information',
                        'phone' => '(+965) 7492-4277',
                        'working_time' => 'Mon - Fri: 07AM - 06PM',
                    ],
                ],
                [
                    'widget_id' => 'BecomeVendorWidget',
                    'sidebar_id' => 'product_detail_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'BecomeVendorWidget',
                        'name' => 'Become a Vendor?',
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Consumer Electric',
                        'categories' => [18, 2, 3, 4, 5, 6, 7],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Clothing & Apparel',
                        'categories' => [8, 9, 10, 11, 12],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Home, Garden & Kitchen',
                        'categories' => [13, 14, 15, 16, 17],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Health & Beauty',
                        'categories' => [20, 21, 22, 23, 24],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 5,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Computer & Technologies',
                        'categories' => [25, 26, 27, 28, 29, 19],
                    ],
                ],
            ],
            'vi' => [
                [
                    'widget_id' => 'SiteInfoWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 0,
                    'data' => [
                        'id' => 'SiteInfoWidget',
                        'name' => 'Farmart – Thực phẩm & hàng hóa trực tuyến',
                        'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed finibus viverra iaculis. Etiam vulputate et justo eget scelerisque.',
                        'phone' => '(+965) 7492-4277',
                        'address' => '959 Homestead Street Eastlake, NYC',
                        'email' => 'support@farmart.com',
                        'working_time' => 'Mon - Fri: 07AM - 06PM',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Liên kết hữu ích',
                        'menu_id' => 'lien-ket-huu-ich',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Trung tâm trợ giúp',
                        'menu_id' => 'trung-tam-tro-giup',
                    ],
                ],
                [
                    'widget_id' => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'CustomMenuWidget',
                        'name' => 'Doanh nghiệp',
                        'menu_id' => 'doanh-nghiep',
                    ],
                ],
                [
                    'widget_id' => 'NewsletterWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'NewsletterWidget',
                        'title' => 'Đăng ký bản tin',
                        'subtitle' => 'Đăng ký ngay để nhận được cập nhật về các chương trình khuyến mãi và phiếu giảm giá. Đừng lo! Chúng tôi không spam',
                    ],
                ],
                [
                    'widget_id' => 'BlogSearchWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'BlogSearchWidget',
                        'name' => 'Tìm kiếm',
                    ],
                ],
                [
                    'widget_id' => 'BlogCategoriesWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'BlogCategoriesWidget',
                        'name' => 'Danh mục bài viết',
                    ],
                ],
                [
                    'widget_id' => 'RecentPostsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'RecentPostsWidget',
                        'name' => 'Bài viết gần đây',
                    ],
                ],
                [
                    'widget_id' => 'TagsWidget',
                    'sidebar_id' => 'primary_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'TagsWidget',
                        'name' => 'Tags phổ biến',
                    ],
                ],
                [
                    'widget_id' => 'SiteFeaturesWidget',
                    'sidebar_id' => 'pre_footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'SiteFeaturesWidget',
                        'title' => 'Site Features',
                        'data' => [
                            1 => [
                                'icon' => 'general/icon-rocket.png',
                                'title' => 'Miễn phí vận chuyển',
                                'subtitle' => 'Đối với tất cả các đơn đặt hàng trên $200',
                            ],
                            2 => [
                                'icon' => 'general/icon-reload.png',
                                'title' => 'Đổi trả 1 & 1',
                                'subtitle' => 'Hủy sau 1 ngày',
                            ],
                            3 => [
                                'icon' => 'general/icon-protect.png',
                                'title' => 'Thanh toán an toàn 100%',
                                'subtitle' => 'Đảm bảo thanh toán an toàn',
                            ],
                            4 => [
                                'icon' => 'general/icon-support.png',
                                'title' => 'Hỗ trợ tận tâm 24/7',
                                'subtitle' => 'Mọi lúc mọi nơi',
                            ],
                            5 => [
                                'icon' => 'general/icon-tag.png',
                                'title' => 'Ưu đãi hàng ngày',
                                'subtitle' => 'GIẢM GIÁ lên đến 70%',
                            ],
                        ],
                    ],
                ],
                [
                    'widget_id' => 'AdsWidget',
                    'sidebar_id' => 'products_list_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'AdsWidget',
                        'title' => 'Ads',
                        'ads_key' => 'ZDOZUZZIU7FZ',
                        'background' => 'general/background.jpg',
                        'size' => 'full-width',
                    ],
                ],
                [
                    'widget_id' => 'SiteFeaturesWidget',
                    'sidebar_id' => 'product_detail_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'SiteFeaturesWidget',
                        'title' => 'Site Features',
                        'data' => [
                            1 => [
                                'icon' => 'general/icon-rocket.png',
                                'title' => 'Miễn phí vận chuyển',
                                'subtitle' => 'Đối với tất cả các đơn đặt hàng trên $200',
                            ],
                            2 => [
                                'icon' => 'general/icon-reload.png',
                                'title' => 'Đổi trả 1 & 1',
                                'subtitle' => 'Hủy sau 1 ngày',
                            ],
                            3 => [
                                'icon' => 'general/icon-protect.png',
                                'title' => 'Thanh toán an toàn',
                                'subtitle' => 'Đảm bảo thanh toán an toàn',
                            ],
                        ],
                    ],
                ],
                [
                    'widget_id' => 'SiteInfoWidget',
                    'sidebar_id' => 'product_detail_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'SiteInfoWidget',
                        'name' => 'Store information',
                        'phone' => '(+965) 7492-4277',
                        'working_time' => 'Mon - Fri: 07AM - 06PM',
                    ],
                ],
                [
                    'widget_id' => 'BecomeVendorWidget',
                    'sidebar_id' => 'product_detail_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'BecomeVendorWidget',
                        'name' => 'Trở thành nhà bán hàng?',
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 1,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Điện gia dụng',
                        'categories' => [18, 2, 3, 4, 5, 6, 7],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 2,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Quần áo và trang phục',
                        'categories' => [8, 9, 10, 11, 12],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 3,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Nhà, Vườn & Nhà bếp',
                        'categories' => [13, 14, 15, 16, 17],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 4,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Sức khỏe & Làm đẹp',
                        'categories' => [20, 21, 22, 23, 24],
                    ],
                ],
                [
                    'widget_id' => 'ProductCategoriesWidget',
                    'sidebar_id' => 'bottom_footer_sidebar',
                    'position' => 5,
                    'data' => [
                        'id' => 'ProductCategoriesWidget',
                        'name' => 'Máy tính & Công nghệ',
                        'categories' => [25, 26, 27, 28, 29, 19],
                    ],
                ],
            ],
        ];

        $theme = Theme::getThemeName();

        foreach ($data as $locale => $widgets) {
            foreach ($widgets as $item) {
                $item['theme'] = $locale == 'en_US' ? $theme : ($theme . '-' . $locale);
                WidgetModel::query()->create($item);
            }
        }
    }
}
