<?php

use yii\helpers\Html;
use humhub\widgets\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\schedule\models\search\ScheduleAviableDay */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \yii\web\View $this */
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="schedule-aviable-day-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('ScheduleModule.base', 'Create ScheduleHelper Aviable Day'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'identity',
            'name',
            'en_name',
            [
                'attribute' => 'desc',
                'value' => function($item){
                    return \humhub\widgets\MarkdownView::widget(['markdown' => $item->desc]);
                },
                'format' => 'raw'
            ],

            [
                'header' => Yii::t('AdminModule.views_user_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width:80px; min-width:80px;'],
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                    },
                    'update' => function($url, $model) {
                        return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['update', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<i class="fa fa-times"></i>', Url::toRoute(['delete', 'id' => $model->id]), ['class' => 'btn btn-danger btn-xs tt']);
                    }
                ],
            ],
        ],
    ]); ?>
</div>

<?php $this->endContent(); ?>