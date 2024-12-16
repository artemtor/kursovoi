<?php
namespace app\controllers;
use app\models\Request;
use app\models\Trip;
use app\models\User;
use app\models\Yacht;
use Yii;
class RequestController extends FunctionController
{
  public $modelClass = 'app\models\Request';

  public function actionDelete($trip_id) {
    $user = User::getByToken();

    if (!($user && $user->isAuthorized())) {
        return $this->send(403, ['error' => ['message' => 'Доступ запрещен']]);
    }

    // Поиск запроса по trip_id и user_id
    $request = Request::find()
        ->where(['trip_id' => $trip_id, 'user_id' => $user->id_user])
        ->one();

    if ($request) {
        $request->delete();
        return $this->send(200, null);
    } else {
        return $this->send(404, ['error' => ['code' => 404, 'message' => 'Not found', 'errors' => ['Рейс не найден']]]);
    }
}

public function actionFormalization()
{
    // Получаем токен из заголовка авторизации
    $user = User::getByToken();
    
    // Проверяем авторизацию пользователя
    if (!$user || !$user->isAuthorized()) {
        return $this->asJson([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
            ]
        ])->setStatusCode(401);
    }

    // Получаем данные из POST-запроса
    $requestData = Yii::$app->request->post();

    // Создаем модель для валидации данных
    $requestModel = new Request();
    $requestModel->load($requestData, '');

    // Устанавливаем user_id на основе авторизованного пользователя
    $requestModel->user_id = $user->id_user;

    // Валидация данных
    if (!$requestModel->validate()) {
        return $this->asJson([
            'error' => [
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $requestModel->getErrors(),
            ]
        ])->setStatusCode(422);
    }

    // Сохраняем запрос (оформление билета)
    if ($requestModel->save()) {
        return $this->asJson([
            'user_id' => $requestModel->user_id,
            'trip_id' => $requestModel->trip_id,
        ])->setStatusCode(200);
    } else {
        return $this->asJson([
            'error' => [
                'code' => 500,
                'message' => 'Internal Server Error',
            ]
        ])->setStatusCode(500);
    }
}



    

    // Метод для получения заявок пользователя
    public function actionOrder()
{
    $user = User::getByToken();
    
    if (!$user || !$user->isAuthorized()) {
        return $this->asJson([
            'error' => [
                'code' => 403,
                'message' => 'Доступ запрещен'
            ]
        ])->setStatusCode(403);
    }

    // Получаем заявки пользователя
    $requests = Request::find()
        ->with(['trip.yacht']) // Загружаем связанные модели Trip и Yacht
        ->where(['user_id' => $user->id_user]) // Фильтруем по ID пользователя
        ->all();

    // Формируем ответ
    $result = [];
    foreach ($requests as $request) {
        $trip = $request->trip; // Получаем связанную модель Trip
        if ($trip) {
            $result[] = [
                'name_yacht' => $trip->yacht ? $trip->yacht->name_yacht : null, // Название яхты (varchar)
                'date_trip' => (string)$trip->date_trip, // Дата аренды (varchar)
                'city' => (string)$trip->city, // Город (varchar)
                'max_human' => (string)($trip->yacht ? $trip->yacht->max_human : null), // Максимальное число человек (varchar)
                'trip_id' => (int)$request->id_request, // Номер заказа (int)
            ];
        }
    }

    return $this->asJson($result)->setStatusCode(200); // Возвращаем результат в формате JSON
}
}


    
    


