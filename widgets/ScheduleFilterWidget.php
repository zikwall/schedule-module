<?php

namespace humhub\modules\schedule\widgets;

use humhub\components\Widget;

class ScheduleFilterWidget extends Widget
{
    public $days;
    public $couples;
    public $weekly;
    public $types;
    public $disciplines;
    public $teachers;
    public $groups;
    public $groupsAll;
    public $classrooms;
    public $profiles;
    public $specialities;

    public $course;
    public $faculty;
    public $isContainer = false;

    public $group = null;

    public $id = 'filter';

    public function run()
    {
        $this->faculty = \Yii::$app->request->getQueryParam('faculty');
        $this->course = \Yii::$app->request->getQueryParam('course');

        if(!$this->course){
            $this->course = 1;
        }

        return $this->render('scheduleFilter', [
            'days' => $this->days,
            'couples' => $this->couples,
            'weekly' => $this->weekly,
            'types' => $this->types,
            'disciplines' => $this->disciplines,
            'teachers' => $this->teachers,
            'groups' => $this->groups,
            'groupsAll' => $this->groupsAll,
            'classrooms' => $this->classrooms,
            'profiles' => $this->profiles,
            'specialities' => $this->specialities,
            'group' => $this->group,
            'course' => $this->course,
            'faculty' => $this->faculty,
            'isContainer' => $this->isContainer,
            'id' => $this->id
        ]);
    }
}

?>
