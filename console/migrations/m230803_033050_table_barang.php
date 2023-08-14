<?php

use yii\db\Migration;

/**
 * Class m230803_033050_table_barang
 */
class m230803_033050_table_barang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ref_kategori_barang}}', [
            'id' => $this->primaryKey(),
            'kategori' => $this->string(),
        ]);
        $this->batchInsert(
            'ref_kategori_barang',
            [
                'kategori'
            ],
            [
                ["Alat Tulis Kantor (ATK)"],
                ["Aset"],
            ]
        );
        $this->createTable('{{%barang}}', [
            'id' => $this->primaryKey(),
            'id_kategori' => $this->integer(),
            'id_satuan' => $this->integer(),
            'nama_barang' => $this->text(),
            'stok' => $this->integer(),
            'keterangan' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230803_033050_table_barang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230803_033050_table_barang cannot be reverted.\n";

        return false;
    }
    */
}
