<?php

namespace common\models;
use common\components\UserBehavior;

use Yii;

/**
 * This is the model class for table "transaksi_masuk".
 *
 * @property int $id
 * @property int|null $id_barang
 * @property int|null $id_user
 * @property string|null $tanggal
 * @property string|null $keterangan
 */
class TransaksiMasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaksi_masuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'id_user'], 'default', 'value' => null],
            [['id_barang', 'id_user'], 'integer'],
            [['tanggal'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }
    public function behaviors()
    {
        return [
            UserBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_barang' => 'Id Barang',
            'id_user' => 'Id User',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
        ];
    }
    public function saveDetail($jumlah)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $model = new DetailTransaksiMasuk();
            $model->id_transaksi_masuk = $this->id;
            $model->id_barang = $this->id_barang;
            $model->jumlah = $jumlah;
            if ($model->save()) {
                $transaction->commit();
                return true;
            }else
            return false;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
