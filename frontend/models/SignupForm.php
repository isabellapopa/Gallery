<?php
namespace frontend\models;

use common\models\User;
use common\models\Profile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $firstName;
    public $lastName;
    public $phone;
    public $address;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['firstName', 'filter', 'filter' => 'trim'],
            ['firstName', 'required'],
            ['firstName', 'unique', 'targetClass' => '\common\models\Profile', 'message' => 'This name has already been taken.'],
            ['firstName', 'string', 'min' => 2, 'max' => 255],


            ['lastName', 'filter', 'filter' => 'trim'],
            ['lastName', 'required'],
            ['lastName', 'unique', 'targetClass' => '\common\models\Profile', 'message' => 'This name has already been taken.'],
            ['lastName', 'string', 'min' => 2, 'max' => 255],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],




            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],


            ['phone' , 'required'],
            ['phone' , 'string', 'max' => 10],


            ['address', 'filter', 'filter' => 'trim'],
            ['address', 'required'],


        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user= new User();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $profile = new Profile();
                $profile->firstName = $this->firstName;
                $profile->lastName = $this->lastName;
                $profile->userId = $user->id;
                $profile->address = $this->address;
                $profile->phone = $this->phone;
                if($profile->save()){
                    return $user;
                }
            }
        }

        return null;
    }
}
