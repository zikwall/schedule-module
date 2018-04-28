<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleSchedule */

$studyGroup = $model->studyGroup;
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayoutForSchedule.php', [
        'faculty' => $studyGroup->faculty->id,
        'course' => $studyGroup->course->id
]) ?>

<div class="panel">
    <div class="panel-body">
        <strong>Редактирование</strong> расписания: <span class="label label-info"><?= $studyGroup->faculty->fullname; ?></span> <span class="label label-info"><?= $model->day->name; ?></span> <span class="label label-info"><?= $model->couple->displayName; ?></span> <span class="label label-default"><i>(<?= $model->couple->getDisplayTime(); ?>)</i></span>
    </div>
</div>

<div class="schedule-schedule-update">

    <?= $this->render('_form', [
        'model' => $model,
        'course' => $studyGroup->course,
        'faculty' => $studyGroup->faculty
    ]) ?>

</div>

<?php $this->endContent(); ?>