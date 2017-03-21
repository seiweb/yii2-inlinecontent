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

class AdminController extends InternalSubModuleController
{
	public function actionIndex($section_id)
	{
		$f = \Yii::$app->request->post('f',null);
		$sectionModel = PageSection::findOne($section_id);
        $sectionModel->attachBehavior(null, [
            'class' => \seiweb\image\behaviors\ImageBehavior::className(),
            'modelKey' => \seiweb\inlinecontent\models\PageSection::className()
        ]);

        return  $this->render('index',['sectionModel'=>$sectionModel]);
	}



}