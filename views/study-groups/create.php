<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityStudyGroups */

$this->title = Yii::t('ScheduleModule.base', 'Create University Study Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'University Study Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-study-groups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
