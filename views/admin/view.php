<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleSchedule */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'ScheduleHelper Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-schedule-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('ScheduleModule.base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('ScheduleModule.base', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('ScheduleModule.base', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'day_id',
            'couple_id',
            'teacher_id',
            'discipline_id',
            'study_group_id',
            'weekly_type_id',
            'classroom_id',
            'type_id',
            'en_name',
            'desc',
        ],
    ]) ?>

</div>