<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_status".
 *
 * @property int $id
 * @property string|null $keterangan
 */
class RefStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keterangan' => 'Keterangan',
        ];
    }
    public function getJlhStatus()
    {
        return PengusulanBarang::find()->where([
            'status' => $this->id
        ])->count();
    }

    public function getBgColor($id)
    {
            if ($this->id == 1) {
                return 'bg-primary-light';
            } else if ($this->id == 2) {
                return 'bg-success-light';
            } else if ($this->id == 3) {
                return 'bg-warning-light';
            } else if ($this->id == 4) {
                return 'bg-indigo-light';
            } else{
                return 'bg-pink-light';
            }
    }
    public function getIcLabel($id)
    {
            if ($this->id == 1) {
                return 'fa-solid fa-paper-plane fa-2x tx-primary';
            } else if ($this->id == 2) {
                return 'fa-solid fa-check-to-slot fa-2x tx-success';
            } else if ($this->id == 3) {
                return 'fa-solid fa-comment-dots fa-2x tx-orange';
            } else if ($this->id == 4) {
                return 'fa-solid fa-clipboard-check fa-2x tx-indigo';
            } else if ($this->id == 99) {
                return 'fa-solid fa-rectangle-xmark fa-2x tx-pink';
            }   
         return '';
    }
}
