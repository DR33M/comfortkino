<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use app\models\MovieTheaters;
use app\models\Halls;
use app\models\Sessions;
use app\models\Movies;

use frontend\components\CacheDuration;
use frontend\components\MovieTheater;

use yii\helpers\ArrayHelper;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $sessions = Sessions::find()
            ->select('date')
            ->where('date > :date', [':date' => date('Y-m-d', strtotime('- 1 day'))])
            ->groupBy('date')
            ->asArray()
            ->all();

        $dayList = [];

        if ($sessions) {
            $length = (
                    strtotime($sessions[count($sessions) - 1]['date']) //get last session date
                    - strtotime(date('Y-m-d', strtotime('- 1 day'))) //get yesterday day ('- 1 day' - count today)
                ) / (60 * 60 * 24); //get difference in days
        } else $length = 0;
        $minLengthDayList = 9; //week + this day + 1 because for ($i < 9) so max $i == 8

        if ($length < $minLengthDayList)
            $length = $minLengthDayList;

        $dayList['date'] = MovieTheater::generateDayList($length, date('Y-m-d'));

        for ($i = 0, $j = 0; $i < $length; $i++)
            if (isset($sessions[$j]) && $dayList['date'][$i]['Y-m-d'] == $sessions[$j]['date']) {
                $dayList['empty_day'][$i] = true;
                $j++;
            } else $dayList['empty_day'][$i] = false;

        return $this->render('index', [
            'dayList' => $dayList,
        ]);
    }

    public function actionFilm($id)
    {
        $sessions = MovieTheater::getSessionById($id);
        $movie = MovieTheater::getMoviesForThisSession($sessions);

        if (!$movie){
            return $this->goHome();
        }

        $imagesPath = MovieTheater::getImagesPathFromGalleryByMovieId($movie[0]['id']);

        return $this->render('film', [
            'sessions' => $sessions,
            'movie' => $movie[0],
            'imagesPath' => $imagesPath,
        ]);
    }

    public function actionMovies()
    {
        $post = Yii::$app->request->post();

        $post['date'] = '2020-05-04';

        if (!isset($post['date']))
            return null;

        $sessions = Sessions::find()
            ->with('time', 'timePrices')
            ->where(['date' => $post['date']])
            ->andWhere(['hall_id' => array_map(
            'intval', ArrayHelper::getColumn(
                        Halls::find()
                            ->select('id')
                            ->where(['movie_theaters_id' => MovieTheaters::find()
                                    ->select(['id'])
                                    ->where(['subdomain_name' => Yii::$app->session->get('subdomain')])
                                    ->one()]
                            )->asArray()
                            ->all(), 'id'
                        )
                    )
                ])->asArray()
            ->all();

        $movies = Movies::find()
            ->with('genres', 'countries')
            ->where(['id' => array_map('intval', ArrayHelper::getColumn($sessions, 'movie_id'))]
            )->asArray()->all();

        return $this->renderPartial('movies', [
            'sessions' => $sessions,
            'movies' => $movies
        ]);
    }
}
