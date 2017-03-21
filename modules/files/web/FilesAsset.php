<?php
namespace seiweb\inlinecontent\modules\files\web;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class FilesAsset extends AssetBundle
{
    public $sourcePath = '@vendor/seiweb/yii2-inlinecontent/modules/files/assets';
    public $css = [
        'style.css',
    ];
    public $js = [
        'script.js',
        'form_file_edit.js'
    ];
}
