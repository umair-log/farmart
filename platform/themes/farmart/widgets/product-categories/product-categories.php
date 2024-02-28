<?php

use Botble\Widget\AbstractWidget;

class ProductCategoriesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Product Categories'),
            'description' => __('List of product categories'),
            'categories' => [],
        ]);
    }
}
