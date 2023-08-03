<?php

use \kartik\datecontrol\Module;

return [
    'language' => 'id-ID',
    'timeZone' => 'Asia/Jakarta',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'i18n' => [
            'translations' => [
                'yii2-ajaxcrud' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2ajaxcrud/ajaxcrud/messages',
                    'sourceLanguage' => 'id',
                ],
            ]
        ],
        'pengguna' => [
            'class' => 'common\components\Pengguna',
        ],
        'helper' => [
            'class' => 'common\components\Helper',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // only support DbManager
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => 'Rp',
            'defaultTimeZone' => 'UTC',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-M-Y H:i:s',
            'nullDisplay' => '-'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'mimin' => [
            'class' => '\hscstudio\mimin\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'crud-custom'   => [
                    'class' => 'common\customgenerator\generator_custom\Generator',
                ],
            ],

        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // 'bsVersion' => '5.x',
        ],
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd/MM/yyyy',
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'dd/MM/yyyy hh:mm:ss a',
            ],

            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],

            // set your display timezone
            'displayTimezone' => 'Asia/Jakarta',

            // set your timezone for date saved to db
            'saveTimezone' => 'Asia/Jakarta',

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => ['type' => 2, 'pluginOptions' => ['autoclose' => true]], // example
                Module::FORMAT_DATETIME => [], // setup if needed
                Module::FORMAT_TIME => [], // setup if needed
            ],

            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            'widgetSettings' => [
                Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker', // example
                    'options' => [
                        'dateFormat' => 'php:d-M-Y',
                        'options' => ['class' => 'form-control'],
                    ]
                ]
            ]
            // other settings
        ]
    ],
];
