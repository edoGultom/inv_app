<?php

use yii\db\Migration;

/**
 * Class m230403_072646_add_data_auth
 */
class m230403_072646_add_data_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'auth_assignment',
            [
                'item_name',
                'user_id',
                'created_at'
            ],
            [
                ['Verifikator', '1', time()],
            ]
        );

        $this->batchInsert(
            'auth_item',
            [
                'name',
                'type',
                'description',
                'rule_name',
                'data',
                'created_at',
                'updated_at',
            ],
            [
                ['Verifikator', '1', NULL, NULL, NULL, time(), time()],
                ['ASN', '1', NULL, NULL, NULL, time(), time()],
                ['*', '2', NULL, NULL, NULL, time(), time()],
            ]
        );

        $this->batchInsert(
            'auth_item_child',
            [
                'parent',
                'child',
            ],
            [
                ['Verifikator', '*'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230403_072646_add_data_auth cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230403_072646_add_data_auth cannot be reverted.\n";

        return false;
    }
    */
}
