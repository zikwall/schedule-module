<?php

namespace humhub\modules\schedule\components\cellconstructor;

use Yii;

/**
 * Class ConstructorComponent - basic component class
 */
class ConstructorComponent
{
    public function can($permission, $params = [], $allowCaching = true)
    {
        return Yii::$app->getUser()->can($permission, $params, $allowCaching);
    }

    public function render($view, $params = [], $context = null)
    {
        return Yii::$app->getView()->render($view, $params, $context);
    }
}