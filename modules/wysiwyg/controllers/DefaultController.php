<?php

namespace seiweb\inlinecontent\modules\wysiwyg\controllers;


use seiweb\inlinecontent\components\InternalSubModuleController;
use seiweb\inlinecontent\modules\wysiwyg\models\Model;
use seiweb\inlinecontent\modules\wysiwyg\models\PageSectionWysiwig;
use seiweb\inlinecontent\components\SubModuleController;

use yii\web\NotFoundHttpException;

/**
 * Default controller for the `test` module
 */
class DefaultController extends InternalSubModuleController
{
	/**
	 * Renders the index view for the module
	 * @return string
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\base\ViewNotFoundException
	 * @throws \yii\base\InvalidCallException
	 */
	public function actionIndex($section_id)
	{
		$model = $this->findModel($section_id);
		return $this->render('index',['model'=>$model]);
	}

	protected function findModel($id)
	{
		if (($model = Model::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}