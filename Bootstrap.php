<?php

namespace seiweb\inlinecontent;

use seiweb\inlinecontent\models\Page;
use yii\base\BootstrapInterface;
use yii\web\UrlRule;
use yii\console\Application as ConsoleApplication;

class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        if($app instanceof ConsoleApplication) return;

        if ($app->hasModule('inlinecontent') && ($module = $app->getModule('inlinecontent')) instanceof FrontendModule) {
            $module->pages = Page::find()->with('sections')->andWhere('depth>0')->orderBy('lft')->asArray()->all();
            foreach ($module->pages as $page) {
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
                        foreach ($subRules as $subRule=>$action)
                            $app->urlManager->rules[] = new UrlRule([
                                'pattern' => '/' . $page['full_slug']  . $subRule,
                                'route' => 'inlinecontent/frontend/view',
                                'defaults' => ['full_slug' => $page['full_slug']]
                            ]);

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

                }


            }


        }
    }

}
