<?php

use yii\db\Migration;

/**
 * Class m230803_040344_transaksi_keluar
 */
class m230803_040344_transaksi_keluar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaksi_keluar}}', [
            'id' => $this->primaryKey(),
            'id_usulan' => $this->integer(),
            'id_peminjaman' => $this->integer()->defaultValue(NULL),
            'id_barang' => $this->integer(),
            'id_user' => $this->integer(),
            'tanggal' => $this->date(),
            'keterangan' => $this->text(),
        ]);
        $this->createTable('{{%detail_transaksi_keluar}}', [
            'id_transaksi_keluar' => $this->integer(),
            'id_barang' => $this->integer(),
            'jumlah' => $this->integer(),
        ]);
        $this->addPrimaryKey('detail_transaksi_keluar_pk', 'detail_transaksi_keluar', ['id_transaksi_keluar', 'id_barang']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230803_040344_transaksi_keluar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230803_040344_transaksi_keluar cannot be reverted.\n";

        return false;
    }
    */
}
