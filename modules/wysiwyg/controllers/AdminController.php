<?php

namespace seiweb\inlinecontent\modules\wysiwyg\controllers;

use seiweb\inlinecontent\components\InternalSubModuleController;
use seiweb\inlinecontent\models\PageSection;
use seiweb\inlinecontent\modules\wysiwyg\models\Model;
use seiweb\inlinecontent\components\SubModuleController;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `test` module
 */
class AdminController extends InternalSubModuleController
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
		$section = PageSection::findOne($section_id);

		 if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 \Yii::$app->getSession()->setFlash('section_success', 'Section has been updated');
		 }

		return $this->render('index',['model'=>$model,'section'=>$section]);
	}

	protected function findModel($id)
	{
		if (($model = Model::findOne(['section_id'=>$id])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}