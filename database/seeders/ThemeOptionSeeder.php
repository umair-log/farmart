<?php

namespace Database\Seeders;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Supports\BaseSeeder;
use Botble\Setting\Models\Setting;
use Carbon\Carbon;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Support\Arr;

class ThemeOptionSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('general');

        $theme = Arr::first(BaseHelper::scanFolder(theme_path()));
        Setting::query()->where('key', 'LIKE', 'theme-' . $theme . '-%')->delete();
        Setting::query()->whereIn('key', ['admin_logo', 'admin_favicon'])->delete();

        Setting::query()->insertOrIgnore([
            [
                'key' => 'theme',
                'value' => $theme,
            ],
            [
                'key' => 'admin_favicon',
                'value' => 'general/favicon.png',
            ],
            [
                'key' => 'admin_logo',
                'value' => 'general/logo-light.png',
            ],
            [
                'key' => 'theme-' . $theme . '-site_title',
                'value' => 'Farmart - Laravel Ecommerce system',
            ],
            [
                'key' => 'theme-' . $theme . '-seo_description',
                'value' => 'Farmart is a modern and flexible Multipurpose Marketplace Laravel script. This script is suited for electronic, organic and grocery store, furniture store, clothing store, hitech store and accessories store… With the theme, you can create your own marketplace and allow vendors to sell just like Amazon, Envato, eBay…',
            ],
            [
                'key' => 'theme-' . $theme . '-copyright',
                'value' => '© ' . Carbon::now()->format('Y') . ' Farmart. All Rights Reserved.',
            ],
            [
                'key' => 'theme-' . $theme . '-favicon',
                'value' => 'general/favicon.png',
            ],
            [
                'key' => 'theme-' . $theme . '-logo',
                'value' => 'general/logo.png',
            ],
            [
                'key' => 'theme-' . $theme . '-seo_og_image',
                'value' => 'general/open-graph-image.png',
            ],
            [
                'key' => 'theme-' . $theme . '-image-placeholder',
                'value' => 'general/placeholder.png',
            ],
            [
                'key' => 'theme-' . $theme . '-address',
                'value' => '502 New Street, Brighton VIC, Australia',
            ],
            [
                'key' => 'theme-' . $theme . '-hotline',
                'value' => '8 800 332 65-66',
            ],
            [
                'key' => 'theme-' . $theme . '-email',
                'value' => 'contact@fartmart.co',
            ],
            [
                'key' => 'theme-' . $theme . '-working_time',
                'value' => 'Mon - Fri: 07AM - 06PM',
            ],
            [
                'key' => 'theme-' . $theme . '-payment_methods_image',
                'value' => 'general/footer-payments.png',
            ],
            [
                'key' => 'theme-' . $theme . '-homepage_id',
                'value' => '1',
            ],
            [
                'key' => 'theme-' . $theme . '-blog_page_id',
                'value' => '6',
            ],
            [
                'key' => 'theme-' . $theme . '-cookie_consent_message',
                'value' => 'Your experience on this site will be improved by allowing cookies ',
            ],
            [
                'key' => 'theme-' . $theme . '-cookie_consent_learn_more_url',
                'value' => url('cookie-policy'),
            ],
            [
                'key' => 'theme-' . $theme . '-cookie_consent_learn_more_text',
                'value' => 'Cookie Policy',
            ],
            [
                'key' => 'theme-' . $theme . '-number_of_products_per_page',
                'value' => 40,
            ],
            [
                'key' => 'theme-' . $theme . '-number_of_cross_sale_product',
                'value' => 6,
            ],
            [
                'key' => 'theme-' . $theme . '-logo_in_the_checkout_page',
                'value' => 'general/logo.png',
            ],
            [
                'key' => 'theme-' . $theme . '-logo_in_invoices',
                'value' => 'general/logo.png',
            ],
            [
                'key' => 'theme-' . $theme . '-logo_vendor_dashboard',
                'value' => 'general/logo.png',
            ],
            [
                'key' => 'theme-' . $theme . '-404_page_image',
                'value' => 'general/404.png',
            ],
        ]);

        $socialLinks = [
            [
                [
                    'key' => 'social-name',
                    'value' => 'Facebook',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'general/facebook.png',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://www.facebook.com/',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Twitter',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'general/twitter.png',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://www.twitter.com/',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Instagram',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'general/instagram.png',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://www.instagram.com/',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Pinterest',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'general/pinterest.png',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://www.pinterest.com/',
                ],
            ],
            [
                [
                    'key' => 'social-name',
                    'value' => 'Youtube',
                ],
                [
                    'key' => 'social-icon',
                    'value' => 'general/youtube.png',
                ],
                [
                    'key' => 'social-url',
                    'value' => 'https://www.youtube.com/',
                ],
            ],
        ];

        Setting::query()->insertOrIgnore([
            'key' => 'theme-' . $theme . '-social_links',
            'value' => json_encode($socialLinks),
        ]);

        Setting::query()->insertOrIgnore([
            [
                'key' => 'theme-' . $theme . '-vi-copyright',
                'value' => '© ' . Carbon::now()->format('Y') . ' Farmart. Tất cả quyền đã được bảo hộ.',
            ],
            [
                'key' => 'theme-' . $theme . '-vi-homepage_id',
                'value' => '1',
            ],
            [
                'key' => 'theme-' . $theme . '-vi-blog_page_id',
                'value' => '6',
            ],
            [
                'key' => 'theme-' . $theme . '-vi-cookie_consent_message',
                'value' => 'Trải nghiệm của bạn trên trang web này sẽ được cải thiện bằng cách cho phép cookie ',
            ],
            [
                'key' => 'theme-' . $theme . '-vi-cookie_consent_learn_more_url',
                'value' => url('cookie-policy'),
            ],
            [
                'key' => 'theme-' . $theme . '-vi-cookie_consent_learn_more_text',
                'value' => 'Chính sách cookie',
            ],
            [
                'key' => EcommerceHelper::getSettingPrefix() . 'is_enabled_support_digital_products',
                'value' => '1',
            ],
        ]);
    }
}
