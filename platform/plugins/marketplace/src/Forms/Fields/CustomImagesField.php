<?php

namespace Botble\Marketplace\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Botble\Marketplace\Facades\MarketplaceHelper;

class CustomImagesField extends FormField
{
    protected function getTemplate(): string
    {
        return MarketplaceHelper::viewPath('dashboard.forms.fields.custom-images');
    }
}
