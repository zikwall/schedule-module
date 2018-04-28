<?php

use yii\helpers\Html;
use humhub\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\university\models\search\UniversityTeachers */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="university-teachers-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('UniversityModule.base', 'Create University Teachers'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'post.name',
            'science.name',
            'chair.name',

            [
                'header' => Yii::t('AdminModule.views_user_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width:80px; min-width:80px;'],
                'template' => '{view} {update} {delete} {link}',
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                    },
                    'update' => function($url, $model) {
                        return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['update', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<i class="fa fa-times"></i>', Url::toRoute(['delete', 'id' => $model->id]), ['class' => 'btn btn-danger btn-xs tt']);
                    },
                    'link' => function($url, $model) {
                        return Html::a('<i class="fa fa-link"></i>', Url::toRoute(['link', 'id' => $model->id]), ['class' => 'btn btn-warning btn-xs tt']);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
