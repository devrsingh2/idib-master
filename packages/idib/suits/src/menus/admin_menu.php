<?php

$adminMenu[2] = [
    'icon' => 'table',
    'list_head' => [
        'name' => trans('Settings::settings.settings'),
        'link' => action('Idib\Settings\Controllers\SettingsController@editInformation'),
    ],
    'list_tree'=> [
        0 => [
            'name' => trans('Settings::settings.main_information'),
            'link' => action('Idib\Settings\Controllers\SettingsController@editInformation'),
        ],
        1 => [
            'name' => trans('Settings::settings.smtp'),
            'link' => action('Idib\Settings\Controllers\SettingsController@editSmtp'),
        ],
        2 => [
            'name' => trans('Settings::settings.accounts'),
            'link' => action('Idib\Settings\Controllers\SettingsController@editSocialAccounts'),
        ],
        // 3 => [
        //     'name' => trans('Settings::settings.links'),
        //     'link' => '/'.App::getLocale().'/admin/settings/links',
        // ],
        // 4 => [
        //     'name' => trans('Settings::settings.seo'),
        //     'link' => '/'.App::getLocale().'/admin/settings/seo',
        // ],
        // 5 => [
        //     'name' => trans('Settings::settings.fcm'),
        //     'link' => '/'.App::getLocale().'/admin/settings/fcm',
        // ],
//                6 => [
//                    'name' => trans('Settings::settings.sms'),
//                    'link' => '/'.App::getLocale().'/admin/settings/sms',
//                ],
        // 7 => [
        //     'name' => trans('Settings::settings.mode'),
        //     'link' => '/'.App::getLocale().'/admin/settings/mode',
        // ]
    ]
];