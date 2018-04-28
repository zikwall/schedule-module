<?php

use yii\helpers\Html;
use humhub\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\university\models\search\UniversityStudyGroups */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('ScheduleModule.base', 'University Study Groups');
?>
<div class="university-study-groups-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('ScheduleModule.base', 'Create University Study Groups'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'faculty.fullname',
                'options' => ['width' => '200'],
                'filter' => Html::activeDropDownList($searchModel, 'faculty_id', \humhub\modules\faculties\models\UniversityFaculties::getList(), ['class'=>'form-control','prompt' => 'Факультет']),
            ],
            [
                'attribute' => 'profile.name',
                'options' => ['width' => '200'],
                'filter' => Html::activeDropDownList($searchModel, 'profile_id', \humhub\modules\specialities\models\UniversitySpecialitiesProfiles::getList(), ['class'=>'form-control','prompt' => 'Профиль']),
            ],
            [
                'attribute' => 'course.name',
                'options' => ['width' => '200'],
                'filter' => Html::activeDropDownList($searchModel, 'course_id', \humhub\modules\university\models\UniversityStudyCourses::getList(), ['class'=>'form-control','prompt' => 'Курс']),
            ],
            'displayName',

            // 'en_name',
            // 'year',
            // 'desc',
            [
                'attribute' => 'color',
                'value' => function($item){
                    return '<span class="label" style="background-color:'.$item->color.'!important;">' . $item->color . '</span>';
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
