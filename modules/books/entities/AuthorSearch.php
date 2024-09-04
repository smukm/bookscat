<?php

declare(strict_types=1);

namespace modules\books\entities;

use Yii;
use yii\base\Model;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;


class AuthorSearch extends Author
{
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['firstname', 'middlename', 'lastname'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = Author::find()->cache(Yii::$app->params['cacheDuration'], new TagDependency([
            'tags' => [Author::tableName()]
        ]));

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

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname]);

        return $dataProvider;
    }
}
