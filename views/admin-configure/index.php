<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="panel panel-default">

    <div class="panel-heading"><?= '<strong>Конфигурация</strong> модуля расписания'; ?></div>

    <div class="panel-body">
        
        <?php $form = ActiveForm::begin(['id' => 'configure-form']); ?>

     	<div class="form-group">
            <?= $form->field($model, 'activeDisciplineColor')->widget(\kartik\color\ColorInput::classname(), [
                'options' => ['placeholder' => 'Select color ...'],
            ]);?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'informationLabel')->textInput()->hint('Введите текст')->label('Обязательное текстовое поле'); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
        </div>
    
	<?php ActiveForm::end(); ?>
    </div>
</div>
