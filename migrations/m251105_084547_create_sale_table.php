<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale}}`.
 */
class m251105_084547_create_sale_table extends Migration
{
   public function safeUp()
{
    $this->addColumn('sale', 'image', $this->string()->after('description'));
}

public function safeDown()
{
    $this->dropColumn('sale', 'image');
}


}
