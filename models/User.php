<?php

namespace app\models;
use yii\web\IdentityInterface;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id_user
 * @property string $login
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $role
 * @property string|null $token
 * @property string $passport
 *
 * @property Request[] $requests
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'full_name', 'email', 'phone', 'password', 'passport'], 'required'],
            ['username', 'match', 'pattern' => '/^[a-z]+$/iu', 'message'=>'Только латиница'],
            ['email', 'match', 'pattern' => '/^[\w\d_.+-]+@[\w\d-]+.[\w]+$/', 'message'=>'Формат: info@domain.com'],
            [['role'], 'string'],
            [['username', 'full_name', 'email', 'phone', 'password', 'token'], 'string', 'max' => 255],
            [['passport'], 'string', 'max' => 10],
            [['username'], 'unique'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'username' => 'Login',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'role' => 'Role',
            'token' => 'Token',
            'passport' => 'Passport',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['user_id' => 'id_user']);
    }
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function isAdmin() {
        $user = $this::getByToken();
        return boolval($user->role=="Admin");
    }

    public function isAuthorized() {
        $token = str_replace('Bearer ', '', Yii::$app->request->headers->get('Authorization'));
        if (!$token || $token != $this->token) {
            return false;
        }
        return true;
    }
    public static function getByToken() {
        return self::findOne(['token' => str_replace('Bearer ', '', Yii::$app->request->headers->get('Authorization'))]);
    }
}

