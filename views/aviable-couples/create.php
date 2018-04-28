<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleAviableCouple */

$this->title = Yii::t('ScheduleModule.base', 'Create ScheduleHelper Aviable Couple');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'ScheduleHelper Aviable Couples'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

    <div class="schedule-aviable-couple-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

<?php $this->endContent(); ?>