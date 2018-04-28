<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \humhub\modules\schedule\models\ScheduleSchedule $model
 */
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <strong>Добавление задач для</strong>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'errorOptions' => [
                        'encode' => false,
                        'class' => 'help-block'
                    ],
                ]
            ]); ?>
            <div class="form-group">
                <?= $form->field($model, 'formIssuees')->dropDownList($model->getIssuesList(), ['id' => 'issues-id', 'data-ui-select2' => '', 'multiple' => true]) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('ScheduleModule.base', 'Create') : Yii::t('ScheduleModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-ui-loader'=>'']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>