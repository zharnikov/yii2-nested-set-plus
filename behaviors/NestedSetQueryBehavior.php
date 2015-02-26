<?php
/**
 * @project   Nested Set Plus
 * @author    Kirill Gladkiy <kirill.gladkiy@gmail.com>
 * @link      https://github.com/kgladkiy/yii2-nested-set-plus
 * @date      21.01.2015
 * @version   0.2
 */

namespace kgladkiy\behaviors;

use yii\base\Behavior;

class NestedSetQueryBehavior extends Behavior
{
    /**
     * @var ActiveQuery the owner of this behavior.
     */
    public $owner;

    /**
     * Gets root node(s).
     * @return ActiveRecord the owner.
     */
    public function roots()
    {
        /** @var $modelClass ActiveRecord */
        $modelClass = $this->owner->modelClass;
        $model = new $modelClass;
        $this->owner->andWhere($modelClass::getDb()->quoteColumnName($model->leftAttribute) . '=1');
        unset($model);
        return $this->owner;
    }

    public function tree($root = false, $level = null)
    {

        $tree = [];

        if ($root === false) {
            $ownerClass = $this->owner->modelClass;
            $items = $ownerClass::find()->roots()->all();
        } elseif($root->{$root->rightAttribute} - $root->{$root->leftAttribute} > 1) {
            $items = $root->children()->all();
        }
        else {
            $items = [];
        }

        foreach ($items as $item) {
            $tree[$item->id] = [
                'id' => $item->id,
                'name' => $item->{$item->titleAttribute},
                'children' => $this->tree($item),
            ];
        }

        return $tree;

    }

    public function options($root = 0, $level = null, $path = null, $exclude = null)
    {
        $res = [];
        if (is_object($root) && $root->id != $exclude) {
            $res[$root->{$root->idAttribute}] = $path
                . ((($root->{$root->levelAttribute}) > 1) ? ' -> ': '')
                . $root->{$root->titleAttribute};

            if ($level) {
                foreach ($root->children()->all() as $childRoot) {
                    $res += $this->options($childRoot, $level - 1, $level, $exclude);
                }
            } elseif (is_null($level)) {
                foreach ($root->children()->all() as $childRoot) {
                    $res += $this->options($childRoot, null, ($path) ? $path . ' -> ' . $root->{$root->titleAttribute} : $root->{$root->titleAttribute}, $exclude);
                }
            }
        } elseif (is_scalar($root) && $root != $exclude) {
            if ($root == 0) {
                foreach ($this->roots()->all() as $rootItem) {
                    if ($level) {
                        $res += $this->options($rootItem, $level - 1, $rootItem->{$rootItem->titleAttribute}, $exclude);
                    } elseif (is_null($level)) {
                        $res += $this->options($rootItem, null, null, $exclude);
                    }
                }
            } else {
                $modelClass = $this->owner->modelClass;
                $model = new $modelClass;
                $root = $modelClass::find()->andWhere([$model->idAttribute => $root])->one();
                if ($root) {
                    $res += $this->options($root, $level);
                }
                unset($model);
            }
        }
        return $res;
    }

}
