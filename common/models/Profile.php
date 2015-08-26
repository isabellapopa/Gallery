<?php
namespace common\models;

use Yii;

use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }
    public function rules()
    {
        return [
            [['lastName', 'firstName', 'phone', 'profilePicture', 'address'], 'string'],
            [['skypeId','userId'], 'integer'],
            [['firstName'], 'string', 'max' => 50],
            [['lastName'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 10]
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'Profile ID',
            'userId' => 'User ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'username' => 'Username',
            'phone' => 'Phone',
            'address' => 'Address',
        ];
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

}
