<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Oadode;

/* @var $this yii\web\View */
/* @var $model common\models\Oadode */

$this->title = $model->business_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oadodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

echo $this->render('_view', [
    'model' => $model,
    'goods' => $goods
]);
?>
<p>
    <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Print'), ['report', 'id' => $model->id], [
        'class' => 'btn btn-warning',
        'id' => 'print'
    ]) ?>
</p>
