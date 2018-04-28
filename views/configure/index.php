<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\forms\UserConfigureForm */
/* @var $form ActiveForm */
?>

<div class="panel">
    <div class="panel-heading">
        <strong>Настройки</strong> пользователя (пример)
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= $form->field($model, 'userStudyGroup')->dropDownList((new \humhub\modules\schedule\models\ScheduleSchedule())->getStudyGroupList(1, 4), ['id' => 'group-id', 'data-ui-select2' => '']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>