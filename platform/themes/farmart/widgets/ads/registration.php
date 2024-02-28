<?php

if (is_plugin_active('ads')) {
    require_once __DIR__ . '/ads.php';
    register_widget(AdsWidget::class);
}
