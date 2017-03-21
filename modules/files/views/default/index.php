<?php use yii\grid\GridView;

echo GridView::widget([
    //'layout' => "{items}",
    'dataProvider' => $filesProvider,
    'id' => 'GridView' . $sectionModel->id,
    'filterModel' => null,
    'tableOptions' => ['class' => 'table table-condensed'],
    'showFooter' => true,
    'showHeader' => true,
    //'summary'=>'Summarytext',

    'columns' => [
        [
            'value' => function ($model, $key, $index, $widget) {
                return $href = \yii\bootstrap\Html::a($model->uf_file_name, \yii\helpers\Url::to(['/inlinecontent/files/default/file', 'id' => $model->id]), ['class' => 'rapid_file ' . $model->ext]);
                return '<span class="rapid-file ' . $model->ext . '"></span>' . $model->uf_file_name;
            },
            'format' => 'raw',
            'header' => 'Имя файла',
        ],
        [
            'header' => 'Дата размещения',

            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->created_at);
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                return ['style' => 'vertical-align:middle'];
            },
        ],
        [
            'value' => function ($file) {
                return Yii::$app->formatter->asShortSize($file->size, 2);
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                return ['style' => 'vertical-align:middle'];
            },
            'header' => 'Размер',
            'format' => 'raw',
        ],
    ]
]); ?>