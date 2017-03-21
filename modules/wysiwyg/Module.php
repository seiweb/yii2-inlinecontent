<?php
namespace seiweb\inlinecontent\modules\wysiwyg;
use seiweb\inlinecontent\components\BaseModule;
use seiweb\inlinecontent\components\InlineModule;
use seiweb\inlinecontent\components\ModuleInterface;
use seiweb\inlinecontent\modules\wysiwyg\models\Model;
use yii\db\ActiveRecord;

/**
 * test module definition class
 */
class Module extends InlineModule
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'seiweb\inlinecontent\modules\wysiwyg\controllers';

	public function init()
	{
		parent::init();
	}

	//инициализируем созданную секцию
	public function initSection($section_id){
		$model = new Model(['section_id'=>$section_id]);
		$model->save();
	}

	public function deleteSection($section_id){
		$model = Model::findOne(['section_id'=>$section_id]);
		$model->delete();
	}

	public function beforeDeleteSection($section)
    {
        $wysiwyg = Model::findOne(['section_id'=>$section->id]);
        if($wysiwyg!=null)
            $wysiwyg->delete();
        return true;
    }

    /**
	 * @return array
	 */
	public function getDefaultConfig()
	{
		return [
			'param1'=>['tets'=>1,'test2'=>2],
			'someParam'=>'somevalue',
			'admin_email'=>'email'
		];
	}

    public function getMenu()
    {

    }
    public function getUrlRules()
    {
        return null;
    }
}