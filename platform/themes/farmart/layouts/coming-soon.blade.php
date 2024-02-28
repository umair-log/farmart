<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts-->
    <link href="https://fonts.googleapis.com/css?family={{ urlencode(theme_option('primary_font', 'Muli')) }}:400,600,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <!-- CSS Library-->

    <style>
        :root {
            --primary-font: '{{ theme_option('primary_font', 'Muli') }}', sans-serif;
            --primary-color: {{ theme_option('primary_color', '#fab528') }};
            --heading-color: {{ theme_option('heading_color', '#000') }};
            --text-color: {{ theme_option('text_color', '#000') }};
            --primary-button-color: {{ theme_option('primary_button_color', '#000') }};
            --top-header-background-color: {{ theme_option('top_header_background_color', '#f7f7f7') }};
            --middle-header-background-color: {{ theme_option('middle_header_background_color', '#fff') }};
            --bottom-header-background-color: {{ theme_option('bottom_header_background_color', '#fff') }};
            --header-text-color: {{ theme_option('header_text_color', '#000') }};
            --footer-text-color: {{ theme_option('footer_text_color', '#555') }};
            --footer-heading-color: {{ theme_option('footer_heading_color', '#555') }};
            --footer-hover-color: {{ theme_option('footer_hover_color', '#fab528') }};
            --footer-border-color: {{ theme_option('footer_border_color', '#dee2e6') }};
        }
    </style>

    {!! Theme::header() !!}
</head>
<body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif>
    @if (theme_option('preloader_enabled', 'yes') == 'yes')
        <div class="preloader" id="preloader">
            <div class="preloader-loading"></div>
        </div>
    @endif

    <div id="main-content">
        {!! Theme::content() !!}
    </div>

    <script>
        'use strict';

        window.siteConfig = {
            "countdown_text" : {
                "days"   : "{{ __('days') }}",
                "hours"  : "{{ __('hours') }}",
                "minutes": "{{ __('mins') }}",
                "seconds": "{{ __('secs') }}"
            }
        };
    </script>

    {!! Theme::footer() !!}
</body>
</html>

