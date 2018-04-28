<?php

namespace humhub\modules\schedule\widgets;

use Yii;
use yii\helpers\Url;

class ScheduleAdvancedMenu extends \humhub\widgets\BaseMenu
{

    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/subTabMenu";

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addItem([
            'label' => Yii::t('UniversityModule.base', 'Расписние'),
            'icon' => '<i class="fa fa-dashboard"></i>',
            'url' => Url::to('/schedule/admin/index'),
            'sortOrder' => 100,
            'isVisible' => Yii::$app->user->isAdmin(),
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'admin'),
        ]);

        $this->addItem([
            'label' => Yii::t('UniversityModule.base', 'Дни недели'),
            'url' => Url::toRoute('/schedule/aviable-days'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'aviable-days'),
            'isVisible' => Yii::$app->user->isAdmin(),
        ]);

        $this->addItem([
            'label' => Yii::t('UniversityModule.base', 'Пары'),
            'url' => Url::toRoute('/schedule/aviable-couples'),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'aviable-couples'),
            'isVisible' => Yii::$app->user->isAdmin(),
        ]);

        $this->addItem([
            'label' => Yii::t('UniversityModule.base', 'Типы учебных недель'),
            'url' => Url::toRoute('/schedule/weekly-type'),
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'weekly-type'),
            'isVisible' => Yii::$app->user->isAdmin(),
        ]);

        $this->addItem([
            'label' => Yii::t('UniversityModule.base', 'Типы учебных занятий'),
            'url' => Url::toRoute('/schedule/lesson-type'),
            'sortOrder' => 500,
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'lesson-type'),
            'isVisible' => Yii::$app->user->isAdmin(),
        ]);

        $this->addItem([
            'label' => Yii::t('UniversityModule.base', 'Дисциплины'),
            'url' => Url::toRoute('/schedule/discipline'),
            'sortOrder' => 600,
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'discipline'),
            'isVisible' => Yii::$app->user->isAdmin(),
        ]);

        parent::init();
    }

}
