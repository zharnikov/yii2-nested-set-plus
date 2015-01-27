<?php

namespace kgladkiy\widgets;

/**
 * Asset bundle for Nestable Widget
 *
 * @author Kirill Gladkiy <kirill.gadkiy@gmail.com>
 * @since 1.0
 */
class NestedListAsset extends \yii\web\AssetBundle
{

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../assets';
        $this->css = ['css/nestable.css'];
        $this->js = ['js/jquery.nestable.js'];
        $this->depends = ['yii\web\JqueryAsset'];
        parent::init();
    }

}