<?php

namespace humhub\modules\schedule\models;

use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use humhub\modules\schedule\behaviors\Identity;
use Yii;

/**
 * This is the model class for table "schedule_aviable_couple".
 *
 * @property integer $id
 * @property string $identity
 * @property integer $status
 * @property string $displayName
 * @property string $name
 * @property string $en_name
 * @property string $lessonStart
 * @property string $lessonEnd
 * @property string $color
 * @property string $desc
 *
 * @property ScheduleSchedule[] $scheduleSchedules
 */
class ScheduleAviableCouple extends \yii\db\ActiveRecord
{
    public $couples;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_aviable_couple}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identity', 'displayName', 'name', 'lessonStart', 'lessonEnd'], 'required'],
            [['lessonStart', 'lessonEnd'], 'safe'],
            [['identity'], 'string', 'max' => 150],
            [['displayName', 'name', 'en_name'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 7],
            [['desc'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ScheduleModule.base', 'ID'),
            'identity' => Yii::t('ScheduleModule.base', 'Identity'),
            'status' => Yii::t('ScheduleModule.base', 'Status'),
            'displayName' => Yii::t('ScheduleModule.base', 'Display Name'),
            'name' => Yii::t('ScheduleModule.base', 'Name'),
            'en_name' => Yii::t('ScheduleModule.base', 'En Name'),
            'lessonStart' => Yii::t('ScheduleModule.base', 'Lesson Start'),
            'lessonEnd' => Yii::t('ScheduleModule.base', 'Lesson End'),
            'color' => Yii::t('ScheduleModule.base', 'Color'),
            'desc' => Yii::t('ScheduleModule.base', 'Desc'),
        ];
    }

    public function behaviors()
    {
        return [
            //Identity::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleSchedules()
    {
        return $this->hasMany(ScheduleSchedule::className(), ['couple_id' => 'id']);
    }

    /**
     * @return array[]
     */
    public static function getList($couple = null)
    {
        $query = self::find();

        if(!empty($couple)){
            $query->where(['id' => $couple]);
        }

        return ArrayHelper::map($query->asArray()->all(), 'id', 'displayName');
    }

    /**
     * @return string
     */
    public function getDisplayTime()
    {
        return date('H:i', strtotime($this->lessonStart)) . '-' . date('H:i', strtotime($this->lessonEnd));
    }
}
