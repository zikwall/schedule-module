<?php

namespace humhub\modules\schedule\controllers;

use Yii;
use humhub\modules\schedule\models\forms\ConfigureForm;
use humhub\models\Setting;

class AdminConfigureController extends \humhub\modules\admin\components\Controller
{

    public function actionIndex()
    {
        $form = new ConfigureForm();
        $manager = Yii::$app->getModule('schedule')->settings;

        $form->activeDisciplineColor = $manager->get('activeDisciplineColor');
        $form->informationLabel = $manager->get('informationLabel');

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $manager->set('activeDisciplineColor', $form->activeDisciplineColor);
            $manager->set('informationLabel', $form->informationLabel);
        }
        
        return $this->render('index', [
            'model' => $form
        ]);
    }
}

?>
