<?php

use Yii;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Profile;

$cardName[] = ['visa','maestro','mastercard'];

?>


<div class="container">
    <h1>Premium Account</h1>
    <p>Username: <?php echo Yii::$app->user->identity->username ?> </p>
    <p>Email:  <?php echo Yii::$app->user->identity->email  ?> </p>
    <div class="premium-cont">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

<?= $form->field($model, 'cardName',[
    'horizontalCssClasses' => [
        'wrapper' => 'col-sm-2',
    ]])->dropDownList($cardName,
    ['prompt'=>'----------Choose a Name----------']) ?>

<?= $form->field($model, 'activeAccount',[
    'horizontalCssClasses' => [
        'wrapper' => 'col-sm-2',
    ]]) ?>
        <div class="form-group">
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

