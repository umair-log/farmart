<?php

namespace Theme\Farmart\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;
use Theme;

class ThemeIconField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScriptsDirectly(Theme::asset()->url('js/icons-field.js'))
            ->addStylesDirectly(Theme::asset()->url('fonts/Linearicons/Linearicons/Font/demo-files/demo.css'));

        return Theme::getThemeNamespace() . '::partials.fields.icons-field';
    }
}
