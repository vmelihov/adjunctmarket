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
        'extension/font-awesome/css/all.css',
        'css/global.css',
    ];
    public $js = [
        'js/global.js',
        'extension/jquery.nicescroll.js',
        'extension/bootstrap-4.0.0/js/popper.min.js',
        'extension/bootstrap-4.0.0/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
