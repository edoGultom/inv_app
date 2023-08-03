<?php

use yii\db\Migration;

/**
 * Class m230803_042942_transaksi_masuk
 */
class m230803_042942_transaksi_masuk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaksi_masuk}}', [
            'id' => $this->primaryKey(),
            'id_barang' => $this->integer(),
            'id_user' => $this->integer(),
            'tanggal' => $this->date(),
            'keterangan' => $this->text(),
        ]);
        $this->createTable('{{%detail_transaksi_masuk}}', [
            'id_transaksi_masuk' => $this->integer(),
            'id_barang' => $this->integer(),
            'jumlah' => $this->integer(),
        ]);
        $this->addPrimaryKey('detail_transaksi_masuk_pk', 'detail_transaksi_masuk', ['id_transaksi_masuk', 'id_barang']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230803_042942_transaksi_masuk cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230803_042942_transaksi_masuk cannot be reverted.\n";

        return false;
    }
    */
}
