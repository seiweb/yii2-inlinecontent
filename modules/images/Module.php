<?php
namespace seiweb\inlinecontent\modules\images;
use seiweb\inlinecontent\components\InlineModule;
use seiweb\inlinecontent\components\ModuleInterface;
use seiweb\inlinecontent\models\PageSection;


/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 0:40
 */
class Module extends InlineModule
{

	public function getStorePath()
	{
		// TODO: Implement getStorePath() method.
	}

	public function initSection($section_id)
	{
		// TODO: Implement initSection() method.
	}

	/**
	 * Удаляем секцию, подчищаем
	 * @param $section_id
	 */
	public function deleteSection($section_id)
	{

        $sectionModel = new PageSection(['id'=>$section_id]);
        $sectionModel->attachBehavior(null, [
            'class' => \seiweb\image\behaviors\ImageBehavior::className(),
            'modelKey' => \seiweb\inlinecontent\models\PageSection::className()
        ]);

	}

	/**
	 * @return array
	 */
	public function getDefaultConfig()
	{
		return [
			'section_title'=>'',
			'show_section_title'=>false,
			'fancy_enabled'=>true,
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
}