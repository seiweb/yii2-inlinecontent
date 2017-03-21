<?php use vova07\imperavi\Widget;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\Pjax;

?>





<?php yii\widgets\Pjax::begin(['enablePushState' => false,'id'=>'pjx'.$model->section_id]) ?>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> Текстовый редактор :: <?= $section['block'] ?></h3>

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

	<?php $form = ActiveForm::begin(['id'=>'wysiwig'.$model->section_id,'action' =>['/inlinecontent/wysiwyg/admin/index?section_id='.$model->section_id],'options' => ['data-pjax' => 1]]); ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">


				<?= $form->field($model, 'content')->widget(Widget::className(), [
					'options'=>['id'=>'ta'.$model->section_id,'htmlOptions'=>'width:100%'],
					'settings' => [
						'lang' => 'ru',
						'minHeight' => 200,
						'plugins' => [
							//'clips',
							'fullscreen',
							'imagemanager',
							'fontcolor'
						]
					]
				])->label(false);
				?>






			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>

	<!-- ./box-body -->
	<div class="box-footer">
		<div class="row">
			<div class="col-md-12">

				<?= Html::submitButton('Применить', ['class' => 'btn btn-success']) ?>
				<?php if (Yii::$app->session->hasFlash('section_success')): ?>
					<script>noty({text: 'Данные успешно обновлены.', layout: 'topRight', timeout: 5000, type: 'success', theme: 'metroui'});</script>
				<?php endif; ?>

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.box-footer -->
	<?php ActiveForm::end(); ?>
</div>
<?php Pjax::end(); ?>

<div style="margin-top: 2em">




</div>