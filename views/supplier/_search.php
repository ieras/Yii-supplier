<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => false
        ],
    ]); ?>

    <?= $form->field($model, 'id[symbol]')->dropdownList(
            ['>' => '>','>=' => '>=', '='=>'=','<' => '<','<=' => '<='],
            ['prompt'=>'Select Symbol']);
    ?>
    <?= $form->field($model, 'id[value]') ?>
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 't_status')->dropdownList(['ok' => 'OK','hold' => 'Hold'],['prompt'=>'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary','name'=>'export','value'=>0,]) ?>
        <?= Html::submitButton('导出条件数据', ['class' => 'btn btn-success all_export','name'=>'export','value'=>1,'target' => '_blank',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
