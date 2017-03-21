<?php
use yii\bootstrap\Html;

$this->title = $pageModel->title;

?>

<div class="row">
    <div class="col-md-12 float-right">
        <?= Html::a('<span class="glyphicon glyphicon-cog"></span> Настройки страницы',\yii\helpers\Url::to(['settings','id'=>$pageModel->id]),['class'=>'btn btn-success pull-right']) ?>
    </div>
</div>
<p></p>

<?php foreach ($modules as $module) {
    foreach ($module as $c)
    echo $c;
} ?>