<?php

namespace common\models;

use Yii;

/**
 *
 * @property int $typeid
 * @property varchar $typename
 

 */
class OaListtype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oa_listtype';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typename','typeid'],'required'],
            [['typeid'],'integer'],
            [['listname','typename'],'string','max'=>50]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'typename' => 'typeName',
            'typeid' =>'typeId',
        ];
    }
}
