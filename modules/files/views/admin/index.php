<?php

use kartik\file\FileInput;
use kartik\grid\GridView;
use shifrin\noty\NotyAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

use kartik\dialog\DialogAsset;


\seiweb\inlinecontent\modules\files\web\FilesAsset::register($this);


$pjaxContainer = 'pjax_' . $sectionModel->id;

?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'>Загрузка</div>";
yii\bootstrap\Modal::end();
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-folder" aria-hidden="true"></i> Файлы 2.0 :: <?= $sectionModel->block ?>
        </h3>

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


    <?php Pjax::begin(['id' => $pjaxContainer, 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>
    <div class="box-header with-border">
        <?= $this->render('form_options', ['sectionModel' => $sectionModel]) ?>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">

                <?php echo GridView::widget([
                    'layout' => "{items}",
                    'dataProvider' => $filesProvider,
                    'id' => 'GridView' . $sectionModel->id,
                    'condensed' => true,
                    'filterModel' => null,


                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-sortable-id' => $model->id];
                    },
                    'columns' => [
                        ['class' => '\kartik\grid\CheckboxColumn'],
                        ['class' => \seiweb\sortable\grid\Column::className()],

                        [
                            'value' => function ($model, $key, $index, $widget) {
                                return '<span class="rapid-file '.$model->ext.'"></span>' .$model->uf_file_name;
                            },
                            'format' => 'raw',
                            'header' => 'Имя файла',
                        ],
                        [
                            'attribute' => 'ext',
                            'header' => 'Тип',
                            'width' => '50px',
                        ],
                        [
                            'value'=>function ($model)
                            {
                                return Yii::$app->formatter->asDate($model->created_at);
                            }
                        ],
                        [
                            'value' => function ($file) {
                                return Yii::$app->formatter->asShortSize($file->size, 2);
                            },
                            'header' => 'Размер',
                            'format' => 'raw',
                            'width' => '90px'
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{replace} {delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) use ($pjaxContainer) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                                        'title' => Yii::t('app', 'Delete'),
                                        'data-pjax' => $pjaxContainer,
                                        'data-delete-url' => \yii\helpers\Url::to(['/inlinecontent/files/admin/delete']),
                                        'data-delete-file' => $model->id
                                    ]);
                                },
                                'replace' => function ($url, $model) use ($pjaxContainer) {

                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                                        'data-fancybox' => 1,
                                        'data-type' => 'ajax',
                                        //'data-src' => \yii\helpers\Url::to(['/inlinecontent/files/admin/file-edit', 'file_id' => $model->id]),
                                        'value' => Url::to(['/inlinecontent/files/admin/file-edit', 'file_id' => $model->id]),
                                        'class'=>'editFileModal',
                                        'data-pjax' => $pjaxContainer,
                                        'data-title'=>'Редактирование файла'
                                    ]);
                                },

                            ],
                        ],
                    ],
                    'options' => [
                        'data' => [
                            'sortable-widget' => 1,
                            'sortable-url' => \yii\helpers\Url::toRoute(['/inlinecontent/files/admin/sort']),
                        ]
                    ],
                ]); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <?php Pjax::end() ?>
    <!-- ./box-body -->
    <div class="box-footer">
        <div class="row">
            <div class="col-md-6">
                <?php

                $uploadJS = <<<JS
function(e){
    $(this).fileinput('upload');
 }
JS;

                $changeJS = <<<JS
function(e){
    $('#'+$(this).data('pjax')).block();
}
JS;

                $batchuploadCompleteJS = <<<JS
function(e,data){
    $.pjax.defaults.timeout = false;//IMPORTANT
	$.pjax.reload({container:'#'+$(this).data('pjax')});
	noty({text: 'Все файлы загружены!', layout: 'topRight', timeout: 5000, type: 'success', theme: 'metroui'});
	$('.kv-upload-progress').hide();
 }
JS;

                $uploadCompleteJS = <<<JS
function(e,data, pid,index){
	noty({text: 'Файл '+data.files[index].name+' успешно загружен на сервер', layout: 'topRight', timeout: 10000, type: 'information', theme: 'metroui'});
 }
JS;


                $fileInput = new FileInput([
                    'name' => 'swb_file',
                    'language' => 'ru',
                    'options' => [
                        'multiple' => true,
                        'accept' => '*/*',
                        'data-pjax' => $pjaxContainer
                    ],
                    'pluginOptions' => [
                        'uploadUrl' => \yii\helpers\Url::to(['/inlinecontent/files/admin/upload']),
                        'uploadExtraData' => [
                            'model_key' => $sectionModel::className(),
                            'id_object' => $sectionModel->primaryKey,
                        ],
                        'showPreview' => false,
                        'uploadAsync' => true,
                        'showUpload' => false,
                        'showCaption' => false,
                        'showRemove' => false,
                        'showCancel' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="fa fa-upload" aria-hidden="true"></i> ',
                        'browseLabel' => 'загрузить файлы',

                        'dragSettings' => [
                            'animation' => 200,
                        ],
                    ],
                    'pluginEvents' => [
                        'filebatchselected' => new \yii\web\JsExpression($uploadJS),
                        'filebatchuploadcomplete' => new \yii\web\JsExpression($batchuploadCompleteJS),
                        'fileuploaded' => new \yii\web\JsExpression($uploadCompleteJS),
                        'change' => new \yii\web\JsExpression($changeJS),
                    ]
                ]);

                ?>
            </div>
            <div class="col-md-3">
                <?=
                Html::a('<span class="glyphicon glyphicon-remove"></span> Сбросить сортировку', '#', [
                    'id' => 'rrr' . $sectionModel->id,
                    'data-pjax' => 'GridViewPjx' . $sectionModel->id,
                    'data-url' => \yii\helpers\Url::to(['/inlinecontent/files/admin/reset-sort']),
                    'data-reset-sort' => 1,
                    'data-section-id' => $sectionModel->id,
                    'class' => 'btn btn-danger',
                    'style' => 'width:100%'
                ]);

                ?>
            </div>
            <div class="col-md-3">
                <?=
                Html::a('<span class="glyphicon glyphicon-trash"></span> Удалить выбранные', '#', [
                    'title' => Yii::t('app', 'Delete'),
                    'data-pjax' => $pjaxContainer,
                    'data-delete-url' => \yii\helpers\Url::to(['/inlinecontent/files/admin/delete']),
                    'data-delete-files' => 1,
                    'data-grid-id' => "GridView" . $sectionModel->id,
                    'class' => 'btn btn-danger',
                    'style' => 'width:100%'
                ]);

                ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-footer -->
</div>
