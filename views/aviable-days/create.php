<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleAviableDay */

$this->title = Yii::t('ScheduleModule.base', 'Create ScheduleHelper Aviable Day');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'ScheduleHelper Aviable Days'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

    <div class="schedule-aviable-day-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

<?php $this->endContent(); ?>