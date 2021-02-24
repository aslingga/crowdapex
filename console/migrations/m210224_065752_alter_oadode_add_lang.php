<?php

use yii\db\Migration;

/**
 * Class m210224_065752_alter_oadode_add_lang
 */
class m210224_065752_alter_oadode_add_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('oadode', 'lang', 'INT(10) AFTER business_title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210224_065752_alter_oadode_add_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210224_065752_alter_oadode_add_lang cannot be reverted.\n";

        return false;
    }
    */
}
