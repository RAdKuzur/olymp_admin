<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school".
 *
 * @property int $id
 * @property string $name
 * @property int $region
 *
 * @property Participant[] $participants
 */
class School extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'school';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'region'], 'required'],
            [['name'], 'string'],
            [['region'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'region' => 'Region',
        ];
    }

    /**
     * Gets query for [[Participants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(Participant::class, ['school_id' => 'id']);
    }

}