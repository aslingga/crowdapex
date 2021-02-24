<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Oadode */

$this->title = Yii::t('app', 'Create Oadode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oadodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oadode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'goods' => $goods,
    ]) ?>

</div>
