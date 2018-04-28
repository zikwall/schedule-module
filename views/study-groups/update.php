<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityStudyGroups */

$this->title = Yii::t('ScheduleModule.base', 'Update {modelClass}: ', [
    'modelClass' => 'University Study Groups',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'University Study Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('ScheduleModule.base', 'Update');
?>
<div class="university-study-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
