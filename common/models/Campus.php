<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campus".
 *
 * @property int $id
 * @property string $campus_name
 *
 * @property Room[] $rooms
 */
class Campus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campus_name'], 'required'],
            [['campus_name'], 'string', 'max' => 64],
            [['campus_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campus_name' => 'Campus Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['campus' => 'id']);
    }
}
