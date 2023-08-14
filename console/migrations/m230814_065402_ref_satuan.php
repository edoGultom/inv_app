<?php

use yii\db\Migration;

/**
 * Class m230814_065402_ref_satuan
 */
class m230814_065402_ref_satuan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ref_satuan}}', [
            'id' => $this->primaryKey(),
            'satuan' => $this->string(),
        ]);
        $this->batchInsert(
            'ref_satuan',
            [
                'satuan'
            ],
            [
                ["pak"],
                ["buah"],
                ["set"],
                ["lusin"],
                ["buku"],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230814_065402_ref_satuan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230814_065402_ref_satuan cannot be reverted.\n";

        return false;
    }
    */
}
