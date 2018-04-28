<?php

namespace humhub\modules\schedule\models;

use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "schedule_lesson_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $en_name
 * @property string $color
 * @property string $desc
 * @property string $sign
 *
 * @property ScheduleSchedule[] $scheduleSchedules
 */
class ScheduleLessonType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_lesson_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'en_name'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 7],
            [['desc'], 'string', 'max' => 200],
            [['sign'], 'string', 'max' => 20],
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
            'en_name' => Yii::t('ScheduleModule.base', 'En Name'),
            'desc' => Yii::t('ScheduleModule.base', 'Desc'),
            'color' => Yii::t('ScheduleModule.base', 'Color'),
            'sign' => Yii::t('ScheduleModule.base', 'Sign'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleSchedules()
    {
        return $this->hasMany(ScheduleSchedule::className(), ['type_id' => 'id']);
    }

    /**
     * @return array[]
     */
    public static function getList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }
}
