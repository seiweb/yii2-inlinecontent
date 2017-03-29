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
            \Yii::trace($pathInfo,'pi');
            $fakeUrl = $this->prefix . '/' . implode('/', $params);
            \Yii::trace($fakeUrl,'fu');
            if(strpos($pathInfo,$this->prefix)!==0) return false;
        }

        $res = parent::createUrl($manager, $route, $params);
        \Yii::trace($route.' - '.$res,__METHOD__);
        return $res;
    }
}