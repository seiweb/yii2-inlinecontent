<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 0:54
 */

namespace seiweb\inlinecontent\components;


use yii\base\Module;

class InlineModule extends Module
{
    /**Инициализация секции. Тут можно создать какие-нибудь дополнительные записи в БД.
     *
     * @param $section_id
     */
    public function initSection($section_id)
    {

    }

    /**
     * Удаляем секцию, подчищаем
     *
     * @param $section_id
     */
    public function deleteSection($section_id)
    {

    }

    public function beforeDeleteSection($section){
        return true;
    }

    /**
     * @return array
     */
    public function getDefaultConfig()
    {
        return [];
    }

    public function getMenu()
    {
        return null;
    }

    public function getUrlRules()
    {
        return null;
    }
}