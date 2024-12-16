<?php
namespace app\controllers;

use app\models\Yacht;
use app\models\Trip;
use app\models\User;
use app\models\Request;
use Yii;

class TripController extends FunctionController
{
    
    public function actionSearch()
{
    $city = Yii::$app->request->get('city');
     // Выполняем поиск по товарам
     $trip = Trip::find()->where(['like', 'city', $city])->all() ;
 if (empty($trip)) {
     return $this->send(404, [
         'error' => [
             'code' => 404,
             'message' => 'Нет яхт '
         ]
     ]);
 }
 
 // Формируем ответ
 $result = [];
 foreach ($trip as $trip) {
     $result[] = [
         'id_trip' => $trip->id_trip,
         'yacht_id' => $trip->yacht->name_yacht,
         'date_trip' => $trip->date_trip, // Получаем название типа
         'city' => $trip->city,
         'seat' => $trip->seat,
         
     ];
 }
 
 return $this->send(200, [
     'data' => [
         'trip' => $result
     ]
 ]);
}


public function actionCreate(){
    $user = User::getByToken();
    $post_data=\Yii::$app->request->post();
    if (!($user && $user->isAuthorized() && $user->isAdmin())) {
       return $this->send(403, ['error' => ['message' => 'Доступ запрещен']]);
   }
        $post_data=\Yii::$app->request->post();
        $trip=new Trip();
        $trip->load($post_data, '');
        if (!$trip->validate()) return $this->validation($trip);
         $trip->save(false);
         return $this->send(204, null);
        } 


        public function actionDate()
        {
            $user = User::getByToken();
            
            // Проверка авторизации и прав администратора
            if (!($user && $user->isAuthorized() && $user->isAdmin())) {
                return $this->send(401, [
                    'error' => [
                        'code' => 401,
                        'message' => 'Вы не админ'
                    ]
                ]);
            } else{
        
            // Получаем данные из запроса
            $post_data = Yii::$app->request->post();
        
            // Проверяем наличие необходимых полей
            if (!isset($post_data['id_trip']) || !isset($post_data['date_trip'])) {
                return $this->send(422, [
                    'error' => [
                        'code' => 422,
                        'message' => 'Validation error',
                        'errors' => [
                            'id_trip' => ['Поле "id_trip" обязательно для заполнения.'],
                            'date_trip' => ['Поле "date_trip" обязательно для заполнения.']
                        ]
                    ]
                ]);
            }
        
            // Находим рейс по id_trip
            $trip = Trip::findOne($post_data['id_trip']);
            if (!$trip) {
                return $this->send(404, [
                    'error' => [
                        'code' => 404,
                        'message' => 'Trip not found'
                    ]
                ]);
            }
        
            // Обновляем дату рейса
            $trip->date_trip = $post_data['date_trip'];
        
            // Проверка валидации
            if (!$trip->validate()) {
                return $this->validation($trip);
            }
        
            // Сохраняем изменения
            $trip->save(false);
        
            // Успешный ответ
            return $this->send(200, [
                'date_trip' => [
                    'status' => 'ok'
                ]
            ]);
        }}
        

        public function actionYacht()
        {
            $user = User::getByToken();
            
            // Проверка авторизации и прав администратора
            if (!($user && $user->isAuthorized() && $user->isAdmin())) {
                return $this->send(401, [
                    'error' => [
                        'code' => 401,
                        'message' => 'Вы не админ'
                    ]
                ]);
            }
        
            // Получаем данные из запроса
            $post_data = Yii::$app->request->post();
        
            // Проверяем наличие необходимых полей
            if (!isset($post_data['id_trip']) || !isset($post_data['yacht_id'])) {
                return $this->send(422, [
                    'error' => [
                        'code' => 422,
                        'message' => 'Validation error',
                        'errors' => [
                            'id_trip' => ['Поле "id_trip" обязательно для заполнения.'],
                            'yacht_id' => ['Поле "yacht_id" обязательно для заполнения.']
                        ]
                    ]
                ]);
            }
        
            // Находим рейс по id_trip
            $trip = Trip::findOne($post_data['id_trip']);
            if (!$trip) {
                return $this->send(404, [
                    'error' => [
                        'code' => 404,
                        'message' => 'Trip not found'
                    ]
                ]);
            }
        
            // Обновляем дату рейса
            $trip->yacht_id = $post_data['yacht_id'];
        
            // Проверка валидации
            if (!$trip->validate()) {
                return $this->validation($trip);
            }
        
            // Сохраняем изменения
            $trip->save(false);
        
            // Успешный ответ
            return $this->send(200, [
                'yacht_id' => [
                    'status' => 'ok'
                ]
            ]);
        }
}