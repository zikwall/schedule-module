<?php

namespace humhub\modules\schedule\models;

use humhub\modules\university\models\UniversityTeachers;
use Yii;

/**
 * This is the model class for table "schedule_position".
 *
 * @property integer $id
 * @property string $name
 * @property string $shortname
 * @property string $en_name
 * @property string $desc
 *
 * @property UniversityTeachers[] $universityTeachers
 */
class SchedulePosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_position}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'en_name'], 'string', 'max' => 100],
            [['shortname', 'desc'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ScheduleModule.base', 'ID'),
            'name' => Yii::t('ScheduleModule.base', 'Name'),
            'shortname' => Yii::t('ScheduleModule.base', 'Shortname'),
            'en_name' => Yii::t('ScheduleModule.base', 'En Name'),
            'desc' => Yii::t('ScheduleModule.base', 'Desc'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityTeachers()
    {
        return $this->hasMany(UniversityTeachers::className(), ['post_id' => 'id']);
    }
}
