<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 0:41
 */

namespace seiweb\inlinecontent\modules\images\controllers;


use seiweb\inlinecontent\components\InternalSubModuleController;
use seiweb\inlinecontent\models\PageSection;
use seiweb\yii2images\models\Image;

class DefaultController extends InternalSubModuleController
{

    /**
     * @param $section_id PageSection
     * @param $fancy_enabled
     *
     * @return string
     */
	public function actionIndex($section_id)
	{
	    $s = PageSection::findOne($section_id);

		return $this->render('index', [
			'section_id' => $section_id,
            'images'=>Image::getModelImages(PageSection::findOne($section_id))->all(),
		]);
	}

}