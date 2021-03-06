<?php

namespace seiweb\inlinecontent;

use Codeception\Exception\ConfigurationException;
use seiweb\inlinecontent\models\Page;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;
use yii\web\UrlRule;
use yii\console\Application as ConsoleApplication;

class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        \yii\helpers\Inflector::$transliterator = 'Russian-Latin/BGN; NFKD';

        if ($app instanceof ConsoleApplication) return;

        if ($app->hasModule('inlinecontent') && ($module = $app->getModule('inlinecontent')) instanceof FrontendModule) {
            $module->pages = Page::find()->with('sections')->andWhere('depth>0')->orderBy('lft')->asArray()->all();

            foreach ($module->pages as $page) {

                if ($page['route'] != '') {
                    //инстанцируем класс и подключаем рулесы
                    //\Yii::$app->setModule()
                    $marr = explode(':',$page['route']);
                    $class = $page['route'];
                    $module_id = md5($page['route'].$page['id']);
                    \Yii::$app->setModule($module_id,$class);
                    /** @var \yii\base\Module $m */
                    $m = \Yii::$app->getModule($module_id);
                    $m->params = $page['route_params'];
                    $m->page = $page;

                    if ($m == null)
                        throw new ConfigurationException('Не правильно задан модуль'.$page['route']);

                    /** @var \yii\base\Controller $controller */
                    //$controller = $m->createController($m->defaultRoute);
                    //echo $controller[0]->runAction($controller[0]->defaultAction);

                    $rules = [];
                    foreach ($m->urlRules as $pattern => $route) {
                        $rules[] = [
                            'pattern' => $pattern,
                            'route' => $route,
                            'defaults'=>['fdsfs'=>'fdsfhdsfjds']
                        ];
                    }


                    $configUrlRule = [
                        'prefix' => $page['full_slug'],
                        //'prefix' => '',
                        'rules' => $m->urlRules,
                        'routePrefix' => $module_id,
                        //'page_slug'=>$page['full_slug']
                    ];

                    $configUrlRule['class'] = \seiweb\inlinecontent\components\GroupUrlRule::className();
                    $rule = \Yii::createObject($configUrlRule);

                    $app->urlManager->addRules([$rule], true);

                    continue;
                }


                $app->urlManager->rules[] = new UrlRule([
                    'pattern' => '/' . $page['full_slug'],
                    'route' => 'inlinecontent/frontend/view',
                    'defaults' => ['full_slug' => $page['full_slug']]
                ]);
                foreach ($page['sections'] as $item) {
                    $class = $item['module'];
                    $module = \Yii::$app->getModule($class);
                    $submenu = $module->getMenu();
                    $subRules = $module->getUrlRules();

                    if (isset($subRules))
                        foreach ($subRules as $subRule => $rule)
                            $app->urlManager->rules[] = new UrlRule([
                                'pattern' => '/' . $page['full_slug'] . $subRule,
                                'route' => 'inlinecontent/frontend/view',
                                'defaults' => [
                                    'full_slug' => $page['full_slug'],
                                    $class => [
                                        'swb_controller_class' => $rule['controller'],
                                        'swb_action' => $rule['action'],
                                    ]
                                ]
                            ]);

                    /*
                    if (isset($submenu))
                        foreach ($submenu as $submenuitem) {
                            if (isset($subRules))
                                foreach ($subRules as $subRule=>$action)
                                    $app->urlManager->rules[] = new UrlRule([
                                        'pattern' => '/' . $page['full_slug'] . '/' . $submenuitem['url'] . $subRule,
                                        'route' => 'inlinecontent/frontend/view',
                                        'defaults' => ['full_slug' => $page['full_slug']]
                                    ]);
                            else
                                $app->urlManager->rules[] = new UrlRule([
                                    'pattern' => '/' . $page['full_slug'] . '/' . $submenuitem['url'],
                                    'route' => 'inlinecontent/frontend/view',
                                    'defaults' => ['full_slug' => $page['full_slug']]
                                ]);
                        }
                    */
                }


            }


        }
    }

}
