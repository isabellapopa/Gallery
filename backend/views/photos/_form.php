<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Photo;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Photo */
/* @var $form yii\bootstrap\ActiveForm */

$dataCustomers = ArrayHelper::map(Photo::find()->asArray()->all(),'name','description');
$dataUser = ArrayHelper::map(User::find()->asArray()->all(),'id','username');
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>


    <?= $form->field($model, 'photoName',[
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-2',
        ]]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
