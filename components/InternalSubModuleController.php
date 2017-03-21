<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.02.2017
 * Time: 2:19
 */

namespace seiweb\inlinecontent\components;


use seiweb\inlinecontent\assets\BlockUIAsset;
use yii\web\Controller;

class InternalSubModuleController extends Controller
{
    public $description = 'Описание модуля';
    public $name = 'Название';


    /**
     * @param string $view
     * @param array  $params
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ViewNotFoundException
     * @throws \yii\base\InvalidCallException
     */
    public function render($view, $params = [])
    {
        /*
        $this->getView()->registerJs("
$(document).ajaxStart(function(event, xhr, options,response) {
    //console.log(xhr);
    $.blockUI();
});

$(document).ajaxStop(function(event, xhr, options) {
  $.unblockUI();
});

$(document).ajaxSend(function(event, xhr, options) {
  console.log(xhr);
});

");

        */
        //BlockUIAsset::register($this->view);
        return $this->getView()->render($view, $params, $this);
    }


    public function getViewPath()
    {
        //is_subclass_of($className, SubModuleController::class)
        //вызываем из модуля inlinecontent
        if ($this->module->id == 'inlinecontent') {
            $controller = str_replace('Controller', '', $this->module->defaultControllerName);
            $res = '@vendor/seiweb/yii2-inlinecontent/modules/' . $this->id . '/views/' . strtolower($controller);
            return $res;
        }
        //вызываем напрямую

        return parent::getViewPath();
    }
}
