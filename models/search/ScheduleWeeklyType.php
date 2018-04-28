<?php

namespace humhub\modules\schedule\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\modules\schedule\models\ScheduleWeeklyType as ScheduleWeeklyTypeModel;

/**
 * ScheduleWeeklyType represents the model behind the search form about `humhub\modules\schedule\models\ScheduleWeeklyType`.
 */
class ScheduleWeeklyType extends ScheduleWeeklyTypeModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'en_name', 'color', 'sign'], 'safe'],
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
        $query = ScheduleWeeklyTypeModel::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'en_name', $this->en_name])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'sign', $this->sign]);

        return $dataProvider;
    }
}
