<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Setting\Models\Setting;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Botble\Base\Facades\MetaBox;

class SimpleSliderSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('sliders');

        SimpleSlider::query()->truncate();
        SimpleSliderItem::query()->truncate();
        LanguageMeta::query()->where('reference_type', SimpleSlider::class)->delete();
        MetaBoxModel::query()->where('reference_type', SimpleSlider::class)->delete();

        $sliders = [
            'en_US' => [
                [
                    'name' => 'Home slider',
                    'key' => 'home-slider',
                    'description' => 'The main slider on homepage',
                ],
            ],
            'vi' => [
                [
                    'name' => 'Slider trang chủ',
                    'key' => 'slider-trang-chu',
                    'description' => 'Slider chính trên trang chủ',
                ],
            ],
        ];

        $sliderItems = [
            'en_US' => [
                [
                    'title' => 'Slider 1',
                ],
                [
                    'title' => 'Slider 2',
                ],
            ],
            'vi' => [
                [
                    'title' => 'Slider 1',
                ],
                [
                    'title' => 'Slider 2',
                ],
            ],
        ];

        foreach ($sliders as $locale => $sliderItem) {
            foreach ($sliderItem as $index => $value) {
                $slider = SimpleSlider::query()->create($value);

                $originValue = null;

                if ($locale !== 'en_US') {
                    $originValue = LanguageMeta::query()->where([
                        'reference_id' => $index + 1,
                        'reference_type' => SimpleSlider::class,
                    ])->value('lang_meta_origin');
                }

                LanguageMeta::saveMetaData($slider, $locale, $originValue);

                foreach ($sliderItems[$locale] as $key => $item) {
                    $item['link'] = '/products';
                    $item['image'] = 'sliders/0' . ($key + 1) . '.jpg';
                    $item['order'] = $key + 1;
                    $item['simple_slider_id'] = $slider->id;

                    $ssItem = SimpleSliderItem::query()->create($item);

                    MetaBox::saveMetaBoxData($ssItem, 'tablet_image', 'sliders/0' . ($key + 1) . '.jpg');
                    MetaBox::saveMetaBoxData($ssItem, 'mobile_image', 'sliders/0' . ($key + 1) . '-sm.jpg');
                }
            }
        }

        Setting::query()->insertOrIgnore([
            [
                'key' => 'simple_slider_using_assets',
                'value' => 0,
            ],
        ]);
    }
}
