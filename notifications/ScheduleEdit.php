<?php

namespace humhub\modules\schedule\notifications;

use humhub\modules\notification\components\BaseNotification;
use yii\helpers\Html;


class ScheduleEdit extends BaseNotification
{
    public function init()
    {
        $this->moduleId = 'schedule';
        parent::init();
    }

    public function html()
    {
        return \Yii::t(
            'ScheduleModule.notify', '{userName} изменил расписание на "{day}"',
            [
                '{userName}' => '<strong>' . Html::encode($this->originator->getDisplayName()) . '</strong>',
                '{day}' => Html::encode($this->source->day->name) . ' - ' . Html::encode($this->source->couple->displayName),
            ]
        );
    }
}
