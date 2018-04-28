<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityStudyGroups */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ScheduleModule.base', 'University Study Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-study-groups-view">

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
            'faculty_id',
            'profile_id',
            'course_id',
            [
                'attribute' => 'space_id',
                'label' => 'Простраство учебной группы',
                'value' => function($item){
                    return \humhub\modules\space\widgets\Image::widget([
                        'space' => $space = \humhub\modules\space\models\Space::findOne($item->space_id),
                        'link' => true,
                        'width' => 24,
                    ]) . PHP_EOL .Html::encode($space->name);
                },
                'format' => 'raw'
            ],
            'name',
            'displayName',
            'en_name',
            'year',
            'desc',
            'color',
        ],
    ]) ?>

</div>
