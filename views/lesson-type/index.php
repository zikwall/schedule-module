<?php

use yii\helpers\Html;
use humhub\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\schedule\models\search\ScheduleLessonType */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('UniversityModule.base', 'ScheduleHelper Lesson Types');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="schedule-lesson-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('UniversityModule.base', 'Create ScheduleHelper Lesson Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'en_name',
            'desc',
            [
                'attribute' => 'color',
                'value' => function($item){
                    return '<span class="label" style="background-color:'.$item->color.'!important;">' . $item->sign . '</span>';
                },
                'format' => 'html',
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