<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'max' => 255],
            ['password_hash', 'string', 'max' => 255],
        ];
    }

    public static function findByUsername($username)
    {
        $filename = Yii::getAlias('@app') . '/runtime/users.txt';
        $users = file($filename, FILE_IGNORE_NEW_LINES);

        foreach ($users as $user) {
            list($storedUsername, $email, $storedPassword) = explode(", ", $user);

            $storedUsername = str_replace("Username: ", "", $storedUsername);
            $storedPassword = str_replace("Password: ", "", $storedPassword);

            if ($storedUsername === $username) {
                $userModel = new static();
                $userModel->username = $storedUsername;
                $userModel->password_hash = $storedPassword;
                return $userModel;
            }
        }

        return null;
    }

    public function validatePassword($inputPassword)
    {
        return Yii::$app->getSecurity()->validatePassword($inputPassword, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // token-based auth
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}
