<?php
use kartik\form\ActiveForm;
use yii\bootstrap\Html;

$this->title = $pageModel->title;

?>

<div class="row">
    <div class="col-md-12 float-right">
        <?= Html::a('<i class="fa fa-file-text-o" aria-hidden="true"></i> Редактирование контента', \yii\helpers\Url::to(['update', 'id' => $pageModel->id]), ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<p></p>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-folder" aria-hidden="true"></i> Параметры</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <?php $form = ActiveForm::begin(['options' => ['role' => 'form']]); ?>
    <div class="box-body">
        <?= $form->field($pageModel, 'title')->textInput() ?>
        <?= $form->field($pageModel, 'route')->textInput() ?>
        <?= $form->field($pageModel, 'route_params')->textInput() ?>
        <?php
        echo $form->field($pageModel, 'parent_id')->widget(\kartik\widgets\Select2::className(),

            [
//'language' => 'de',
                //'data' => \yii\helpers\ArrayHelper::map($res, 'model_id', 'name'),
                'data' => $select2pages,
                'options' => ['placeholder' => 'Переместить', 'id' => 0],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]

        )->label(false);
        ?>

    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right">Применить</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-folder" aria-hidden="true"></i> Модули страницы</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="delete_all_images" href="#">Удалить все изображения</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>


    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">

                <?php echo \kartik\grid\GridView::widget([
                    'layout' => "{items}",
                    'dataProvider' => $dataProvider,
                    'condensed' => true,
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-sortable-id' => $model->id];
                    },
                    'export'=>false,
                    'columns' => [
                        ['class' => \seiweb\sortable\grid\Column::className()],
                        'block',
                        'module',
                        'sort_order',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', \yii\helpers\Url::to(['delete-section', 'id' => $model->id]), [
                                        'title' => 'Настройки',
                                    ]);
                                },
                            ]
                        ]
                    ],
                    'options' => [
                        'data' => [
                            'sortable-widget' => 1,
                            'sortable-url' => \yii\helpers\Url::toRoute(['sort']),
                        ]
                    ],
                ]); ?>

            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <b>Добавить модуль</b>
                <?php $form = ActiveForm::begin(); ?>

                <?php
                echo $form->field($newPageSectionModel, 'block')->widget(\kartik\widgets\Select2::className(),

                    [
                        'data' => $select2blocks,
                        'hideSearch'=>true,
                        'options' => ['placeholder' => 'Выберите позицию'],
                    ]

                )->label(false);
                ?>
                <?php
                echo $form->field($newPageSectionModel, 'module')->widget(\kartik\widgets\Select2::className(),

                    [
                        'data' => $select2modules,
                        'hideSearch'=>true,
                        'options' => ['placeholder' => 'Выберите модуль'],
                    ]

                )->label(false);
                ?>

                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <!-- ./box-body -->
    <div class="box-footer">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-footer -->
</div>


<div style="margin-top: 2em">


</div>


