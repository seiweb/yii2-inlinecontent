<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.02.2017
 * Time: 18:12
 */

namespace seiweb\inlinecontent\models;


use creocoder\nestedsets\NestedSetsQueryBehavior;

class PageQuery extends \yii\db\ActiveQuery
{
	public function behaviors() {
		return [
			NestedSetsQueryBehavior::className(),
		];
	}
}