<?php
namespace seiweb\inlinecontent\modules\files;

use seiweb\files\behaviors\FileBehavior;

use seiweb\inlinecontent\components\InlineModule;
use seiweb\inlinecontent\models\PageSection;


/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 0:40
 */
class Module extends InlineModule
{
    /**
     * Удаляем секцию, подчищаем
     *
     * @param $section_id
     */
    public function deleteSection($section_id)
    {
        $s = new PageSection(['id' => $section_id]);
        $s->attachBehavior(null, [
            'class' => FileBehavior::className(),
            'modelKey' => PageSection::className()
        ]);
        $s->deleteAllFiles();
    }

    /**
     * @return array
     */
    public function getDefaultConfig()
    {
        return [
            'section_title' => '',
            'show_section_title' => false
        ];
    }

    public function getMenu()
    {
        return null;
    }

    public function getUrlRules()
    {
        return null;
    }

    public function initSection($section_id)
    {
        // TODO: Implement initSection() method.
    }
}