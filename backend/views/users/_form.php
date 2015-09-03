<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form yii\bootstrap\ActiveForm */

$dataCustomers = ArrayHelper::map(Profile::find()->asArray()->all(),'firstName','lastName');
$dataUser = ArrayHelper::map(User::find()->asArray()->all(),'id','username');
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

    <?= $form->field($model, 'userId',[
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-2',
        ]]) ?>

    <?= $form->field($model, 'firstName',[
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-2',
        ]]) ?>

    <?= $form->field($model, 'lastName',[
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-2',
        ]]) ?>

    <?= $form->field($model, 'phone',[
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-2',
        ]]) ?>

    <?= $form->field($model, 'address',[
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-2',
        ]]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
