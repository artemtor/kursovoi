<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yacht".
 *
 * @property int $id_yacht
 * @property string $name_yacht
 * @property string $max_human
 * @property int $price
 * @property string $avatar
 *
 * @property Trip[] $trips
 */
class Yacht extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yacht';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_yacht', 'max_human', 'price', 'avatar'], 'required'],
            [['price'], 'integer'],
            [['name_yacht', 'max_human', 'avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_yacht' => 'Id Yacht',
            'name_yacht' => 'Name Yacht',
            'max_human' => 'Max Human',
            'price' => 'Price',
            'avatar' => 'Avatar',
        ];
    }

    /**
     * Gets query for [[Trips]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trip::class, ['yacht_id' => 'id_yacht']);
    }
}
