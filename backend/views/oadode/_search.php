<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OadodeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oadode-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'legal_name') ?>

    <?php // echo $form->field($model, 'business_name') ?>

    <?php // echo $form->field($model, 'business_address') ?>

    <?php // echo $form->field($model, 'business_mailing_address') ?>

    <?php // echo $form->field($model, 'business_phone') ?>

    <?php // echo $form->field($model, 'business_fax') ?>

    <?php // echo $form->field($model, 'business_email') ?>

    <?php // echo $form->field($model, 'application_type') ?>

    <?php // echo $form->field($model, 'business_title') ?>

    <?php // echo $form->field($model, 'lang') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
