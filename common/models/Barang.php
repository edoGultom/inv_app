<?php

namespace common\models;

use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "barang".
 *
 * @property int $id
 * @property int|null $id_kategori
 * @property string|null $nama_barang
 * @property int|null $stok
 * @property string|null $keterangan
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barang';
    }

    /**
     * {@inheritdoc}
     */
    public $newStock;
    public function rules()
    {
        return [
            [['id_kategori', 'stok'], 'default', 'value' => null],
            [['id_kategori', 'stok'], 'integer'],
            [['nama_barang', 'keterangan'], 'string'],
            ['newStock', 'safe'],

        ];
    }
   

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kategori' => 'Id Kategori',
            'nama_barang' => 'Nama Barang',
            'stok' => 'Stok',
            'keterangan' => 'Keterangan',
        ];
    }
    public function getRefKategori()
    {
        return $this->hasOne(RefKategoriBarang::className(), ['id' => 'id_kategori']);
    }
    public function getIsUsulan()
    {
        return $this->hasOne(PengusulanBarang::className(), ['id_barang' => 'id'])->exists();
    }
    public function getIsUpdateStock()
    {
        return $this->hasOne(TransaksiKeluar::className(), ['id_barang' => 'id'])->exists();
    }
    
    public function getDataKategori()
    {
        return ArrayHelper::map(RefKategoriBarang::find()->all(), 'id', 'kategori');
    }
    public function setNewStok($in)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $barang = Barang::findOne(['id' => $this->id]);
            if (!$barang) {
                return false;
            }
            $barang->stok += $in;
            if($barang->save()){
                $transaction->commit();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function saveTransaksiMasuk()
    {

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $model = new TransaksiMasuk();
            $model->id_barang = $this->id;
            $model->tanggal = date('Y-m-d');
            $model->keterangan = $this->keterangan;

            if ($model->save() && $this->setNewStok($this->newStock) && $model->saveDetail($this->newStock)) {
                $transaction->commit();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
