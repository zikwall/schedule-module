<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\SchedulePosition */

$this->title = Yii::t('ScheduleModule.base', 'Create ScheduleHelper Position');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'ScheduleHelper Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>