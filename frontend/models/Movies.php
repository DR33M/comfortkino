<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movies".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $duration
 * @property int|null $age
 * @property string|null $poster
 * @property string|null $mob_poster
 * @property string|null $gallery
 * @property string|null $release_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Gallery[] $galleries
 * @property MoviesCountries[] $moviesCountries
 * @property Countries[] $countries
 * @property MoviesGenres[] $moviesGenres
 * @property Genres[] $genres
 * @property Sessions[] $sessions
 * @property Tickets[] $tickets
 */
class Movies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['duration', 'release_date', 'created_at', 'updated_at'], 'safe'],
            [['age'], 'integer'],
            [['title', 'poster', 'mob_poster', 'gallery'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'duration' => 'Duration',
            'age' => 'Age',
            'poster' => 'Poster',
            'mob_poster' => 'Mob Poster',
            'gallery' => 'Gallery',
            'release_date' => 'Release Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Galleries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGalleries()
    {
        return $this->hasMany(Gallery::className(), ['movies_id' => 'id']);
    }

    /**
     * Gets query for [[MoviesCountries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMoviesCountries()
    {
        return $this->hasMany(MoviesCountries::className(), ['movies_id' => 'id']);
    }

    /**
     * Gets query for [[Countries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Countries::className(), ['id' => 'countries_id'])->viaTable('movies_countries', ['movies_id' => 'id']);
    }

    /**
     * Gets query for [[MoviesGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMoviesGenres()
    {
        return $this->hasMany(MoviesGenres::className(), ['movies_id' => 'id']);
    }

    /**
     * Gets query for [[Genres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genres::className(), ['id' => 'genres_id'])->viaTable('movies_genres', ['movies_id' => 'id']);
    }

    /**
     * Gets query for [[Sessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessions()
    {
        return $this->hasMany(Sessions::className(), ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::className(), ['movie_id' => 'id']);
    }
}