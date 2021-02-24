<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "description_of_goods".
 * This model is built by using Gii
 *
 * @property int $id
 * @property int|null $application_id
 * @property int|null $customer_id
 * @property int|null $user_id
 * @property string|null $description
 * @property string|null $ecl_group
 * @property string|null $ecl_item
 */
class DescriptionOfGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'description_of_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'ecl_group', 'ecl_item'], 'required'],
            ['description', 'match', 'pattern' => '/^[a-zA-Z.,-]+(?:\s[a-zA-Z.,-]+)*$/', 'message' => 'Invalid characters in Goods Description.'],
            ['ecl_group', 'match', 'pattern' => '/^[0-9.,]*$/', 'message' => 'Invalid characters in ECL Group.'],
            ['ecl_item', 'match', 'pattern' => '/^[0-9.,]*$/', 'message' => 'Invalid characters in ECL Group.'],
            [['application_id', 'customer_id', 'user_id'], 'integer'],
            [['description', 'ecl_group', 'ecl_item'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'application_id' => Yii::t('app', 'Application ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'description' => Yii::t('app', 'Description'),
            'ecl_group' => Yii::t('app', 'Ecl Group'),
            'ecl_item' => Yii::t('app', 'Ecl Item'),
        ];
    }
}
