<?php
/**
 * @var \yii\web\View $this
 *
 * @var \humhub\modules\schedule\models\ScheduleSchedule $model
 */
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <strong>Редактирование</strong> <?= $model->day->name; ?> - <?= $model->couple->displayName; ?>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <?= $this->render('_formAdvanced', [
                    'model' => $model,
                    'faculty' => $model->studyGroup->faculty,
                    'course' => $model->studyGroup->course
            ]); ?>
        </div>
    </div>
</div>
