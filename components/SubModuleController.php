<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.02.2017
 * Time: 2:19
 */

namespace seiweb\inlinecontent\components;


use seiweb\inlinecontent\Module;

class SubModuleController extends \yii\web\Controller
{
    public $description = 'Описание модуля';
    public $name = 'Название';

	/**
	 * @param string $view
	 * @param array $params
	 * @return string
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\base\ViewNotFoundException
	 * @throws \yii\base\InvalidCallException
	 */
	public function render($view, $params = [])
	{
		return $this->getView()->render($view, $params, $this);
	}

}
