<?php

namespace seiweb\inlinecontent\controllers;

use kartik\dialog\DialogAsset;
use seiweb\ext\BlockUIAsset;
use seiweb\inlinecontent\models\Page;
use seiweb\inlinecontent\models\PageSection;
use seiweb\sortable\actions\SortableGridAction;
use shifrin\noty\NotyAsset;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;


/**
 * Default controller for the `nestedpage` module
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ],
            ],
        ];
    }


    // DefaultController.php
    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => PageSection::className(),
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSettings($id)
    {
        $modules = $this->module->getModules();
        $select2modules = array_combine(array_keys($modules),array_keys($modules));
        $select2blocks = ArrayHelper::map($this->module->layoutBlocks,'id','name');

        $newSection = new PageSection(['page_id' => $id,'block'=>'content']);
        if ($newSection->load(\Yii::$app->request->post()) && $newSection->save(false)) {
            $newSection = new PageSection(['page_id' => $id,'block'=>'content']);
        }

        $query = PageSection::find();

        $query->andFilterWhere([
            'page_id' => $id,
        ]);
        $query->orderBy('block, sort_order');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $pageModel = Page::findOne(['id' => $newSection->page_id]);
        if ($pageModel->load(\Yii::$app->request->post()) && $pageModel->save()) {
            if ($pageModel->parent_id != null) {
                $pageModel->appendTo(Page::findOne($pageModel->parent_id));
                $pageModel->parent_id = null;
            }

        }
        $pgs = Page::findOne(['id' => '1'])->children()->asArray()->all();
        $select2pages = ArrayHelper::map($pgs, 'id', 'title');


        return $this->render('settings', [
            'dataProvider' => $dataProvider,
            'newPageSectionModel' => $newSection,
            'pageModel' => $pageModel,
            'select2pages' => $select2pages,
            'select2blocks' => $select2blocks,
            'select2modules' => $select2modules

        ]);
    }

    public function actionUpdate($id)
    {
        DialogAsset::register($this->view);
        NotyAsset::register($this->view);

        $model = $this->findModel($id);

        $hasModule = \Yii::$app->hasModule('inlinecontent');
        if ($hasModule) {
            $module = \Yii::$app->getModule('inlinecontent');

            $modules = $module->run($id);

            return $this->render('update_inline', ['modules' => $modules, 'pageModel' => $model]);
        }
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Такая страница не найдена');
        }
    }

    public function actionSetMain($id)
    {
        $model = $this->findModel($id);
        $model->is_main = 1;
        $model->full_slug = '';
        $model->save();

        Yii::$app->db->createCommand()->update(Page::tableName(), ['is_main' => 0], 'id <> ' . $id)->execute();
        return $this->actionIndex();
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //переформировываем full_alias всех элементов
        $connection = Yii::$app->db;
        $command = $connection->createCommand("select max(depth) from {{%nested_page}}");
        for ($i = 1; $i <= $command->queryScalar(); ++$i) {
            foreach (Page::findAll(['depth' => $i]) as $d) {
                if($d->is_main) continue;
                $parnt = $d->parents(1)->one();
                $d->full_slug = $parnt->full_slug . '/' . $d->slug;
                $d->full_slug = ltrim($d->full_slug, '/');
                $d->save(false);
            }
        }


        $newPage = new Page();
        if ($newPage->load(\Yii::$app->request->post())) {
            $parent_id = $newPage->parent_id == '' ? 1 : $newPage->parent_id;

            $newPage->appendTo(Page::findOne(['id' => $parent_id]));
            $hasModule = \Yii::$app->hasModule('inlinecontent');
            if ($hasModule) {
                $section = new PageSection(['page_id' => $newPage->id, 'module' => 'wysiwyg', 'sort_order' => 0]);
                $section->save(false);
            }
            $newPage = new Page();
        }


        $query = Page::findOne(['id' => '1'])->children();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $models = $dataProvider->getModels();
        $select2pages = ArrayHelper::map($models, 'id', 'title');

        return $this->render('index', [
            'searchModel' => null,
            'dataProvider' => $dataProvider,
            'newPageModel' => $newPage,
            'select2pages' => $select2pages
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionDeleteSection($id)
    {
        if (($model = PageSection::findOne($id)) !== null) {
            $model->delete();
            return $this->redirect(['settings', 'id' => $model->page_id]);
        } else {
            throw new NotFoundHttpException('Такая страница не найдена');
        }
    }

    public function render($view, $params = [])
    {
        BlockUIAsset::register($this->view);
        return parent::render($view, $params); // TODO: Change the autogenerated stub
    }
}
