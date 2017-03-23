<?php

namespace seiweb\inlinecontent;

use seiweb\inlinecontent\models\PageSection;


/**
 *
 * Class Module
 * @package backend\modules\dispatcher\components
 *
 */
class BasicModule extends \yii\base\Module
{
    /**
     * Блоки layout'a для генерации вывода
     * @var array
     */
    public $layoutBlocks = [
        [
            'id' => 'content',
            'name' => 'Основное содержимое'
        ],
        [
            'id' => 'sidebar',
            'name' => 'Боковая панель'
        ],
        [
            'id' => 'footer',
            'name' => 'Подвал сайта'
        ]

    ];
    /**
     * @var string dir of modules modules
     */
    public $modulesDir = 'modules';

    /**
     * Названия модулей, доступных к подключению для секции
     * @var array
     */
    public $moduleNames = [];

    /**
     * Контентные модули, находящиеся за пределами папки vendor.
     * Модули, специфические для конкретного сайта.
     * Задается в конфигурации модуля.
     * @var array
     */
    public $externalModules = [];
    /**
     *
     * @var string absolute path to modules dir
     */
    public $modulePath;

    /**
     * Шаблон для главной страницы сайта
     * @var string
     */
    public $homeLayout = '/main';

    /**
     * @var string modules namespace
     */
    private $_modulesNamespace;
    private $_model = [];
    private $_sections = [];

    /**
     *
     * @throws \yii\base\InvalidParamException
     */
    public function init()
    {
        parent::init();


        $this->_setModuleVariables();

        $this->loadModules();
    }

    /**
     * @param       $page_id
     * @param array $data
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */

    /**
     * Set modules namespace and path
     */
    private function _setModuleVariables()
    {
        $class = new \ReflectionClass($this);
        $this->_modulesNamespace = $class->getNamespaceName() . '\\' . $this->modulesDir;
        $this->modulePath = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . $this->modulesDir;
    }

    /**
     * Load modules from directory by path
     * @throws \yii\base\InvalidParamException
     */
    protected function loadModules()
    {
        $handle = opendir($this->modulePath);

        while (($dir = readdir($handle)) !== false) {
            if ($dir === '.' || $dir === '..') {
                continue;
            }

            $class = $this->_modulesNamespace . '\\' . $dir . '\\Module';

            if (class_exists($class)) {
                $this->modules = [
                    $dir => [
                        'class' => $class,
                    ],
                ];
                \Yii::$app->setModule($dir, ['class' => $class]);
            }

        }
        closedir($handle);

        foreach ($this->externalModules as $k => $m) {

            $this->modules = [
                $k => [
                    'class' => $m['class']
                ],
            ];
            \Yii::$app->setModule($k, ['class' => $m['class']]);

        }

        $this->moduleNames = $this->modules;
    }

    /**
     * Для каждой страницей врзвращает массив, содержащий контент, разбитый по блокам
     * @return $data array
     */
    public function run($page_id)
    {
        $model = $this->findModel($page_id);
        $getParams = \Yii::$app->request->get();
        $data = [];
        foreach ($model as $item) {
            if ($controller = $this->findModuleController($item['module'])) {

                //если в \Yii::$app->request->get() есть кастомный контроллер для этого модуля, ренерим его
                if(key_exists($item['module'],$getParams)){
                    $cont = \Yii::createObject($getParams[$item['module']]['swb_controller_class'], [$item['module'], $this]);
                    $action = $cont->createAction($getParams[$item['module']]['swb_action']);
                    
                } else {
                    $cont = \Yii::createObject($controller, [$item['module'], $this]);
                    $action = $cont->createAction('index');
                }

/*
                $cont = \Yii::createObject($controller, [$item['module'], $this]);
                $action = $cont->createAction('index');*/

                //дергаем экшн контроллера подмодуля, с параметрами

                $params = array_merge(
                    [
                        'section_id' => $item['id'],
                    ],
                    $getParams
                );
                $data[$item['block']][] = $action->runWithParams($params);
            }
        }
        return $data;
    }

    /**
     * @param       $layout_id
     * @param array $positions
     *
     * @return array|\yii\db\ActiveRecord[]
     * @internal param $layout
     */
    public function findModel($page_id)
    {
        if (!isset($this->_model[$page_id]))
            $this->_model[$page_id] = PageSection::find()
                ->where([
                    'page_id' => $page_id,
                    'status' => PageSection::STATUS_ACTIVE,
                ])->orderBy([
                    'block' => SORT_ASC,
                    'sort_order' => SORT_ASC
                ])->asArray()->all();
        $this->_sections = $this->_model[$page_id];
        return $this->_model[$page_id];
    }

    /**
     * @param $name
     *
     * @return null|string
     */
    public function findModuleController($name)
    {
        $class = \Yii::$app->modules['inlinecontent']->modules[$name]['class'];
        $model = new $class(['section_id' => $this->id]);
        $className = $model->controllerNamespace . '\\' . $this->defaultControllerName;
        return $className;
        //$res = is_subclass_of($className, SubModuleController::class) ? $className : null;
        //return $res;
    }
}
