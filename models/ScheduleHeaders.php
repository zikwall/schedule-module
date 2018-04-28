<?php

namespace humhub\modules\schedule\models;

use humhub\modules\faculties\models\UniversityFaculties;
use Yii;

/**
 * This is the model class for table "schedule_headers".
 *
 * @property integer $id
 * @property integer $faculty_id
 * @property string $header
 *
 * @property UniversityFaculties $faculty
 */
class ScheduleHeaders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_headers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faculty_id'], 'required'],
            [['faculty_id'], 'integer'],
            [['header'], 'string'],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityFaculties::className(), 'targetAttribute' => ['faculty_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ScheduleModule.base', 'ID'),
            'faculty_id' => Yii::t('ScheduleModule.base', 'Faculty ID'),
            'header' => Yii::t('ScheduleModule.base', 'Header'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(UniversityFaculties::className(), ['id' => 'faculty_id']);
    }
}
