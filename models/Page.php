<?php

namespace seiweb\inlinecontent\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%content_page}}".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $alias
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 */
class Page extends \yii\db\ActiveRecord
{
	public $parent_id = null;

	public static function find()
	{
		return new PageQuery(get_called_class());
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%nested_page}}';
	}

	public function behaviors()
	{
		return [
			'tree' => [
				'class' => NestedSetsBehavior::className(),
				'treeAttribute' => 'tree',
				// 'leftAttribute' => 'lft',
				// 'rightAttribute' => 'rgt',
				// 'depthAttribute' => 'depth',
			],
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				// if you're using datetime instead of UNIX timestamp:
				'value' => new Expression('NOW()'),
			],
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'title',
				'slugAttribute' => 'slug',
				'ensureUnique' => true,
			],
		];
	}

	public function transactions()
	{
		return [
			self::SCENARIO_DEFAULT => self::OP_ALL,
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['lft', 'rgt', 'depth', 'parent_id', 'is_main'], 'integer'],
			[['created_at', 'updated_at'], 'safe'],
			[['title', 'slug', 'modified_by', 'route', 'route_params'], 'string', 'max' => 255],
			[['html', 'full_slug'], 'string']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'depth' => 'Depth',
			'title' => 'Заголовок',
			'alias' => 'Alias',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
		];
	}

	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			Yii::trace("Delete Page: {$this->title}", __METHOD__);
			foreach ($this->children(1)->all() as $child) {
				$child->delete();
			}
			foreach ($this->sections as $section) {
				$section->delete();
			}
			return true;
		} else {
			return false;
		}
	}

	public function getSections()
	{
		return $this->hasMany(PageSection::className(), ['page_id' => 'id']);
	}
}
