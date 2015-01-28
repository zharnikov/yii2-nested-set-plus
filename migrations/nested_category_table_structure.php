<?php
/**
 * @project   Nested Set Plus
 * @author    Kirill Gladkiy <kirill.gladkiy@gmail.com>
 * @link      https://github.com/kgladkiy/yii2-nested-set-plus
 * @date      21.01.2015
 * @version   0.2
 */

use yii\db\Schema;
use yii\db\Migration;

class nested_category_table_structure extends Migration
{

    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}', [
            'id' => Schema::TYPE_PK,
            'root' => Schema::TYPE_INTEGER . ' UNSIGNED NULL DEFAULT NULL',
            'lft' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'level' => Schema::TYPE_SMALLINT . '(5) UNSIGNED NOT NULL',
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
        ], $tableOptions);

        $this->createIndex('idx_root', '{{%category}}', 'root');
        $this->createIndex('idx_lft', '{{%category}}', 'lft');
        $this->createIndex('idx_rgt', '{{%category}}', 'rgt');
        $this->createIndex('idx_level', '{{%category}}', 'level');

    }

    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
