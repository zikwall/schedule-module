<?php

namespace humhub\modules\schedule\widgets;

use Yii;
use yii\helpers\Url;

class FrontAdvancedMenu extends \humhub\widgets\BaseMenu
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
            'label' => Yii::t('UniversityModule.base', 'Шапки'),
            'url' => Url::to('/schedule/front-view/headers'),
            'sortOrder' => 100,
            'isVisible' => Yii::$app->user->isAdmin(),
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && (Yii::$app->controller->action->id == 'headers' || Yii::$app->controller->action->id == 'index')),
        ]);

        $this->addItem([
            'label' => Yii::t('UniversityModule.base', 'Метки'),
            'url' => Url::toRoute('/schedule/front-view/marks'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module
                && Yii::$app->controller->module->id == 'schedule'
                && Yii::$app->controller->id == 'front-view'
                && Yii::$app->controller->action->id == 'marks'),
            'isVisible' => Yii::$app->user->isAdmin(),
        ]);

        parent::init();
    }

}
