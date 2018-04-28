<?php

namespace humhub\modules\schedule\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FrontViewController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@humhub/modules/schedule/views/layouts/_adminmain';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className(),
                'adminOnly' => true
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->actionHeader();
    }

    public function actionHeader()
    {
        return $this->render('headers');
    }

}

