<?php use yii\helpers\Html;

echo Html::beginForm(\yii\helpers\Url::to(['/inlinecontent/files/admin/options', 'section_id' => $sectionModel->id]), 'post', ['id' => 'options_form' . $sectionModel->id, 'data-pjax' => 1]); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo Html::textInput('options[section_title]', $sectionModel->optionsArray['section_title'], ['placeholder' => 'Укажите заголовок', 'style' => 'width:95%', 'class' => 'form-control input-sm']) ?>
    </div>
    <div class="col-sm-2">
        <label>
            <?php echo Html::checkbox('options[show_section_title]', $sectionModel->optionsArray['show_section_title']) ?>
            Отображать
        </label>
    </div>
    <div class="col-sm-4">
        <?php echo Html::submitButton('Применить', ['class' => 'btn btn-default btn-xs', 'id' => 'test' . $sectionModel->id]) ?>
    </div>
</div>
<?php echo Html::endForm(); ?>
