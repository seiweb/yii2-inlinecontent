<?php

namespace seiweb\inlinecontent\models;

use seiweb\sortable\behaviors\SortableGridBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%content_page_section}}".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $module
 * @property integer $sort_order
 * @property integer $status
 */
class PageSection extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nested_page_section}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sort_order',
                'scopeAttribute'=>['page_id','block']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'module', 'sort_order','block'], 'required'],
            [['page_id', 'sort_order', 'status'], 'integer'],
            [['module','block'], 'string', 'max' => 255],
            [['options'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'module' => 'Модуль',
            'block' => 'Блок',
            'sort_order' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord) {
            //получаем конфиг по умолчанию
            $class = Yii::$app->modules['inlinecontent']->modules[$this->module]['class'];
            $model = new $class(['section_id' => $this->id]);
            $this->options = serialize($model->defaultConfig);
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert) {
            //создаем запись в БД для дефолтной модели выбранного модуля
            //$namespace = 'seiweb\inlinecontent\modules\\' . $this->module . '\Module';
            $class = Yii::$app->modules['inlinecontent']->modules[$this->module]['class'];
            $model = new $class(['section_id' => $this->id]);
            $model->initSection($this->id);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        //создаем запись в БД для дефолтной модели выбранного модуля
        //$namespace = 'seiweb\inlinecontent\modules\\' . $this->module . '\Module';

        $class = Yii::$app->modules['inlinecontent']->modules[$this->module]['class'];
        $model = new $class(['section_id' => $this->id]);
        $model->deleteSection($this->id);
    }

    public function getOptionsArray()
    {
        return unserialize($this->options);
    }
}
