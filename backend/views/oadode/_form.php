<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Oadode;

$this->registerCssFile('@web/css/custom.css');

/* @var $this yii\web\View */
/* @var $model common\models\Oadode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oadode-form">

    <?php $form = ActiveForm::begin([
        'id' => 'oadode-registration-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]); ?>
    	
	<div class="row">
		<div class="col-lg-12">
			<?= $form->errorSummary($model); ?>
        </div>
    </div>
    
    <div class="row">
    	<div class="col-lg-12">
    		<h4>A. BUSINESS INFORMATION (To be completed by the Designated Official</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span>1</span>
        		</div>
        		<div class="col-lg-11 list-field">
        			<?= $form->field($model, 'legal_name', [
        			    'template' => '{label}<br>{input}'
        			])->textInput(['maxlength' => true]) ?>
        		</div>
    		</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span>2</span>
        		</div>
        		<div class="col-lg-11 list-field">
        			<?= $form->field($model, 'business_name', [
        			    'template' => '{label}<br>{input}'
        			])->textInput(['maxlength' => true])->label('Business Name (If different from Legal Name)') ?>
        		</div>
    		</div>
    	</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span>3</span>
        		</div>
        		<div class="col-lg-11 list-field">
        			<?= $form->field($model, 'business_address', [
        			    'template' => '{label}<br>{input}'
        			])->textInput(['maxlength' => true]) ?>
        		</div>
    		</div>
		</div>
	</div>
	<div class="row">	
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span>4</span>
        		</div>
        		<div class="col-lg-11 list-field">
        			<?= $form->field($model, 'business_mailing_address', [
        			    'template' => '{label}<br>{input}'
        			])->textInput(['maxlength' => true])->label('Mailing Address (If different from Civic Address)') ?>
        		</div>
    		</div>
		</div>
	</div>
	<div class="row">		
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span>5</span>
        		</div>
        		<div class="col-lg-5 list-field">
        			<?= $form->field($model, 'business_phone', [
        			    'template' => '{label}<br>{input}'
        			])->textInput(['maxlength' => true])->label('Telephone Number (Include extension no. if applicable)') ?>
        		</div>
        		<div class="col-lg-1 list-number">
        			<span>6</span>
        		</div>
        		<div class="col-lg-5 list-field">
        			<?= $form->field($model, 'business_fax', [
        			    'template' => '{label}<br>{input}'
        			])->textInput(['maxlength' => true]) ?>
        		</div>
        	</div>
    	</div>
	</div>
	<div class="row">		
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span>7</span>
        		</div>
        		<div class="col-lg-11 list-field">
        			<?= $form->field($model, 'business_email', [
        			    'template' => '{label}<br>{input}'
        			])->textInput(['maxlength' => true]) ?>
        		</div>
        	</div>
    	</div>
	</div>
	<div class="row">	
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span>8</span>
        		</div>
        		<div class="col-lg-11 list-field">
        			<span>Description of the controlled goods the applicant may required to examine, process or transfer (Refer to the Export Control List (ECL))</span>
        		</div>
    		</div>
    	</div>
	</div>
    <div class="row mt-5">    
		<div class="col-lg-12">
    		<div class="col-lg-6 list-field goods-title">
    			<span>Description of Controlled Goods</span>
    		</div>
    		<div class="col-lg-3 list-field goods-title">
    			<span>ECL Group No.</span>
    		</div>
    		<div class="col-lg-3 list-field goods-title">
    			<span>ECL Item No.</span>
    		</div>
    	</div>
	</div>
	<?php $i = 0; if ($goods != null): ?>
	<?php foreach ($goods as $row): $label = ''?>
	<?php switch ($i): 
            case 1: $label = 'a'; break;
            case 2: $label = 'b'; break;
            case 3: $label = 'c'; break;
            case 4: $label = 'd'; break;
            default: $label = 'e'; 
    endswitch ?>
	<div class="row">
		<div class="col-lg-12">
        	<div class="form-list">
        		<div class="col-lg-1 list-number">
        			<span><?= $label; ?></span>
        		</div>
        		<div class="col-lg-5 list-field">
        			<?= $form->field($row, '['.$i.']description', [
        			    'template' => '{input}{error}'
        			])->textInput(['maxlength' => true]) ?>
        		</div>
        		<div class="col-lg-3 list-field">
        			<?= $form->field($row, '['.$i.']ecl_group', [
        			    'template' => '{input}{error}'
        			])->textInput(['maxlength' => true]) ?>
        		</div>
        		<div class="col-lg-3 list-field">
        			<?= $form->field($row, '['.$i.']ecl_item', [
        			    'template' => '{input}{error}'
        			])->textInput(['maxlength' => true]) ?>
        		</div>
        	</div>
        </div>
	</div>
	<?php $i++; endforeach; ?>
	<?php endif; ?>
    
    <div class="row">
    	<div class="col-lg-12">
    		<h4>B. APPLICANT INFORMATION (To be completed by the Applicant)</h4>
    	</div>
    </div>
	<div class="row">
		<div class="col-lg-12">
        	<div class="form-list">
    			<div class="col-lg-1 list-number">
    				<span>9</span>
    			</div>
    			<div class="col-lg-11 list-field">
    				<?= $form->field($model, 'application_type', [
    				    'template' => '{label}{input}'
    				])->radioList(Oadode::getAllApplicationType()) ?>
    			</div>
    		</div>
    	</div>
    </div>

	<div class="row">
		<div class="col-lg-12">
        	<div class="form-list">
    			<div class="col-lg-1 list-number">
    				<span>10</span>
    			</div>
    			<div class="col-lg-11 list-field">
    				<?= $form->field($model, 'business_title', [
    				    'template' => '{label}{input}'
    				])->checkboxList(Oadode::getAllBusinessTitle())->label('Business Title (Select all that apply)') ?>
    			</div>
    		</div>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-12">
        	<div class="form-list">
    			<div class="col-lg-1 list-number">
    				<span>11</span>
    			</div>
    			<div class="col-lg-11 list-field">
    				<?= $form->field($model, 'lang', [
    				    'template' => '{label}{input}'
    				])->radioList(Oadode::getAllLanguage()) ?>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>