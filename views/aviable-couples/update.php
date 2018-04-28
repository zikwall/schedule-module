<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleAviableCouple */

$this->title = Yii::t('ScheduleModule.base', 'Update {modelClass}: ', [
        'modelClass' => 'ScheduleHelper Aviable Couple',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'ScheduleHelper Aviable Couples'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('ScheduleModule.base', 'Update');
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

    <div class="schedule-aviable-couple-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

<?php $this->endContent(); ?>