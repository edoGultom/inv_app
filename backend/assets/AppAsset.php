<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dashforge.css',
        'css/custom.css',
        'lib/remixicon/fonts/remixicon.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css',

    ];
    public $js = [
        // 'lib/jquery/jquery.min.js',
        'js/menu-expand.js',
        'lib/bootstrap/js/bootstrap.bundle.min.js',
        // 'lib/bootstrap/js/bootstrap.bundle.js',
        'lib/feather-icons/feather.min.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js',
        'lib/perfect-scrollbar/perfect-scrollbar.min.js',
        'lib/chart.js/Chart.bundle.min.js',
        'js/dashforge.js',
        'js/dashforge.aside.js',
        // 'js/dashboard-two.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.3/js/plugins/sortable.min.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.3/themes/fas/theme.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}
