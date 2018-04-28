<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleSchedule */

$this->title = Yii::t('ScheduleModule.base', 'Create ScheduleHelper ScheduleHelper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'ScheduleHelper Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'faculty' => $faculty,
        'course' => $course
    ]) ?>

</div>