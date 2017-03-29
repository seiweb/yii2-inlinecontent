<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.03.2017
 * Time: 19:08
 */

namespace seiweb\inlinecontent\components;


class GroupUrlRule extends \yii\web\GroupUrlRule
{
    /**
     * ЗХдесь через жопу и хак, если два и больше модуля зарегистрировано, то меняется логика генерации УРЛа
     * @param \yii\web\UrlManager $manager
     * @param string              $route
     * @param array               $params
     *
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        $module = \Yii::$app->getModule($this->routePrefix);
        if($module!==null && isset($module::$counter) && $module::$counter>1) {
            $pathInfo = \Yii::$app->request->pathInfo;
            if(strpos($pathInfo,$this->prefix)!==0) return false;
        }
        return parent::createUrl($manager, $route, $params);
    }
}