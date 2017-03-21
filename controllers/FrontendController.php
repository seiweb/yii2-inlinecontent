<?php

namespace seiweb\inlinecontent\controllers;

use seiweb\inlinecontent\models\Page;
use seiweb\inlinecontent\modules\wysiwyg\models\PageSectionWysiwig;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `nestedpage` module
 */
class FrontendController extends Controller
{
    public function actionView($full_slug = null)
    {
        if ($full_slug == null) {
            $page = Page::find()->where(['is_main' => 1])->one();
            $this->layout = \Yii::$app->getModule('inlinecontent')->homeLayout;
        } else
            $page = Page::find()->where(['full_slug' => $full_slug])->one();

        $parents = $page->parents()->andWhere('depth>0')->all();


        if ($page == null)
            throw new NotFoundHttpException('Такая страница не найдена');

        $module = \Yii::$app->getModule('inlinecontent');
        $module->defaultControllerName = 'DefaultController';
        $cnt = $module->run($page->id);
        return $this->render('view', ['content' => $cnt, 'pageModel' => $page, 'parents' => $parents]);
    }
}
