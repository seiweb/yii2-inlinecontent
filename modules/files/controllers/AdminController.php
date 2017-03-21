<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 0:41
 */

namespace seiweb\inlinecontent\modules\files\controllers;


use seiweb\files\actions\FileDeleteAction;
use seiweb\files\actions\FileUpdateAction;
use seiweb\files\actions\FileUploadAction;
use seiweb\files\behaviors\FileBehavior;
use seiweb\files\models\File;
use seiweb\inlinecontent\components\InternalSubModuleController;
use seiweb\inlinecontent\models\PageSection;
use seiweb\sortable\actions\SortableGridAction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\UploadedFile;

class AdminController extends InternalSubModuleController
{
    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => File::className(),
            ],
            'upload' => [
                'class' => FileUploadAction::className(),
            ],
            'update' => [
                'class' => FileUpdateAction::className(),
            ],
            'delete' => [
                'class' => FileDeleteAction::className(),
            ]

        ];
    }

    /**
     * Сброс сортировки, сортирует файлы по uf_file_name
     *
     * @param $section_id
     *
     * @return string
     */
    public function actionResetSort()
    {
        $section_id = Yii::$app->request->post('section_id');

        $query = Model::find();
        $query->andFilterWhere([
            'section_id' => $section_id,
        ]);
        $query->orderBy('friendly_name');

        $sort = 0;
        foreach ($query->all() as $file) {
            $file->sort_order = $sort++;
            $file->save();
        }
    }

    public function actionOptions($section_id)
    {
        $sectionModel = PageSection::findOne(['id' => $section_id]);


        $options = $sectionModel->getOptionsArray();
        $sectionModel->options = serialize(array_merge($options, \Yii::$app->request->post('options')));
        $sectionModel->save();

        return $this->actionIndex($section_id);
    }

    public function actionIndex($section_id)
    {
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

    public function actionFileEdit($file_id)
    {
        $model = File::findOne($file_id);
        return $this->renderAjax('file_edit', ['fileModel' => $model]);
    }

}