<?php

namespace humhub\modules\schedule\models;

use Yii;

/**
 * This is the model class for table "schedule_link_subgroups".
 *
 * @property integer $id
 * @property integer $schedule_id
 * @property integer $subgroup_id
 *
 * @property ScheduleSchedule $schedule
 * @property ScheduleSubgroups $subgroup
 */
class ScheduleLinkSubgroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_link_subgroups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'subgroup_id'], 'required'],
            [['schedule_id', 'subgroup_id'], 'integer'],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleSchedule::className(), 'targetAttribute' => ['schedule_id' => 'id']],
            [['subgroup_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleSubgroups::className(), 'targetAttribute' => ['subgroup_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ScheduleModule.base', 'ID'),
            'schedule_id' => Yii::t('ScheduleModule.base', 'Schedule ID'),
            'subgroup_id' => Yii::t('ScheduleModule.base', 'Subgroup ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(ScheduleSchedule::className(), ['id' => 'schedule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubgroup()
    {
        return $this->hasOne(ScheduleSubgroups::className(), ['id' => 'subgroup_id']);
    }
}
