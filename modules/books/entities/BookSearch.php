<?php

namespace modules\books\entities;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class BookSearch extends Book
{
    public string $author_name = '';

    public function rules(): array
    {
        return [
            [['id', 'release_year', 'author_id'], 'integer'],
            [['title', 'description', 'isbn', 'photo', 'author_name'], 'safe'],
        ];
    }


    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = Book::find()->with('author');

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
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        if(!empty($this->author_name)) {
            $authors = Author::find()
                ->select(['id'])
                ->where(['like', 'lastname', $this->author_name])
                ->column();

            if($authors) {
                $query->andWhere(['in', 'author_id', $authors]);
            }
        }

        return $dataProvider;
    }
}
