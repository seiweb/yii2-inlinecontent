<?php use slatiusa\treetable\Treetable;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Страницы сайта';
?>
<style>
	table.treetable tr.collapsed span.indenter a {
		background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABnElEQVR42nXTvytFYRzH8XNch+u3xUJK2YjSHcgfIAOKFIWSRbFRykDKJplMFDEw4ZZJYjHIcCWDQQZiMRrk1+V6f93Po+Piqdc99zzneb7n+3yf5/je7+bHYrECrk94D/VHdX22n0QikR5sP0z4nqxrStc8RPAq1rLwYQFsXmYA13rRhUYU4xaHWMH5j3QVwNdbqzCFIe/vdo9pLGluyteaU+pYR7/StVTfkESuAuTomWW4g8AV7BE92NSkNw0ew6r6W9WfjxvU2TwLEFG14+iwAqlw1saxgGM0qc+CBOjGlq8CWoqXqNQ2TWjgES7QjnI0o0/Lm7dxLkAh7lCCB5T+U8RObKvgyxh2AbJxihotZ08TbNA+JtGACtQrgxnMWgBL/wWLGA2t0dog1rCLNvUl9UKryYkFiGrdtThAme5tFzZUhxFV/VW7ENdyArcEd5AGdBbCb3LtQ6mf6ZRe270fOsZZGmQP51CdUcCklmI7dBU+iV/fgj4Ol0kRWrz0t2A7c6tiniiYG+f9CKD/gd6W8n63QFl+feY25xO1RHN+gq7RjAAAAABJRU5ErkJggg==') no-repeat;

	}
	table.treetable tr.expanded span.indenter a {
		background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABc0lEQVR42nWTvS8EQRjGZ26tW0FolBKJzke1BYleKYiECI1GoRcNkehEqSJRaFRCosQfoFgRpSgIjVIhvtat57l7RmbX7Zv8dm7m5v14Zt6x5r/ZOI7bMb6DH2890vjBT5Ikjc38wOHPWWOmsQ0E4EvQKqDGAPQrBnA2B6bBCOgCT+ASHIDbXLkKYJW1D6yDJdPcXsAG2JNvZqU508IhWADfmlfcRpCCVklhhScgdAf2BmbBkZyN52i9CmqgCh7BMP0YINBpn4IJbQpMuTFBCGbAsdUBMuod6NU1rYFPzymU4xiYl7QdsOoCdIBnnfgr6C7JPintlLYPll2AFnANBiTnotBEFUljhUOab4ItBqiq3F2w4mkss1QJR8EVA0TSPahm6VGQoMQ50oFPuWv0r2xRveA2p1oPlJWl35hGlz5wbr02djr55zbob5L9jCcP7v1OrL8FPQ5XSScYN/m3cE7NhSYzuQD6HXqlFy1UlfUbos8vRghrfuCzbVMAAAAASUVORK5CYII=') no-repeat;
	}
</style>


	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-folder" aria-hidden="true"></i> Управление страницами</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->


		<?php


$script = <<<EOD
 $(document).on('click', '[data-toggle-main]', function(e){
        e.preventDefault();
        var id = $(this).data('toggle-main');
        var url = $(this).data('url');
        var container = $(this).data('pjax');

console.log(url);

        $.ajax({
            url: url,
            type: 'POST',
            success: function(result) {
                    $.pjax.defaults.timeout = false;//IMPORTANT
                    $.pjax.reload({container:'#'+container});
            }
        });
 });
EOD;

		$this->registerJs($script);
		?>



		<div class="box-body">
			<?php \yii\widgets\Pjax::begin(['id'=>'pages_grid']); ?>
			<?= Treetable::widget([
				'dataProvider' => $dataProvider,
				'tableOptions' => ['class' => 'table table-bordered table-condensed'],
				'rowOptions' => function ($model, $key, $index, $grid) {
					return ['data-tt-id' => $model->id, 'data-tt-parent-id' => $model->parents(1)->one()->id];
				},
				'treetableOptions' => ['expandable' => false],    //Pass configuration options to $().treetable()
				'columns' => [
					[
						'value' => function ($model, $key, $index, $widget) {
							return Html::a($model->title,\yii\helpers\Url::to(['update','id'=>$model->id]),['data-pjax'=>0]);
						},
						'format' => 'raw',
					],
					'route',
					[
						'class' => 'yii\grid\ActionColumn',
						'header'=>'Главная',
						'template' => '{main}',
						'buttons' => [
							'main' => function ($url, $model) {
								if ($model->is_main == 1)
								{
									$icon = '<span class="glyphicon glyphicon-ok text-blue"></span>';
								} else {
									$icon = '<span class="glyphicon glyphicon-ok text-muted"></span>';
								}

								return Html::a($icon, '#', [
									'title' => 'Сделать главной',
									'data-pjax' => 'pages_grid',
									'data-toggle-main' => $model->id,
									'data-url'=>\yii\helpers\Url::to(['set-main','id'=>$model->id])
								]);
							},
						],
					],

					[
						'class' => 'yii\grid\ActionColumn',
						'template' => '{view} {settings} {update} {delete}',
						'buttonOptions'=>['class'=>'test'],
						'buttons' => [
							'view' => function ($url, $model) {
								return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '/'.$model->full_slug, [
									'title' => 'Просмотр',
									'target'=>'_blank',
									'data-pjax'=>0
								]);
							},
							'settings' => function ($url, $model) {
								return Html::a('<span class="glyphicon glyphicon-cog"></span>', \yii\helpers\Url::to(['settings','id'=>$model->id]), [
									'title' => 'Настройки',
									'data-pjax'=>0
								]);
							},

						],
					],

				]
			]); ?>
			<?php \yii\widgets\Pjax::end(); ?>
		</div>
		<div class="box-footer">
			<h3>Новая страница</h3>
			<?php $form = ActiveForm::begin(['layout' => 'default']); ?>


			<?= $form->field($newPageModel, 'title')->textInput(['placeholder' => 'Заголовок страницы', 'maxlength' => true])->label(false) ?>

			<style>
				.select2-rendered__match {
					text-decoration: underline;
				}
			</style>

			<?

			$marcMatchJS = <<<EOD
var query={};

	function markMatch(text,term) {
  // Find where the match is
  var match = text.toUpperCase().indexOf(term.toUpperCase());

  var \$result = \$('<span></span>');

  // If there is no match, move on
  if (match < 0) {
    return \$result.text(text);
  }

  // Put in whatever text is before the match
  \$result.text(text.substring(0, match));

  // Mark the match
  var \$match = \$('<span class="select2-rendered__match"></span>');
  \$match.text(text.substring(match, match + term.length));

  // Append the matching text
  \$result.append(\$match);

  // Put in whatever is after the match
  \$result.append(text.substring(match + term.length));
  console.log(term);

  return \$result;
	}
EOD;


			$func1 = <<<EOD
function(item) {
// No need to template the searching text
    if (item.loading) {
      return item.text;
    }

    var term = query.term || '';
    var \$result = markMatch(item.text, term);

    return \$result;
	  }
EOD;

			$matcherJS = <<<EOD
function (params, data) {

// If there are no search terms, return all of the data
if ($.trim(params.term) === '') {
return data;
}
// `params.term` should be the term that is used for searching
// split by " " to get keywords
keywords=(params.term).split(" ");
// `data.text` is the text that is displayed for the data object
// check if data.text contains all of keywords, if some is missing, return null
for (var i = 0; i < keywords.length; i++) {

if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1)
// Return `null` if the term should not be displayed
return null;

}
// If here, data.text contains all keywords, so return it.
return data;
}
EOD;


			$languageJS = <<<EOD
{
    searching: function (params) {
      // Intercept the query as it is happening
      query = params;

      // Change this to be appropriate for your application
      return 'Searching…';
    }
  }
EOD;


			$this->registerJs($marcMatchJS, yii\web\View::POS_END);


			echo $form->field($newPageModel, 'parent_id')->widget(\kartik\widgets\Select2::className(),

				[
//'language' => 'de',
					//'data' => \yii\helpers\ArrayHelper::map($res, 'model_id', 'name'),
					'data' => $select2pages,
					'options' => ['placeholder' => 'Укажите родительский элемент', 'id' => 0],
					'pluginOptions' => [
						'allowClear' => false,
						'templateResult' => new \yii\web\JsExpression($func1),
						'language' => new \yii\web\JsExpression($languageJS),
						'matcher' => new \yii\web\JsExpression($matcherJS),
					],
				]

			)->label(false);
			?>

			<div class="form-group">
				<?= Html::submitButton('<i class="fa fa-plus" aria-hidden="true"></i> Добавить страницу', ['class' => 'btn btn-success']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>

	</div>



