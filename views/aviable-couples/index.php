<?php

use yii\helpers\Html;
use humhub\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\schedule\models\search\ScheduleAviableDay */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('ScheduleModule.base', 'ScheduleHelper Aviable Days');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="schedule-aviable-day-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('ScheduleModule.base', 'Create ScheduleHelper Aviable Couple'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'identity',
            'name',
            'displayName',
            'en_name',
            'desc',
            // 'lessonStart',
            // 'lessonEnd',
            [
                'attribute' => 'color',
                'value' => function($item){
                    return '<span class="label" style="background-color:'.$item->color.'!important;">' . $item->color . '</span>';
                },
                'format' => 'html',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php $this->endContent(); ?>