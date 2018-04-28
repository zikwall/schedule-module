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
            <strong>Добавление занятия</strong>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <?= $this->render('_formAdvanced', [
                'model' => $model,
                'faculty' => $faculty,
                'course' => $course,
                'day' => $day,
                'couple' => $couple,
                'group' => $group
            ]); ?>
        </div>
    </div>
</div>
