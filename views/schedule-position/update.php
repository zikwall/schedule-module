<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\SchedulePosition */

$this->title = Yii::t('ScheduleModule.base', 'Update {modelClass}: ', [
        'modelClass' => 'ScheduleHelper Position',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'ScheduleHelper Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('ScheduleModule.base', 'Update');
?>
<div class="schedule-position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>