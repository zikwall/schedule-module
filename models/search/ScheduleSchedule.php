<?php

namespace humhub\modules\schedule\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\modules\schedule\models\ScheduleSchedule as ScheduleScheduleModel;

/**
 * ScheduleSchedule represents the model behind the search form about `humhub\modules\schedule\models\ScheduleSchedule`.
 */
class ScheduleSchedule extends ScheduleScheduleModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day_id', 'couple_id', 'teacher_id', 'discipline_id', 'study_group_id', 'type_id'], 'integer'],
            [['en_name', 'desc'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ScheduleScheduleModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'day_id' => $this->day_id,
            'couple_id' => $this->couple_id,
            'teacher_id' => $this->teacher_id,
            'discipline_id' => $this->discipline_id,
            'study_group_id' => $this->study_group_id,
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'en_name', $this->en_name])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
