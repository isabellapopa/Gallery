<?php
namespace common\models;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Upload extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $userId;
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $user=User::find()->where(['id'=> $this->userId])->one();
            if($user) {
                $user->photoName = $this->imageFile->baseName . '.' . $this->imageFile->extension;
                if($user->save()) {
                    $this->imageFile->saveAs(Yii::$app->params['uploadPoze'].'/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
                    return true;
                }
                return false;
            }
            return false;
        } else {
            return false;
        }
    }
}