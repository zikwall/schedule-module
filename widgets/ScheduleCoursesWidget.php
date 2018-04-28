<?php

namespace humhub\modules\schedule\widgets;

use humhub\modules\faculties\models\UniversityFaculties;
use Yii;
use humhub\modules\questionanswer\helpers\Url;
use humhub\widgets\BaseMenu;
use yii\base\InvalidCallException;

class ScheduleCoursesWidget extends ExtendedMenuWidget
{
    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/tabMenu";

    /** toDo: parameter passing for widget */
    public $faculty;
    public $course;

    public function init()
    {
        $action = Yii::$app->controller->action->id;
        $request = Yii::$app->request;

        if($action != 'about' && $action != 'about-schedule'){
            $getGourse = $request->getQueryParam('course');

            $url = $action == 'global-alternative' ? '/schedule/public/global-alternative' : '/schedule/public/global';

            /**
             * toDo: create autogenerated tabs with couses, using constraints for faculties
             */
            if(!$faculty = UniversityFaculties::findOne($this->faculty)){
                throw new InvalidCallException('mde');
            }

            for($course = 1; $course <= $faculty->maxCourseNumber; $course++){
                $this->addItem([
                    'label' => $course.' курс',
                    'url' => Url::to([$url, 'faculty' => $this->faculty, 'course' => $course]),
                    'sortOrder' => 100 + $course,
                    'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule'
                        && Yii::$app->controller->id == 'public'
                        && $request->getQueryParam('faculty') == $this->faculty
                        && (!empty($getGourse) ? $getGourse : 1) == $course
                    ),
                ]);
            }

            $this->addItem([
                'label' => 'Обычное',
                'htmlOptions' => [
                    'classOption' => 'pull-right',
                ],
                'url' => Url::to([
                    '/schedule/public/global',
                    'faculty' => $request->getQueryParam('faculty'),
                    'course' => $request->getQueryParam('course'),
                ]),
                'sortOrder' => 99996,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'public' && $action == 'global'),
            ]);

            $this->addItem([
                'label' => 'Альтернативное',
                'htmlOptions' => [
                    'classOption' => 'pull-right',
                ],
                'url' => Url::to([
                    '/schedule/public/global-alternative',
                    'faculty' => $request->getQueryParam('faculty'),
                    'course' => $request->getQueryParam('course'),
                ]),
                'sortOrder' => 99997,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'public' && $action == 'global-alternative'),
            ]);
        }

        $this->addItem([
            'label' => 'Что такое АИСУ24?',
            'htmlOptions' => [
                'classOption' => 'pull-right',
            ],
            'url' => Url::to('/schedule/public/about'),
            'sortOrder' => 99998,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'public' && $action == 'about'),
        ]);

        $this->addItem([
            'label' => 'Что такое расписание в АИСУ24?',
            'htmlOptions' => [
                'classOption' => 'pull-right',
            ],
            'url' => Url::to('/schedule/public/about-schedule'),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'public' && $action == 'about-schedule'),
        ]);

        return parent::init(); // TODO: Change the autogenerated stub
    }
}