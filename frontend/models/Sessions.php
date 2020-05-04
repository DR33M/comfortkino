<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sessions".
 *
 * @property int $id
 * @property string|null $date
 * @property int|null $base_price
 * @property int|null $movie_id
 * @property int|null $hall_id
 *
 * @property Halls $hall
 * @property Movies $movie
 * @property SessionsTime[] $sessionsTimes
 * @property Time[] $times
 * @property Tickets[] $tickets
 */
class Sessions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sessions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['base_price', 'movie_id', 'hall_id'], 'integer'],
            [['hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Halls::className(), 'targetAttribute' => ['hall_id' => 'id']],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movies::className(), 'targetAttribute' => ['movie_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'base_price' => 'Base Price',
            'movie_id' => 'Movie ID',
            'hall_id' => 'Hall ID',
        ];
    }

    /**
     * Gets query for [[Hall]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHall()
    {
        return $this->hasOne(Halls::className(), ['id' => 'hall_id']);
    }

    /**
     * Gets query for [[Movie]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movies::className(), ['id' => 'movie_id']);
    }

    /**
     * Gets query for [[SessionsTimes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessionsTimes()
    {
        return $this->hasMany(SessionsTime::className(), ['sessions_id' => 'id']);
    }

    /**
     * Gets query for [[Times]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTime()
    {
        return $this->hasMany(Time::className(), ['id' => 'time_id'])->viaTable('sessions_time', ['sessions_id' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::className(), ['sessions_id' => 'id']);
    }
}
