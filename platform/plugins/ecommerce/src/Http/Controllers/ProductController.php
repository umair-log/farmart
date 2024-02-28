<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Enums\ProductTypeEnum;
use Botble\Ecommerce\Forms\ProductForm;
use Botble\Ecommerce\Http\Requests\ProductRequest;
use Botble\Ecommerce\Repositories\Interfaces\GroupedProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationItemInterface;
use Botble\Ecommerce\Services\Products\StoreAttributesOfProductService;
use Botble\Ecommerce\Services\Products\StoreProductService;
use Botble\Ecommerce\Services\StoreProductTagService;
use Botble\Ecommerce\Tables\ProductTable;
use Botble\Ecommerce\Traits\ProductActionsTrait;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Tables\ProductVariationTable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Illuminate\Support\Str;
use Botble\Ecommerce\Models\EmailChannel;
use Illuminate\Support\Facades\Storage;


class ProductController extends BaseController
{
    use ProductActionsTrait;

    public function index(ProductTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::products.name'));

        Assets::addScripts(['bootstrap-editable'])
            ->addStyles(['bootstrap-editable']);

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder, Request $request)
    {
        // return "create product view";
        // die();
        if (EcommerceHelper::isEnabledSupportDigitalProducts()) {
            if ($request->input('product_type') == ProductTypeEnum::DIGITAL) {
                PageTitle::setTitle(trans('plugins/ecommerce::products.create_product_type.digital'));
            } else {
                PageTitle::setTitle(trans('plugins/ecommerce::products.create_product_type.physical'));
            }
        } else {
            PageTitle::setTitle(trans('plugins/ecommerce::products.create'));
        }

        return $formBuilder->create(ProductForm::class)->renderForm();
    }

    public function edit(int|string $id, Request $request, FormBuilder $formBuilder)
    {
        $product = $this->productRepository->findOrFail($id);

        if ($product->is_variation) {
            abort(404);
        }

        PageTitle::setTitle(trans('plugins/ecommerce::products.edit', ['name' => $product->name]));

        event(new BeforeEditContentEvent($request, $product));

        return $formBuilder
            ->create(ProductForm::class, ['model' => $product])
            ->renderForm();
    }

    public function store(
        ProductRequest $request,
        StoreProductService $service,
        BaseHttpResponse $response,
        ProductVariationInterface $variationRepository,
        ProductVariationItemInterface $productVariationItemRepository,
        GroupedProductInterface $groupedProductRepository,
        StoreAttributesOfProductService $storeAttributesOfProductService,
        StoreProductTagService $storeProductTagService
    ) {

              //* email channel 
              $stock_delimiter = $request['stock_delimiter'];
              if ($stock_delimiter == 'comma') {
                  $stock_delimiter = ",";
              }else if ($stock_delimiter == 'newline') {
                $stock_delimiter = "\n";
              }else if ($stock_delimiter == 'custom') {
                  $stock_delimiter = $request['custom_stock_delimiter'];
              }
              $stock_list_str = $request['stock_list'];
              $file_count = $request['file_limit'] == -1 ? 1 : $request['file_limit'];
      
              if ($stock_list_str != '') {
                  // Split the input by newline to handle multiple records
                  $stock_list = explode("\n", $stock_list_str);
      
                  // If there's only one record, treat it as a single record
                  if (count($stock_list) == 1) {
                      $row = $stock_list[0];
                      $emailChannel = new EmailChannel();
      
                      $emailChannel->format = $request['format'];
                      $emailChannel->value1 = trim($row);
                      $emailChannel->delimiter = $stock_delimiter;
                      $emailChannel->checkbox_value = $request['check_box_value'] ? 1 : 0;
                      $emailChannel->status = "available";
      
                      // Populate other fields as per your existing code
      
                      // Handle file upload
                      if ($request->hasFile('file') && $file_count > 0) {
                          $file = $request->file('file');
                          $fileName = Str::random(8) . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                          $fileValue = Storage::putFileAs('channel_files/', $file, $fileName);
                          $emailChannel->file = $fileValue;
      
                          if ($request['file_limit'] != -1) {
                              $file_count--;
                          }
                      }
                      // Save the EmailChannel to the database
                      emailChannels()->save($emailChannel);
                  } else {
                      // If there are multiple records, process each one
                      foreach ($stock_list as $row) {
                          // Skip empty lines
                          if (empty($row)) {
                              continue;
                          }
      
                          $emailChannel = new EmailChannel();
      
                          $emailChannel->format = $request['format'];
                          $emailChannel->value1 = trim($row);
                          $emailChannel->delimiter = $stock_delimiter;
                          $emailChannel->status = "available";
      
                          $fields = explode($stock_delimiter, $row);
      
                          if (count($fields) > 1) {
                              $emailChannel->value2 = trim($fields[1]);
                          }
                          if (count($fields) > 2) {
                              $emailChannel->value3 = trim($fields[2]);
                          }
                          if (count($fields) > 3) {
                              $emailChannel->value4 = trim($fields[3]);
                          }
                          if (count($fields) > 4) {
                              $emailChannel->value5 = trim($fields[4]);
                          }
                          if (count($fields) > 5) {
                              $emailChannel->value6 = trim($fields[5]);
                          }
                          if (count($fields) > 6) {
                              $emailChannel->value7 = trim($fields[6]);
                          }
                          if (count($fields) > 7) {
                              $emailChannel->value8 = trim($fields[7]);
                          }
      
      
                          // Populate other fields as per your existing code
      
                          // Handle file upload
                          if ($request->hasFile('file') && $file_count > 0) {
                              $file = $request->file('file');
                              $fileName = Str::random(8) . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                              $fileValue = Storage::putFileAs('channel_files/', $file, $fileName);
                              $emailChannel->file = $fileValue;
      
                              if ($request['file_limit'] != -1) {
                                  $file_count--;
                              }
                          }
      
                          // Save the EmailChannel to the database
                          emailChannels()->save($emailChannel);
                      }
                  }
              }
                      //* email channel  end


        $product = $this->productRepository->getModel();

        $product->status = $request->input('status');
        if (EcommerceHelper::isEnabledSupportDigitalProducts() && $request->input('product_type')) {
            $product->product_type = $request->input('product_type');
        }

        $product = $service->execute($request, $product);
        $storeProductTagService->execute($request, $product);

        $addedAttributes = $request->input('added_attributes', []);

        if ($request->input('is_added_attributes') == 1 && $addedAttributes) {
            $storeAttributesOfProductService->execute($product, array_keys($addedAttributes), array_values($addedAttributes));

            $variation = $variationRepository->create([
                'configurable_product_id' => $product->id,
            ]);

            foreach ($addedAttributes as $attribute) {
                $productVariationItemRepository->createOrUpdate([
                    'attribute_id' => $attribute,
                    'variation_id' => $variation->id,
                ]);
            }

            $variation = $variation->toArray();

            $variation['variation_default_id'] = $variation['id'];

            $variation['sku'] = $product->sku;
            $variation['auto_generate_sku'] = true;

            $variation['images'] = $request->input('images', []);

            $this->postSaveAllVersions([$variation['id'] => $variation], $variationRepository, $product->id, $response);
        }

        if ($request->has('grouped_products')) {
            $groupedProductRepository->createGroupedProducts($product->id, array_map(function ($item) {
                return [
                    'id' => $item,
                    'qty' => 1,
                ];
            }, array_filter(explode(',', $request->input('grouped_products', '')))));
        }

        return $response
            ->setPreviousUrl(route('products.index'))
            ->setNextUrl(route('products.edit', $product->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function update(
        int|string $id,
        ProductRequest $request,
        StoreProductService $service,
        GroupedProductInterface $groupedProductRepository,
        BaseHttpResponse $response,
        ProductVariationInterface $variationRepository,
        ProductVariationItemInterface $productVariationItemRepository,
        StoreProductTagService $storeProductTagService
    ) {
        $product = $this->productRepository->findOrFail($id);

        $product->status = $request->input('status');

        $product = $service->execute($request, $product);
        $storeProductTagService->execute($request, $product);

        if ($request->has('variation_default_id')) {
            $variationRepository
                ->getModel()
                ->where('configurable_product_id', $product->id)
                ->update(['is_default' => 0]);

            $defaultVariation = $variationRepository->findById($request->input('variation_default_id'));
            if ($defaultVariation) {
                $defaultVariation->is_default = true;
                $defaultVariation->save();
            }
        }

        $addedAttributes = $request->input('added_attributes', []);

        if ($request->input('is_added_attributes') == 1 && $addedAttributes) {
            $result = $variationRepository->getVariationByAttributesOrCreate($id, $addedAttributes);

            /**
             * @var Collection $variation
             */
            $variation = $result['variation'];

            foreach ($addedAttributes as $attribute) {
                $productVariationItemRepository->createOrUpdate([
                    'attribute_id' => $attribute,
                    'variation_id' => $variation->id,
                ]);
            }

            $variation = $variation->toArray();
            $variation['variation_default_id'] = $variation['id'];

            $product->productAttributeSets()->sync(array_keys($addedAttributes));

            $variation['sku'] = $product->sku;
            $variation['auto_generate_sku'] = true;

            $this->postSaveAllVersions([$variation['id'] => $variation], $variationRepository, $product->id, $response);
        } elseif ($product->variations()->count() === 0) {
            $product->productAttributeSets()->detach();
        }

        if ($request->has('grouped_products')) {
            $groupedProductRepository->createGroupedProducts($product->id, array_map(function ($item) {
                return [
                    'id' => $item,
                    'qty' => 1,
                ];
            }, array_filter(explode(',', $request->input('grouped_products', '')))));
        }

        $relatedProductIds = $product->variations()->pluck('product_id')->all();

        $this->productRepository->update([['id', 'IN', $relatedProductIds]], ['status' => $product->status]);

        return $response
            ->setPreviousUrl(route('products.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function getProductVariations(int|string $id, ProductVariationTable $dataTable)
    {
        $product = $this->productRepository
            ->getModel()
            ->where('is_variation', 0)
            ->findOrFail($id);

        $dataTable->setProductId($id);

        if (EcommerceHelper::isEnabledSupportDigitalProducts() && $product->isTypeDigital()) {
            $dataTable->isDigitalProduct();
        }

        return $dataTable->renderTable();
    }

    public function setDefaultProductVariation(int|string $id, ProductVariationInterface $variationRepository, BaseHttpResponse $response)
    {
        $variation = $variationRepository->findOrFail($id);

        $variationRepository
            ->getModel()
            ->where('configurable_product_id', $variation->configurable_product_id)
            ->update(['is_default' => 0]);

        if ($variation) {
            $variation->is_default = true;
            $variation->save();
        }

        return $response->setMessage(trans('core/base::notices.update_success_message'));
    }
}
