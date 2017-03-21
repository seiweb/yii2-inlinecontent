<?php

namespace seiweb\inlinecontent;

use seiweb\ext\NestedSetHelper;
use seiweb\inlinecontent\models\Page;

/**
 * dispatcher module definition class
 */
class FrontendModule extends BasicModule
{
    public $pages = null;

    public $defaultControllerName = 'FrontendController';

    public $inlineModulesList = [
        'wysiwig' => 'Краткое описание модуля',
        'submodule' => 'Не рабочий для тестов',
        'files' => 'Список файлов для загрузки',
    ];

    public $defaultRoute = 'frontend/index';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function getMenu()
    {
        $pages = [];

        foreach ($this->pages as $page) {
            $page['items'] = [];
            foreach ($page['sections'] as $item) {
                $class = $item['module'];
                $module = \Yii::$app->getModule($class);
                $submenu = $module->getMenu();
                if(isset($submenu))
                    foreach ($submenu as $submenuitem)
                    {
                        $submenuitem['url'] = '/'. $page['full_slug'].'/'.$submenuitem['url'];
                        $page['items'][] = $submenuitem;
                    }

            }
            $pages[] = $page;
        }

        return $this->toHierarchy($pages);
    }

    private function toHierarchy($collection,$urlAttribute='full_slug',$main_page_slug = '/')
    {
        // Trees mapped
        $trees = array();
        $l = 0;

        if (count($collection) > 0) {
            // Node Stack. Used to help building the hierarchy
            $stack = array();

            foreach ($collection as $node) {
                $item = [
                    'label'=>$node['title'],
                    'depth'=>$node['depth'],
                    'url'=>$node['is_main']==1?$main_page_slug:'/'.$node[$urlAttribute]
                ];
                $item['items'] = $node['items'];

                // Number of stack items
                $l = count($stack);

                // Check if we're dealing with different levels
                while($l > 0 && $stack[$l - 1]['depth'] >= $item['depth']) {
                    array_pop($stack);
                    $l--;
                }

                // Stack is empty (we are inspecting the root)
                if ($l == 0) {
                    // Assigning the root node
                    $i = count($trees);
                    $trees[$i] = $item;
                    $stack[] = & $trees[$i];
                } else {
                    // Add node to parent
                    $i = count($stack[$l - 1]['items']);
                    $stack[$l - 1]['items'][$i] = $item;
                    $stack[] = & $stack[$l - 1]['items'][$i];
                }
            }
        }

        return $trees;
    }
}