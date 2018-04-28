<?php

namespace humhub\modules\schedule;

use humhub\modules\schedule\widgets\NearestCouplesWidget;
use Yii;
use yii\helpers\Url;

class Events extends \yii\base\Object
{
    public static function addUserCoupleWidget($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        if(!$event->sender->user->isModuleEnabled('schedule')){
            return;
        }

        $event->sender->addWidget(NearestCouplesWidget::className(), [], [
            'sortOrder' => 100
        ]);

    }

    public function addProfileScheduleTabs($event)
    {
        $event->sender->addItem([
            'label' => 'Расписание',
            'icon' => '<i class="fa fa-bars"></i>',
            'url' => $event->sender->user->createUrl('/schedule/my'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'my' && Yii::$app->controller->action->id == 'index'),
        ]);

        $event->sender->addItem([
            'label' => 'Альтернативный вид',
            'icon' => '<i class="fa fa-bars"></i>',
            'url' => $event->sender->user->createUrl('/schedule/my/alternative'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'my' && Yii::$app->controller->action->id == 'alternative'),
        ]);
    }


    public static function onProfileMenuInit($event)
    {
        if ($event->sender->user !== null && $event->sender->user->isModuleEnabled('schedule')){

            $event->sender->addItem(array(
                'label' => 'Расписание',
                'url' => $event->sender->user->createUrl('/schedule/my'),
                'icon' => '<i class="fa fa-calendar"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule')
            ));
        }
    }

    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Расписание занятий",
            'icon' => '<i class="fa fa-calendar"></i>',
            'url' => Url::to(['/schedule/public']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule'),
        ));
    }

    public static function onStudentMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Расписание занятий",
            'icon' => '<i class="fa fa-calendar" style="color: #6fdbe8;"></i>',
            'url' => Url::to(['/schedule/public']),
            'sortOrder' => 1100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule'),
        ));
    }

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Расписание занятий",
            'url' => Url::to(['/schedule/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-calendar"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule'),
            'sortOrder' => 99999,
        ));
    }

}

