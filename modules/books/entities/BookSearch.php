<?php

declare(strict_types=1);

namespace modules\books\entities;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class BookSearch extends Book
{
    public string $authors = '';

    public function rules(): array
    {
        return [
            [['id', 'release_year'], 'integer'],
            [['title', 'description', 'isbn', 'photo', 'authors'], 'safe'],
        ];
    }


    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = Book::find()->with('authors');

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
            'release_year' => $this->release_year,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        if(!empty($this->authors)) {
            $authors = Author::find()
                ->select(['id'])
                ->where(['like', 'lastname', $this->authors])
                ->column();

            $query->joinWith('authors');
            $query->where(['in', 'authors.id', $authors]);
        }

        return $dataProvider;
    }
}
