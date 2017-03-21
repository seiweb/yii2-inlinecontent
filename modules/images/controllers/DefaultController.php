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
	    $sectionModel = PageSection::findOne($section_id);

	    $sectionModel->attachBehavior(null, [
            'class' => \seiweb\image\behaviors\ImageBehavior::className(),
            'modelKey' => \seiweb\inlinecontent\models\PageSection::className()
        ]);

		return $this->render('index', [
			'model' => $sectionModel,
		]);
	}

}