<?php

namespace Botble\Marketplace\Forms;

use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\TagField;
use Botble\Ecommerce\Enums\GlobalOptionEnum;
use Botble\Ecommerce\Enums\ProductTypeEnum;
use Botble\Ecommerce\Forms\Fields\CategoryMultiField;
use Botble\Ecommerce\Forms\ProductForm as BaseProductForm;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Repositories\Interfaces\BrandInterface;
use Botble\Ecommerce\Repositories\Interfaces\GlobalOptionInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use Botble\Ecommerce\Repositories\Interfaces\TaxInterface;
use Botble\Marketplace\Forms\Fields\CustomEditorField;
use Botble\Marketplace\Forms\Fields\CustomImagesField;
use Botble\Marketplace\Http\Requests\ProductRequest;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Marketplace\Facades\MarketplaceHelper;
use Botble\Ecommerce\Facades\ProductCategoryHelper;
use Botble\Marketplace\Tables\ProductVariationTable;

class ProductForm extends BaseProductForm
{
    public function buildForm(): void
    {
        $this->addAssets();

        $selectedCategories = [];

        $brands = app(BrandInterface::class)->pluck('name', 'id');
        $brands = [0 => trans('plugins/ecommerce::brands.no_brand')] + $brands;

        $productCollections = app(ProductCollectionInterface::class)->pluck('name', 'id');

        $selectedProductCollections = [];
        $productId = null;
        $totalProductVariations = 0;
        $tags = null;

        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
            $productId = $this->getModel()->id;
            $selectedProductCollections = $this->getModel()->productCollections()->pluck('product_collection_id')
                ->all();

            $totalProductVariations = app(ProductVariationInterface::class)->count([
                'configurable_product_id' => $productId,
            ]);

            $tags = $this->getModel()->tags()->pluck('name')->implode(',');
        }

        $productAttributeSets = app(ProductAttributeSetInterface::class)->getAllWithSelected($productId, []);

        $this
            ->setupModel(new Product())
            ->withCustomFields()
            ->addCustomField('customEditor', CustomEditorField::class)
            ->addCustomField('customImages', CustomImagesField::class)
            ->addCustomField('categoryMulti', CategoryMultiField::class)
            ->addCustomField('multiCheckList', MultiCheckListField::class)
            ->addCustomField('tags', TagField::class)
            ->setFormOption('template', MarketplaceHelper::viewPath('dashboard.forms.base'))
            ->setFormOption('enctype', 'multipart/form-data')
            ->setValidatorClass(ProductRequest::class)
            ->setActionButtons(MarketplaceHelper::view('dashboard.forms.actions')->render())
            ->add('name', 'text', [
                'label' => trans('plugins/ecommerce::products.form.name'),
                'label_attr' => ['class' => 'text-title-field required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 150,
                ],
            ])
            ->add('description', 'customEditor', [
                'label' => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 2,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 1000,
                ],
            ])
            ->add('content', 'customEditor', [
                'label' => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('images', 'customImages', [
                'label' => trans('plugins/ecommerce::products.form.image'),
                'label_attr' => ['class' => 'control-label'],
                'values' => $productId ? $this->getModel()->images : [],
            ])
            ->addMetaBoxes([
                'with_related' => [
                    'title' => null,
                    'content' => '<div class="wrap-relation-product" data-target="' . route(
                        'marketplace.vendor.products.get-relations-boxes',
                        $productId ?: 0
                    ) . '"></div>',
                    'wrap' => false,
                    'priority' => 9999,
                ],
            ])
            ->add('product_type', 'hidden', [
                'value' => request()->input('product_type') ?: ProductTypeEnum::PHYSICAL,
            ])
            ->add('categories[]', 'categoryMulti', [
                'label' => trans('plugins/ecommerce::products.form.categories'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => ProductCategoryHelper::getAllProductCategoriesWithChildren(),
                'value' => old('categories', $selectedCategories),
            ])
            ->add('brand_id', 'customSelect', [
                'label' => trans('plugins/ecommerce::products.form.brand'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => $brands,
            ])
            ->add('product_collections[]', 'multiCheckList', [
                'label' => trans('plugins/ecommerce::products.form.collections'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => $productCollections,
                'value' => old('product_collections', $selectedProductCollections),
            ]);

        if (EcommerceHelper::isTaxEnabled()) {
            $taxes = app(TaxInterface::class)->all()->pluck('title_with_percentage', 'id');

            $selectedTaxes = [];
            if ($this->getModel() && $this->getModel()->id) {
                $selectedTaxes = $this->getModel()->taxes()->pluck('tax_id')->all();
            } elseif ($defaultTaxRate = get_ecommerce_setting('default_tax_rate')) {
                $selectedTaxes = [$defaultTaxRate];
            }

            $this->add('taxes[]', 'multiCheckList', [
                'label' => trans('plugins/ecommerce::products.form.taxes'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => $taxes,
                'value' => old('taxes', $selectedTaxes),
            ]);
        }

        $this
            ->add('tag', 'tags', [
                'label' => trans('plugins/ecommerce::products.form.tags'),
                'label_attr' => ['class' => 'control-label'],
                'value' => $tags,
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::products.form.write_some_tags'),
                    'data-url' => route('marketplace.vendor.tags.all'),
                ],
            ])
            ->setBreakFieldPoint('categories[]')
            ->addMetaBoxes([
                'options' => [
                    'title' => trans('plugins/ecommerce::product-option.name'),
                    'content' => view('plugins/ecommerce::products.partials.product-option-form', [
                        'options' => GlobalOptionEnum::options(),
                        'globalOptions' => app(GlobalOptionInterface::class)->pluck('name', 'id'),
                        'product' => $this->getModel(),
                        'routes' => [
                            'ajax_option_info' => route('marketplace.vendor.ajax-product-option-info'),
                        ],
                    ]),
                    'priority' => 4,
                ],
            ]);

        $this
            ->addMetaBoxes([
                'attribute-sets' => [
                    'content' => '',
                    'before_wrapper' => '<div class="d-none product-attribute-sets-url" data-url="' . route('marketplace.vendor.products.product-attribute-sets') . '">',
                    'after_wrapper' => '</div>',
                    'priority' => 3,
                ],
            ]);

        if (! $totalProductVariations) {
            $this
                ->removeMetaBox('variations')
                ->addMetaBoxes([
                    'general' => [
                        'title' => trans('plugins/ecommerce::products.overview'),
                        'content' => view(
                            'plugins/ecommerce::products.partials.general',
                            [
                                'product' => $productId ? $this->getModel() : null,
                                'isVariation' => false,
                                'originalProduct' => null,
                            ]
                        )->render(),
                        'before_wrapper' => '<div id="main-manage-product-type">',
                        'priority' => 2,
                    ],
                    'attributes' => [
                        'title' => trans('plugins/ecommerce::products.attributes'),
                        'content' => view('plugins/ecommerce::products.partials.add-product-attributes', [
                            'product' => $this->getModel(),
                            'productAttributeSets' => $productAttributeSets,
                            'addAttributeToProductUrl' => $this->getModel()->id ? route('marketplace.vendor.products.add-attribute-to-product', $this->getModel()->id) : null,
                        ]),
                        'after_wrapper' => '</div>',
                        'priority' => 3,
                    ],
                ]);
        } elseif ($productId) {
            $productVariationTable = app(ProductVariationTable::class)
                ->setProductId($productId)
                ->setProductAttributeSets($productAttributeSets);

            if ($this->getModel()->isTypeDigital()) {
                $productVariationTable->isDigitalProduct();
            }

            $this
                ->removeMetaBox('general')
                ->addMetaBoxes([
                    'variations' => [
                        'title' => trans('plugins/ecommerce::products.product_has_variations'),
                        'content' => MarketplaceHelper::view('dashboard.products.configurable', [
                            'productAttributeSets' => $productAttributeSets,
                            'productVariationTable' => $productVariationTable,
                            'product' => $this->getModel(),
                        ]),
                        'before_wrapper' => '<div id="main-manage-product-type">',
                        'after_wrapper' => '</div>',
                        'priority' => 3,
                        'render' => false,
                    ],
                ]);
        }
    }
}
