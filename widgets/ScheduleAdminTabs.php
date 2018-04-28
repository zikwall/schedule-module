<?php

namespace humhub\modules\schedule\widgets;

use Yii;
use yii\helpers\Url;


class ScheduleAdminTabs extends \humhub\widgets\BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/tabMenu";

    /**
     * @inheritdoc
     */
    public function init()
    {
        if(!Yii::$app->user->isAdmin()){
            return;
        }

        $this->addItem([
            'label' => 'Расписание',
            'icon' => '<i class="fa fa-bars"></i>',
            'url' => Url::to('/schedule/admin/index'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'admin'),
        ]);

        $this->addItem([
            'label' => 'Преподавательский состав',
            'url' => Url::to('/schedule/teacher/index'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'teacher'),
        ]);

        $this->addItem([
            'label' => 'Учебные группы',
            'url' => Url::to('/schedule/study-groups'),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'study-groups'),
        ]);

        $this->addItem([
            'label' => 'Внешний вид',
            'url' => Url::to('/schedule/front-view'),
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'schedule' && Yii::$app->controller->id == 'front-view'),
        ]);

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return parent::run();
    }


}
