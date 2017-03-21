<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 0:41
 */

namespace seiweb\inlinecontent\modules\files\controllers;


use seiweb\files\actions\FileDownloadAction;
use seiweb\files\behaviors\FileBehavior;
use seiweb\inlinecontent\components\InternalSubModuleController;
use seiweb\inlinecontent\models\PageSection;
use yii\data\ActiveDataProvider;

class DefaultController extends InternalSubModuleController
{
    public function actions()
    {
        return [
            'file' => [
                'class' => FileDownloadAction::className()
            ]
        ];
    }

	public function actionIndex($section_id)
	{
        \seiweb\inlinecontent\modules\files\web\FilesAsset::register($this->view);

        $sectionModel = PageSection::findOne($section_id);
        $sectionModel->attachBehavior(null, [
            'class' => FileBehavior::className(),
            'modelKey' => PageSection::className()
        ]);

        $filesProv = new ActiveDataProvider([
            'query' => $sectionModel->getFiles()
        ]);

        return $this->render('index', ['filesProvider' => $filesProv, 'sectionModel' => $sectionModel]);
	}

}