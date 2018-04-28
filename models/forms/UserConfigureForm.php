<?php

namespace humhub\modules\schedule\models\forms;

use Yii;

class UserConfigureForm extends \yii\base\Model {

    public $userStudyGroup;

    public function rules() {
        return [
            ['userStudyGroup', 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'userStudyGroup' => 'Выберие учебную группу',
        ];
    }

}
