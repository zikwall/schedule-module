<?php

namespace humhub\modules\schedule\models\query;

use humhub\modules\schedule\models\ScheduleSchedule;
use humhub\modules\university\models\UniversityStudyGroups;
use yii\db\ActiveQuery;

class ScheduleActiveQuery extends ActiveQuery
{
    public function full()
    {
        /*$this->leftJoin('schedule_aviable_day sad', 'schedule_schedule.day_id = sad.id')
            ->leftJoin('schedule_aviable_couple sac', 'schedule_schedule.couple_id = sac.id')
            ->leftJoin('university_discipline ud', 'schedule_schedule.discipline_id = ud.id')
            ->leftJoin('university_building_classroom ubc', 'schedule_schedule.classroom_id = ubc.id')
            ->leftJoin('university_teachers ut', 'schedule_schedule.teacher_id = ut.id')
            ->leftJoin('user', 'ut.user_id = user.id')
            ->leftJoin('schedule_weekly_type swt', 'schedule_schedule.weekly_type_id = swt.id')
            ->leftJoin('university_study_groups usg', 'schedule_schedule.study_group_id = usg.id')
            ->leftJoin('schedule_lesson_type slt', 'schedule_schedule.type_id = slt.id');*/

        return $this->with([
            'day', 'couple', 'discipline', 'classroom', 'teacher', 'teacher.user', 'weeklyType', 'studyGroup', 'type',
            'scheduleLinkSubgroups', 'scheduleLinkIssues'
        ]);
    }

    public function group($group_id = null, $select = null)
    {
        $query = $this->with([
            'studyGroup' => function(\yii\db\ActiveQuery $query) use ($select) {
                if(is_array($select)){
                    $query->select($select);
                }
            }
        ]);

        if(is_numeric($group_id) && $group_id > 0){
            $query->where(['id' => $group_id]);
        }

        return $query;
    }

    public function current($incrementTime = '+1', $decrementTime = '-1')
    {
        return $this->leftJoin('schedule_aviable_couple ac', 'ac.id = schedule_schedule.couple_id')
            ->where(['study_group_id' => 1, 'weekly_type_id' => 2, 'day_id' => 1])
            ->andWhere([
                'between', 'ac.lessonStart',
                date('H:i:s', strtotime('08:20')),
                date('H:i:s', strtotime('now' . $incrementTime . ' hour'))
            ]);
    }

}


