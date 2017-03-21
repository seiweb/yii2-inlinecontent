<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 09.03.2017
 * Time: 13:30
 */

namespace seiweb\inlinecontent\components;


class Block extends \yii\widgets\Block
{
    /**
     * @var bool whether to render the block content in place. Defaults to false,
     * meaning the captured block content will not be displayed.
     */
    public $renderInPlace = false;


    /**
     * Starts recording a block.
     */
    public function init()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     */
    public function run()
    {
        $block = ob_get_clean();
        if ($this->renderInPlace) {
            echo $block;
        }
        $this->view->blocks[$this->getId()][] = $block;
    }
}