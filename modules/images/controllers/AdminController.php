<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 0:41
 */

namespace seiweb\inlinecontent\modules\images\controllers;


use seiweb\inlinecontent\components\InternalSubModuleController;
use seiweb\inlinecontent\components\SubModuleController;
use seiweb\inlinecontent\models\PageSection;
use yii\base\Controller;

class AdminController extends InternalSubModuleController
{
	public function actionIndex($section_id)
	{
		$f = \Yii::$app->request->post('f',null);
		$sectionModel = PageSection::findOne($section_id);
		return  $this->render('index',['f'=>$f,'sectionModel'=>$sectionModel]);
	}



}