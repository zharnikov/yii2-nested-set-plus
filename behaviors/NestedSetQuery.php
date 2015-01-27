<?php
/**
 * @link https://github.com/wbraganca/yii2-nested-set-behavior
 * @copyright Copyright (c) 2014 Wanderson Bragança
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace kgladkiy\behaviors;

use kgladkiy\behaviors\NestedSetQueryBehavior;

/**
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
class NestedSetQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            [
                'class' => NestedSetQueryBehavior::className(),
            ]
        ];
    }
}
