<?php

use yii\db\Migration;

/**
 * Class m230807_203349_add_table_peminjaman_aset
 */
class m230807_203349_add_table_peminjaman_aset extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%peminjaman_barang}}', [
            'id' => $this->primaryKey(),
            'id_barang' => $this->integer(),
            'id_user' => $this->integer(),
            'id_verifikator' => $this->integer(),
            'cepat_kode_unit' => $this->string(25),
            'nama_barang' => $this->text(),
            'jumlah' => $this->integer(),
            'tanggal_pinjam' => $this->date(),
            'tanggal_kembali' => $this->date(),
            'keterangan' => $this->text(),
            'status' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230807_203349_add_table_peminjaman_aset cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230807_203349_add_table_peminjaman_aset cannot be reverted.\n";

        return false;
    }
    */
}
