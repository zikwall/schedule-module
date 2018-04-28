<?php

namespace humhub\modules\schedule\widgets;

use humhub\modules\faculties\models\UniversityFaculties;
use Yii;
use humhub\modules\questionanswer\helpers\Url;
use humhub\widgets\BaseMenu;
use yii\base\InvalidCallException;

class ScheduleAdminCoursesWidget extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/subTabMenu";

    /**
     * @var UniversityFaculties
     */
    public $faculty;
    public $course;

    public function init()
    {
        $getGourse = !empty($this->course) ? $this->course : Yii::$app->request->getQueryParam('course');

        if(!$faculty = UniversityFaculties::findOne($this->faculty)){
            throw new InvalidCallException('mde');
        }

        for($course = 1; $course <= $faculty->maxCourseNumber; $course++){
            $this->addItem([
                'label' => $course.' курс',
                'url' => Url::to(['/schedule/admin/course-schedule', 'faculty' => $this->faculty, 'course' => $course]),
                'sortOrder' => 100 + $course,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule'
                    && Yii::$app->controller->id == 'admin'
                    && (Yii::$app->request->getQueryParam('faculty') == $this->faculty || $this->faculty == $faculty->id)
                    && (!empty($getGourse) ? $getGourse : 1) == $course
                    && (Yii::$app->controller->action->id != 'header' && Yii::$app->controller->action->id != 'edit-header')
                ),
            ]);
        }

        $this->addItem([
            'label' => 'Шапка расписания',
            'htmlOptions' => [
                'classOption' => 'pull-right',
            ],
            'url' => Url::to(['/schedule/admin/header', 'faculty' => $this->faculty]),
            'sortOrder' => 99997,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'admin' && (Yii::$app->controller->action->id == 'header' || Yii::$app->controller->action->id == 'edit-header')),
        ]);

        return parent::init();
    }
}