<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\RoomSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['style' => 'max-width: 42%'],
    ]); ?>

    <?= $form->field($model, 'start_time')->widget(DateTimePicker::classname(), [
        'readonly' => true,
        'options' => [
            'placeholder' => '选择开始时间',
            'autocomplete' => 'off',
        ],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'end_time')->widget(DateTimePicker::classname(), [
        'readonly' => true,
        'options' => [
            'placeholder' => '选择结束时间',
            'autocomplete' => 'off',
        ],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('查看可用房间', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('重置搜索条件', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>