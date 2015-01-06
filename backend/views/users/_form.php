<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'username') ?>

    <?php if(Yii::$app->user->identity->type=='admin'){?>
        <?= $form->field($model, 'partner_id')->dropDownList(ArrayHelper::merge([0=>Yii::t('app','Select Partner')],ArrayHelper::map($model->partners,'id','username'))) ?>
    <?php } ?>

    <?php if($model->isNewRecord){?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    <?php } ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'type')->dropDownList($model->types) ?>

    <?= $form->field($model, 'status')->radioList($model->statusOptions) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
