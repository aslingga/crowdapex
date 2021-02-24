<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Oadode;

/* @var $this yii\web\View */
/* @var $model common\models\Oadode */

$this->title = $model->business_name;
\yii\web\YiiAsset::register($this);
?>
<div class="oadode-view d-print-flex">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'application_id',
            [
                'label' => 'User',
                'value' => $model->user->email
            ],
            'legal_name',
            'business_name',
            'business_address',
            'business_mailing_address',
            'business_phone',
            'business_fax',
            'business_email:email',
            [
                'label' => 'Type of Application',
                'value' => Oadode::getAllApplicationType()[$model->application_type]
            ],
            'business_title',
            [
                'label' => 'Preffered Languge of Correspondence',
                'value' => Oadode::getAllLanguage()[$model->lang]
            ]
        ],
    ]) ?>
</div>

<?php foreach ($goods as $good): ?>
    <?= DetailView::widget([
        'model' => $good,
        'attributes' => [
            'application_id',
            'description',
            'ecl_group',
            'ecl_item'
        ],
    ]) ?>
<?php endforeach; ?>