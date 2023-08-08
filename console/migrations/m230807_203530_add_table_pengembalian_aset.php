<?php

use yii\db\Migration;

/**
 * Class m230807_203530_add_table_pengembalian_aset
 */
class m230807_203530_add_table_pengembalian_aset extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pengembalian_barang}}', [
            'id' => $this->primaryKey(),
            'id_peminjaman_barang' => $this->integer(),
            'jumlah' => $this->integer(),
            'tanggal_pinjam' => $this->date(),
            'tanggal_kembali' => $this->date(),
            'terlambat' => $this->integer(),
            'jumlah_denda' => $this->bigInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230807_203530_add_table_pengembalian_aset cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230807_203530_add_table_pengembalian_aset cannot be reverted.\n";

        return false;
    }
    */
}
