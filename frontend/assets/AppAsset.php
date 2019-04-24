<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'extension/bootstrap-4.0.0/css/bootstrap.min.css',
        'css/global.css',
        'css/fix.css',
    ];
    public $js = [
        'js/global.js',
        'extension/bootstrap-4.0.0/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',

        // may conflict with extension/bootstrap-4.0.0/js/bootstrap.min.js
        'yii\bootstrap\BootstrapAsset',
    ];
}
