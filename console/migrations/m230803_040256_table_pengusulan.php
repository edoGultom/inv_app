<?php

use yii\db\Migration;

/**
 * Class m230803_040256_table_pengusulan
 */
class m230803_040256_table_pengusulan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%ref_status}}', [
            'id' => $this->primaryKey(),
            'keterangan' => $this->string(),
        ]);
        $this->batchInsert(
            'ref_status',
            [
                'id',
                'keterangan'
            ],
            [
                [1, "Kirim Usulan"],
                [2, "Terima Usulan"],
                [99, "Tolak Usulan"],
            ]
        );
        $this->createTable('{{%ref_unit}}', [
            'id' => $this->primaryKey(),
            'nama_unit' => $this->text(),
            'cepat_kode' => $this->string(),
        ]);
        $this->createTable('{{%pengusulan_barang}}', [
            'id' => $this->primaryKey(),
            'id_barang' => $this->integer(),
            'id_user' => $this->integer(),
            'cepat_kode_unit' => $this->string(25),
            'nama_barang' => $this->text(),
            'jumlah' => $this->integer(),
            'tanggal' => $this->date(),
            'keterangan' => $this->text(),
            'status' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230803_040256_table_pengusulan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230803_040256_table_pengusulan cannot be reverted.\n";

        return false;
    }
    */
}
