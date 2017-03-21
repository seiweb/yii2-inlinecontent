<?php

namespace seiweb\inlinecontent;

/**
 * dispatcher module definition class
 */
class AdminModule extends BasicModule
{
    public $defaultControllerName = 'AdminController';
    public $defaultRoute = 'admin/index';

	public $inlineModulesList = [
		'wysiwig'=>'Краткое описание модуля',
		'submodule'=>'Не рабочий для тестов',
		'files'=>'Список файлов для загрузки',
	];


	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
	}
}