<?php

namespace seiweb\inlinecontent\modules\wysiwyg\models;

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.02.2017
 * Time: 2:55
 */
class Model extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%nested_page_wysiwig}}';
	}
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [

			[['section_id'], 'integer'],
			[['content'], 'string'],

		];
	}

}