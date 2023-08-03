<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAssetSignIn extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dashforge.css',
        'css/dashforge.auth.css',
        'lib/remixicon/fonts/remixicon.css',
        'css/custom.css',
    ];
    public $js = [
        // 'lib/jquery/jquery.min.js',
        'lib/bootstrap/js/bootstrap.bundle.min.js',
        'lib/feather-icons/feather.min.js',
        'lib/perfect-scrollbar/perfect-scrollbar.min.js',
        'js/dashforge.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}