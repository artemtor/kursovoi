<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trip".
 *
 * @property int $id_trip
 * @property int $yacht_id
 * @property string $date_trip
 * @property string $city
 * @property string $seat
 *
 * @property Request[] $requests
 * @property Yacht $yacht
 */
class Trip extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yacht_id', 'date_trip', 'city'], 'required'],
            [['yacht_id'], 'integer'],
            [['seat'], 'string'],
            [['date_trip', 'city'], 'string', 'max' => 255],
            [['yacht_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yacht::class, 'targetAttribute' => ['yacht_id' => 'id_yacht']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_trip' => 'Id Trip',
            'yacht_id' => 'Yacht ID',
            'date_trip' => 'Date Trip',
            'city' => 'City',
            'seat' => 'Seat',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['trip_id' => 'id_trip']);
    }

    /**
     * Gets query for [[Yacht]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYacht()
    {
        return $this->hasOne(Yacht::class, ['id_yacht' => 'yacht_id']);
    }
}
