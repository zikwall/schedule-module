<?php

namespace humhub\modules\schedule\models\forms;

use Yii;

class ConfigureForm extends \yii\base\Model
{

    public $activeDisciplineColor;
    public $informationLabel;

    public function rules()
    {
        return [
            [['activeDisciplineColor', 'informationLabel'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'activeDisciplineColor' => 'Цвет выделения активных занятий на текущую неделю',
            'informationLabel' => 'Поле информации'
        ];
    }
}
