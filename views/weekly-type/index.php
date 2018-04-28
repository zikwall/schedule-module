<?php

use yii\helpers\Html;
use humhub\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\schedule\models\search\ScheduleWeeklyType */
/* @var $dataProvider yii\data\ActiveDataProvider
 * @var \yii\web\View $this
 */
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="schedule-weekly-type-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('UniversityModule.base', 'Create ScheduleHelper Weekly Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'en_name',
            [
                'attribute' => 'color',
                'value' => function($item){
                    return '<span class="label" style="background-color:'.$item->color.'!important;">' . $item->color . '</span>';
                },
                'format' => 'html',
            ],
            'sign',

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