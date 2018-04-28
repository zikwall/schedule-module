<?php

namespace humhub\modules\schedule\widgets;

use humhub\modules\faculties\models\UniversityFaculties;
use humhub\modules\user\models\User;
use Yii;
use humhub\modules\questionanswer\helpers\Url;
use humhub\widgets\BaseMenu;
use yii\base\InvalidCallException;

class ScheduleTypeWidget extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/tabMenu";
    public $type = "scheduleProfileNavigation";
    public $id = "schedule-profile-menu";

    /**
     * @var User
     */
    public $user;


    public function init()
    {
        $this->addItem([
            'label' => 'Расписание',
            'icon' => '<i class="fa fa-bars"></i>',
            'url' => $this->user->createUrl('/schedule/my'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'my' && Yii::$app->controller->action->id == 'index'),
        ]);

        $this->addItem([
            'label' => 'Альтернативный вид',
            'icon' => '<i class="fa fa-bars"></i>',
            'url' => $this->user->createUrl('/schedule/my/alternative'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'my' && Yii::$app->controller->action->id == 'alternative'),
        ]);

        return parent::init();
    }
}