<?php
namespace app\controllers;
use app\models\Yacht;
use Yii;
class YachtController extends FunctionController
{
 public $modelClass = 'app\models\Yacht';
 
    public function actionView() {
        $yachts = Yacht::find()->all();
        
        if (empty($yachts)) {
            return $this->send(404, [
                'error' => [
                    'code' => 404,
                    'message' => 'yachts not found'
                ]
            ]);
        }
        $yachtList = [];
        foreach ($yachts as $yacht) {
            $yachtList[] = [
                'id' => $yacht->id_yacht,
                'name' => $yacht->name_yacht,
                'max_human' => $yacht->max_human,
                'price' => $yacht->price,
                'avatar' => $yacht->avatar, // Предполагается, что это URL или относительный путь
            ];
        }
    
        // Возврат успешного ответа с данными о продуктах
        return $this->send(200, [
            'data' => [
                'yacht' => $yachtList
            ]
        ]);
    }

    public function actionDelete($id_yacht){
        $user = User::getByToken();
        $yacht = Courses::findOne($id_course);
        if (!($user && $user->isAuthorized() && $user->isAdmin())) {
            return $this->send(403, ['error' => ['message' => 'Доступ запрещен']]);
        }
             if(!empty($course -> id_course)){
             $course -> delete();
             return $this->send(200,null);
             }
             else{
                 return $this->send(404,['error'=>['code'=>404, 'message'=>'Not found', 'errors'=>['Курс не найден']]]);
             }
             }
}