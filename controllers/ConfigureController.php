<?php
namespace humhub\modules\schedule\controllers;

use humhub\modules\schedule\models\forms\UserConfigureForm;
use humhub\modules\user\models\User;
use Yii;
use humhub\modules\content\components\ContentContainerController;

class ConfigureController extends ContentContainerController
{
    public $subLayout = "@humhub/modules/user/views/account/_layout";
    public $manager;

    public function init()
    {
        $this->manager = Yii::$app->getModule('schedule')->settings;
        parent::init();
    }

    public function actionIndex()
    {
        $configureForm = new UserConfigureForm();

        if($this->contentContainer instanceof User){
            $configureForm->userStudyGroup = $this->manager->user()->get('userStudyGroup');
        }

        if ($configureForm->load(Yii::$app->request->post())) {
            if ($configureForm->validate()) {
                $this->manager->user()->set('userStudyGroup', $configureForm->userStudyGroup);
                Yii::$app->session->setFlash('data-saved', Yii::t('base', 'Saved'));
            }
        }

        return $this->render('index', [
            'model' => $configureForm
        ]);
    }
}