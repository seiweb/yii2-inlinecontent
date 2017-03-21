<?php

use kartik\date\DatePicker;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>

<?php $form = ActiveForm::begin([
    'id' => 'file_form',
    'action'=>\yii\helpers\Url::to(['/inlinecontent/files/admin/update','id'=>$fileModel->id]),
    'layout'=>'horizontal',
    'options' => [
        'enctype' => 'multipart/form-data',
        'method' => 'POST',
    ]
]); ?>

<?= $form->field($fileModel, 'uf_file_name')->textInput(); ?>
<?= $form->field($fileModel, 'created_at')->widget(\kartik\widgets\DatePicker::className(), [
    'type' => DatePicker::TYPE_INPUT,
    //'value' => '2017-03-09',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'convertFormat' => true,
    ]
]); ?>

<?php // Html::label('Загрузить другой файл вместо этого') ?>
<?php // Html::fileInput('swb_file') ?>

<?= Html::submitButton('Save') ?>
<?= Html::resetButton('Отмена', ['data-dismiss' => "modal"]) ?>




<?php ActiveForm::end(); ?>

