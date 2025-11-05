<?php

use yii\db\Migration;

class m251105_112525_add_image_to_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function safeUp()
{
    $this->addColumn('sale', 'image', $this->string()->after('description'));
}

public function safeDown()
{
    $this->dropColumn('sale', 'image');
}


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251105_112525_add_image_to_sale_table cannot be reverted.\n";

        return false;
    }
    */
}
