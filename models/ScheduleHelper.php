<?php

namespace humhub\modules\schedule\models;

use humhub\modules\questionanswer\helpers\Url;
use humhub\modules\space\models\Space;
use humhub\modules\specialities\permissions\ManageEducationProfiles;
use humhub\modules\university\permissions\ManageStudyGroups;
use Yii;
use humhub\components\ActiveRecord;
use yii\bootstrap\Html;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use humhub\modules\university\models\UniversityStudyGroups;

class ScheduleHelper
{
    public function __construct(array $config = [])
    {
        $this->request = Yii::$app->request;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return [
            [
                'id' => 100,
                'name' => 'level1',
                'field_name' => 'РАСПИСАНИЕ УЧЕБНЫХ ЗАНЯТИЙ',
                'internal_key' => 0
            ],
            [
                'id' => 101,
                'name' => 'level2',
                'field_name' => 'ЭКОНОМИЧЕСКОГО ФАКУЛЬТЕТА ОЧНОЙ ФОРМЫ ОБУЧЕНИЯ',
                'internal_key' => 100
            ],
            [
                'id' => 102,
                'name' => 'level3',
                'field_name' => 'на 1 полугодие 2017-2018 учебного года ',
                'internal_key' => 101
            ],
        ];
    }

    public function getAviableCoupleHead($parent, ScheduleAviableCouple $couple)
    {
        $randomizeId = rand(99999999, 999999999) + $couple->id;

        $headers = [
            'id' => $randomizeId,
            'internal_key' => $parent,
            'name' => $parent,
            'field_name' => Helper::b($couple->displayName),
            'sort_order' => $couple->id,
        ];

        return $headers;
    }

    public function getDayActions(ScheduleAviableDay $day)
    {
        $couples = [
            'id' => rand(999999, 9999999),
            'internal_key' => $day->id,
            'name' => 'action_'.$day->name,
            'field_name' => '<input checked="checked" type="checkbox">',
            'sort_order' => $day->id,
            'identityDayKey' => $day->identity,
        ];

        return $couples;

    }

    /**
     * @param $parent
     * @param $parentDayIdentity
     * @param ScheduleAviableCouple $couple
     * @return array
     */
    public function getAviableCouple($parent, $parentDayIdentity, ScheduleAviableCouple $couple)
    {
        $couples = [
            'id' => rand(999999, 99999999),
            'internal_key' => $parent,
            'name' => $couple->name,
            'field_name' => '<h5><small>'.$couple->displayName.'</small></h5><br><b>' . $couple->getDisplayTime() . '</b>',
            'sort_order' => $couple->id,
            'heading' => 1,
            'identityDayToCoupleKey' => $parentDayIdentity,
            'identityCoupleKey' => $couple->identity,
        ];

        return $couples;

    }

    public function getAviableStaticCouple(ScheduleAviableCouple $couple)
    {
        $couples = [
            'id' => rand(999999, 9999999),
            'internal_key' => 0,
            'name' => $couple->name,
            'field_name' => '<h5><small>'.$couple->displayName.'</small></h5><br><b>'  . $couple->getDisplayTime() . '</b>',
            'sort_order' => $couple->id,
            'heading' => 1,
            'identityCoupleKey' => $couple->identity,
        ];

        return $couples;

    }

    public function getAviableStaticFlatCouple(ScheduleAviableCouple $couple, $counter)
    {
        $couples = [
            'id' => rand(999999, 9999999),
            'internal_key' => 0,
            'name' => $couple->name.'_'.$counter,
            'field_name' => '<div class="panel-heading" style=""><h5>'.'<h5><small>'.$couple->displayName.'</small></h5><hr>' . $couple->getDisplayTime() . '</h5></div>',
            'sort_order' => $couple->id,
            'heading' => 1,
            'identityCoupleKey' => $couple->identity,
        ];

        return $couples;

    }

    /**
     * @param $parent
     * @param UniversityStudyGroups $group
     * @return array
     */
    public function getAviableGroup($parent, UniversityStudyGroups $group)
    {
        $course = $this->request->getQueryParam('course');

        $ul = '<ul class="nav">
                    <li class="dropdown">';

        $ulEnd = '<ul class="dropdown-menu pull-right">
                      <li>';

        $ulEnd .= Html::a('<i class="fa fa-calendar"></i> Расписание для ' . $group->displayName, [

            Url::to([
                '/schedule/public/global',
                'faculty' => $this->request->getQueryParam('faculty'),
                'course' => isset($course) ? $course : 1,
                'group' => $group->id
            ]),

        ], ['class' => 'panel-collapse',]);

        $ulEnd .= '</li>';


        if(!empty($group->space_id)){
            $ulEnd .= '<li>';
            $space = Space::findOne($group->space_id);

            $ulEnd .= Html::a('<i class="fa fa-users"></i> Простраство группы', $space->createUrl(), [
                'class' => 'panel-collapse'
            ]);

            $ulEnd .= '</li>';
        }

        $ulEnd .= '<li>';

        $ulEnd .= Html::a('<i class="fa fa-info-circle"></i> Информация', Url::to(['/schedule/public/group-information', 'id' => $group->id]), [
            'class' => 'panel-collapse',
            'data-target' => '#globalModal',
        ]);

        $ulEnd .= '</li>';

        if(Yii::$app->user->can(new ManageStudyGroups())){
            $ulEnd .= '<li class="divider">';
            $ulEnd .= '<li>';

            $ulEnd .= Html::a('<i class="fa fa-pencil"></i> Редактировать группу', Url::to(['/schedule/study-groups/update', 'id' => $group->id]), [
                'class' => 'panel-collapse'
            ]);

            $ulEnd .= '</li>';
        }

        $ulEnd .= '</ul>
                </li>
            </ul>';

        $couples = [
            'id' => $group->id,
            'internal_key' => $parent,
            'name' => $group->name,
            'field_name' => $ul. Html::a(Html::tag('span', $group->displayName, [
                    'class' => 'label label-info',
                    'style' => 'background-color:'.$group->color.'!important;',
                ]), [
                    '#',
                ], [
                    'class' => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                    'aria-label' => 'Toggle panel menu',
                    'aria-haspopup' => 'true',
                    'aria-expanded' => 'false'
                ]). $ulEnd,
            'sort_order' => $group->id,
        ];

        return $couples;
    }

    /**
     * @param $parent
     * @param UniversityStudyGroups $group
     * @return array
     */
    public function getAviableGroupsHead($parent, UniversityStudyGroups $group)
    {
        $course = $this->request->getQueryParam('course');

        $randomizeId = rand(9999999, 99999999) + $group->id;

        $ul = '<ul class="nav">
                    <li class="dropdown">';

        $ulEnd = '<ul class="dropdown-menu pull-right">
                      <li>';

        $ulEnd .= Html::a('<i class="fa fa-arrow-right"></i> Расписание для ' . $group->profile->name, [

            Url::to([
                '/schedule/public/global',
                'faculty' => $this->request->getQueryParam('faculty'),
                'course' => isset($course) ? $course : 1,
                'profile' => $group->profile->id
            ]),

        ], ['class' => 'panel-collapse',]);

        $ulEnd .= '</li>';
        $ulEnd .= '<li>';

        $ulEnd .= Html::a('<i class="fa fa-info-circle"></i> Информация', Url::to(['/specialities/public-profiles/information', 'id' => $group->profile->id]), [
            'class' => 'panel-collapse',
            'data-target' => '#globalModal',
        ]);

        $ulEnd .= '</li>';

        if(Yii::$app->user->can(new ManageEducationProfiles())){
            $ulEnd .= '<li class="divider">';
            $ulEnd .= '<li>';

            $ulEnd .= Html::a('<i class="fa fa-pencil"></i> Редактировать профиль', Url::to(['/specialities/profiles/update', 'id' => $group->profile->id]), [
                'class' => 'panel-collapse'
            ]);

            $ulEnd .= '</li>';
        }

        $ulEnd .= '</ul>
                </li>
            </ul>';

        $headers = [
            'id' => $randomizeId,
            'internal_key' => $parent,
            'name' => $group->profile->name,
            'field_name' => $ul. Html::a(Html::tag('span', $group->profile->shortname, [
                'class' => 'label label-primary',
                'style' => 'background-color:'.$group->profile->color.'!important;',
            ]), [
                '#',
            ], [
                    'class' => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                    'aria-label' => 'Toggle panel menu',
                    'aria-haspopup' => 'true',
                    'aria-expanded' => 'false'
                ]). $ulEnd,
            'sort_order' => $group->id,
        ];

        return $headers;
    }

    /**
     * @param $day
     * @param $couple
     * @param $group
     * @return int|string
     */
    public function countDailyDisciplines($day, $couple, $group)
    {
        return ScheduleSchedule::find()->where(['day_id' => $day])->andWhere(['couple_id' => $couple])
            ->andWhere(['study_group_id' => $group])->count();
    }

    public static $weekly = 0;
    public static $disciplines = null;
    public static $teachers = null;
    public static $types = null;
    public static $classrooms = null;
    public static $profiles = null;

    /**
     * @param $day
     * @param $couple
     * @param $group
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getDailyDisciplines($day, $couple, $group)
    {
        $query = ScheduleSchedule::find()->full()
            ->where(['and',
                ['=', 'day_id', $day],
                ['=', 'couple_id', $couple],
                ['=', 'study_group_id', $group]
            ]);

        if(static::$weekly > 0){
            $query->andWhere(['in', 'weekly_type_id', static::$weekly]);
        }

        if(is_array(static::$disciplines)){
            $query->andWhere(['in', 'discipline_id', static::$disciplines]);
        }

        if(is_array(static::$teachers)){
            $query->andWhere(['in', 'teacher_id', static::$teachers]);
        }

        if(is_array(static::$types)){
            $query->andWhere(['in', 'type_id', static::$types]);
        }

        if(is_array(static::$classrooms)){
            $query->andWhere(['in', 'classroom_id', static::$classrooms]);
        }

        if(is_array(static::$profiles)){
            $query->leftJoin(UniversityStudyGroups::tableName().' sg', 'sg.id = study_group_id')
                ->andWhere(['in', 'sg.profile_id', static::$profiles]);
        }

        return $query->all();
    }

    /**
     * @param null $date
     * @return int
     */
    public static function getWeeklyType($date = null)
    {
        $week = date('W');
        return $week % 2 === 0 ? 1 : 2;
    }
}