<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 09.03.2017
 * Time: 13:25
 */

namespace seiweb\inlinecontent\components;


class View extends \yii\web\View
{
    public function beginBlock($id, $renderInPlace = false)
    {
        return Block::begin([
            'id' => $id,
            'renderInPlace' => $renderInPlace,
            'view' => $this,
        ]);
    }

    public function endBlock()
    {
        Block::end();
    }

    public function renderBlock($id)
    {
        return implode('',$this->blocks[$id]);
    }
}