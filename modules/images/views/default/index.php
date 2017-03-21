<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.02.2017
 * Time: 1:11
 */


use yii\helpers\Html;

//$imgs = \seiweb\yii2images\models\Image::find()->where(['model_name' => \seiweb\inlinecontent\models\PageSection::className()])->all();

?>
<?php
$section_id =$model->id;

echo \seiweb\unitegallery\UniteGallery::widget([
    'target' => '#gallery'.$section_id,
    'theme' => 'tilesgrid',
    'config' => [
        'grid_num_rows'=>20,
        'lightbox_type'=>'compact',
        'lightbox_arrows_position'=>'inside',
        'lightbox_slider_image_border'=>false,
        'lightbox_arrows_inside_alwayson'=>true
    ]
]);

?>


<div id="gallery<?= $section_id ?>" style="display:none;">

    <?php

    foreach ($model->images as $img) { ?>
        <?php
        echo Html::img($img->getFitUrl(640, 480), ['data-image' => $img->getFullSizeUrl()]);
        ?>
    <?php } ?>

</div>
