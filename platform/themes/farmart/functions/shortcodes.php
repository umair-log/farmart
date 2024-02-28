<?php

use Botble\Ads\Models\Ads;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Botble\Theme\Supports\ThemeSupport;
use Illuminate\Support\Str;
use Theme\Farmart\Http\Resources\ProductCategoryResource;
use Theme\Farmart\Http\Resources\ProductCollectionResource;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    function image_placeholder(?string $default = null, ?string $size = null): string
    {
        if (theme_option('lazy_load_image_enabled', 'yes') != 'yes' && $default) {
            if (Str::contains($default, 'https://') || Str::contains($default, 'http://')) {
                return $default;
            }

            return RvMedia::getImageUrl($default, $size);
        }

        if (! theme_option('image-placeholder')) {
            return Theme::asset()->url('images/placeholder.png');
        }

        return RvMedia::getImageUrl(theme_option('image-placeholder'));
    }

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.sliders';
        }, 120);

        add_filter(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, function ($data, $key, $attributes) {
            if ($key == 'simple-slider' && is_plugin_active('ads')) {
                $ads = AdsManager::getData(true, true);

                $defaultAutoplay = 'yes';

                return $data . Theme::partial('shortcodes.includes.autoplay-settings', compact('attributes', 'defaultAutoplay')) . Theme::partial('shortcodes.select-ads-admin-config', compact('ads', 'attributes'));
            }

            return $data;
        }, 50, 3);
    }

    if (is_plugin_active('ads')) {
        function get_ads_from_key(string|null $key): Ads|null
        {
            if (! $key) {
                return null;
            }

            $ads = AdsManager::getData(true)->firstWhere('key', $key);

            if (! $ads || ! $ads->image) {
                return null;
            }

            return $ads;
        }

        function display_ads_advanced(?string $key, array $attributes = []): ?string
        {
            $ads = get_ads_from_key($key);

            if (! $ads) {
                return null;
            }

            $image = Html::image(image_placeholder($ads->image), $ads->name, ['class' => 'lazyload', 'data-src' => RvMedia::getImageUrl($ads->image)])->toHtml();

            if ($ads->url) {
                $image = Html::link(route('public.ads-click', $ads->key), $image, array_merge($attributes, ['target' => '_blank']), null, false)
                    ->toHtml();
            } elseif ($attributes) {
                $image = Html::tag('div', $image, $attributes)->toHtml();
            }

            return $image;
        }

        add_shortcode('theme-ads', __('Theme ads'), __('Theme ads'), function ($shortcode) {
            $ads = [];
            $attributes = $shortcode->toArray();

            for ($i = 1; $i < 5; $i++) {
                if (isset($attributes['key_' . $i]) && ! empty($attributes['key_' . $i])) {
                    $ad = display_ads_advanced((string)$attributes['key_' . $i]);
                    if ($ad) {
                        $ads[] = $ad;
                    }
                }
            }

            $ads = array_filter($ads);

            return Theme::partial('shortcodes.ads.theme-ads', compact('ads'));
        });

        shortcode()->setAdminConfig('theme-ads', function ($attributes) {
            $ads = AdsManager::getData(true, true);

            return Theme::partial('shortcodes.ads.theme-ads-admin-config', compact('ads', 'attributes'));
        });
    }

    if (is_plugin_active('ecommerce')) {
        add_shortcode(
            'featured-product-categories',
            __('Featured Product Categories'),
            __('Featured Product Categories'),
            function ($shortcode) {
                return Theme::partial('shortcodes.ecommerce.featured-product-categories', compact('shortcode'));
            }
        );

        shortcode()->setAdminConfig('featured-product-categories', function ($attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-product-categories-admin-config', compact('attributes'));
        });

        add_shortcode('featured-brands', __('Featured Brands'), __('Featured Brands'), function ($shortcode) {
            return Theme::partial('shortcodes.ecommerce.featured-brands', compact('shortcode'));
        });

        shortcode()->setAdminConfig('featured-brands', function ($attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-brands-admin-config', compact('attributes'));
        });

        add_shortcode('flash-sale', __('Flash sale'), __('Flash sale'), function ($shortcode) {
            $flashSale = app(FlashSaleInterface::class)->getModel()
                ->where('id', $shortcode->flash_sale_id)
                ->notExpired()
                ->first();

            if (! $flashSale || ! $flashSale->products()->count()) {
                return null;
            }

            return Theme::partial('shortcodes.ecommerce.flash-sale', [
                'shortcode' => $shortcode,
                'flashSale' => $flashSale,
            ]);
        });

        shortcode()->setAdminConfig('flash-sale', function ($attributes) {
            $flashSales = app(FlashSaleInterface::class)
                ->getModel()
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->notExpired()
                ->get();

            return Theme::partial('shortcodes.ecommerce.flash-sale-admin-config', compact('flashSales', 'attributes'));
        });

        add_shortcode(
            'product-collections',
            __('Product Collections'),
            __('Product Collections'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productCollections = get_product_collections(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-collections', [
                    'shortcode' => $shortcode,
                    'productCollections' => ProductCollectionResource::collection($productCollections),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-collections', function ($attributes) {
            $collections = get_product_collections(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-collections-admin-config', compact('attributes', 'collections'));
        });

        add_shortcode(
            'product-category-products',
            __('Product category products'),
            __('Product category products'),
            function ($shortcode) {
                $category = app(ProductCategoryInterface::class)->getFirstBy([
                    'status' => BaseStatusEnum::PUBLISHED,
                    'id' => $shortcode->category_id,
                ], ['*'], [
                    'activeChildren' => function ($query) use ($shortcode) {
                        $query->limit($shortcode->number_of_categories ? (int)$shortcode->number_of_categories : 3);
                    },
                    'activeChildren.slugable',
                ]);

                if (! $category) {
                    return null;
                }

                $category = new ProductCategoryResource($category);
                $category->activeChildren = ProductCategoryResource::collection($category->activeChildren);

                return Theme::partial('shortcodes.ecommerce.product-category-products', compact('category', 'shortcode'));
            }
        );

        shortcode()->setAdminConfig('product-category-products', function ($attributes) {
            $categories = ProductCategoryHelper::getProductCategoriesWithIndent();

            return Theme::partial('shortcodes.ecommerce.product-category-products-admin-config', compact('attributes', 'categories'));
        });

        add_shortcode('featured-products', __('Featured products'), __('Featured products'), function ($shortcode) {
            return Theme::partial('shortcodes.ecommerce.featured-products', [
                'shortcode' => $shortcode,
            ]);
        });

        shortcode()->setAdminConfig('featured-products', function ($attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-products-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('blog')) {
        add_shortcode('featured-posts', __('Featured Blog Posts'), __('Featured Blog Posts'), function ($shortcode) {
            return Theme::partial('shortcodes.featured-posts', compact('shortcode'));
        });

        shortcode()->setAdminConfig('featured-posts', function ($attributes) {
            return Theme::partial('shortcodes.featured-posts-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('contact')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.contact-form';
        }, 120);
    }

    add_shortcode('contact-info-boxes', __('Contact info boxes'), __('Contact info boxes'), function ($shortcode) {
        return Theme::partial('shortcodes.contact-info-boxes', compact('shortcode'));
    });

    shortcode()->setAdminConfig('contact-info-boxes', function ($attributes) {
        return Theme::partial('shortcodes.contact-info-boxes-admin-config', compact('attributes'));
    });

    if (is_plugin_active('faq')) {
        add_shortcode('faq', __('FAQs'), __('FAQs'), function ($shortcode) {
            $categories = app(FaqCategoryInterface::class)
                ->advancedGet([
                    'condition' => [
                        'status' => BaseStatusEnum::PUBLISHED,
                    ],
                    'with' => [
                        'faqs' => function ($query) {
                            $query->where('status', BaseStatusEnum::PUBLISHED);
                        },
                    ],
                    'order_by' => [
                        'faq_categories.order' => 'ASC',
                        'faq_categories.created_at' => 'DESC',
                    ],
                ]);

            return Theme::partial('shortcodes.faq', [
                'title' => $shortcode->title,
                'categories' => $categories,
            ]);
        });

        shortcode()->setAdminConfig('faq', function ($attributes) {
            return Theme::partial('shortcodes.faq-admin-config', compact('attributes'));
        });
    }

    add_shortcode('coming-soon', __('Coming Soon'), __('Coming Soon'), function ($shortcode) {
        return Theme::partial('shortcodes.coming-soon', compact('shortcode'));
    });

    shortcode()->setAdminConfig('coming-soon', function ($attributes) {
        return Theme::partial('shortcodes.coming-soon-admin-config', compact('attributes'));
    });
});
