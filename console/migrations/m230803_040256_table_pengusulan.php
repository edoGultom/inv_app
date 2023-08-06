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
                [1, "Mengirim Usulan"],
                [2, "Usulan Diterima"],
                [3, "Terima Bersyarat Verifikator"],
                [4, "Terima Bersyarat ASN"],
                [99, "Usulan Ditolak"],
            ]
        );
        $this->createTable('{{%ref_unit}}', [
            'id' => $this->primaryKey(),
            'nama_unit' => $this->text(),
            'cepat_kode' => $this->string(),
        ]);

        $this->batchInsert(
            'ref_unit',
            [
                'nama_unit',
                'cepat_kode'
            ],
            [
                ["SEKRETARIAT", '0207010000'],
                ["BIDANG PENGADAAN, PEMBERHENTIAN DAN INFORMASI", '0207020000'],
                ["BIDANG PENGEMBANGAN APARATUR", '0207040000'],
                ["BIDANG MUTASI DAN PROMOSI", '0207030000'],
                ["BIDANG PENILAIAN KINERJA APARATUR DAN PENGHARGAAN", '0207050000'],
                ["BIDANG KELOMPK JABATAN FUNGSIONAL", '0207060000'],
            ]
        );
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
