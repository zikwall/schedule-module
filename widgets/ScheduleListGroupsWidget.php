<?php
namespace humhub\modules\schedule\widgets;

use humhub\modules\university\models\UniversityStudyGroups;
use yii\base\Widget;

class ScheduleListGroupsWidget extends Widget
{
    public $course;
    public $faculty;

    public function run()
    {
        if(!$this->course){
            $this->course = 1;
        }

        $groups = UniversityStudyGroups::find()->where([
            'course_id' => $this->course, 'faculty_id' => $this->faculty
        ])->orderBy('displayName')->all();

        return $this->render('scheduleListGroupWidget', [
            'groups' => $groups
        ]);
    }
}
