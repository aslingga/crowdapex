<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "oadode".
 * This model is built by using Gii
 *
 * @property int $id
 * @property int|null $application_id
 * @property int|null $customer_id
 * @property int|null $user_id
 * @property string|null $legal_name
 * @property string|null $business_name
 * @property string|null $business_address
 * @property string|null $business_mailing_address
 * @property string|null $business_phone
 * @property string|null $business_fax
 * @property string|null $business_email
 * @property int|null $application_type
 * @property string|null $business_title
 * @property int|null $lang
 * @property DescriptionOfGoods $goods
 */
class Oadode extends \yii\db\ActiveRecord
{
    const APPLICATION_TYPE_NEW = 1;
    const APPLICATION_TYPE_REASSESMENT = 2;
    const LANG_ENGLISH = 1;
    const LANG_FRENCH = 2;
    const BUSINESS_TITLE_OWNER = 'Owner';
    const BUSINESS_TITLE_AUTHORIZED_INDIVIDUAL = 'Authorized Individual';
    const BUSINESS_TITLE_DESIGNATED_OFFICIAL = 'Designated Official';
    const BUSINESS_TITLE_OFFICER = 'Officer';
    const BUSINESS_TITLE_DIRECTOR = 'Director';
    const BUSINESS_TITLE_EMPLOYEE = 'Employee';
    
    public $goods = [];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oadode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['legal_name', 'business_name', 'business_address', 'business_mailing_address', 'business_phone', 'business_email', 'application_type', 'business_title', 'lang'], 'required'],
            [['application_id', 'customer_id', 'user_id', 'application_type', 'lang'], 'integer'],
            ['business_title', 'validateBusinessTitle', 'on'=>'create'],
            ['business_title', 'validateBusinessTitle', 'on'=>'update'],
            ['goods', 'validateGoods'],
            ['business_email', 'email'],
            [['legal_name', 'business_name', 'business_address', 'business_mailing_address', 'business_phone', 'business_fax', 'business_email'], 'string', 'max' => 255],
            [['business_fax'], 'safe']
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
            'legal_name' => Yii::t('app', 'Legal Name'),
            'business_name' => Yii::t('app', 'Business Name'),
            'business_address' => Yii::t('app', 'Civic Address'),
            'business_mailing_address' => Yii::t('app', 'Mailing Address'),
            'business_phone' => Yii::t('app', 'Telephone Phone'),
            'business_fax' => Yii::t('app', 'Facsimile Fax'),
            'business_email' => Yii::t('app', 'E-mail'),
            'application_type' => Yii::t('app', 'Type of Application'),
            'business_title' => Yii::t('app', 'Business Title'),
            'lang' => Yii::t('app', 'Preffered Languge of Correspondence'),
        ];
    }
    
    public function validateBusinessTitle($attribute, $params, $validator)
    {
        /* $director = false;
        $officer = false;
        $employee = false;
        for ($i = 0; $i < count($this->$attribute); $i++) {
            if ($this->$attribute[$i] == self::BUSINESS_TITLE_DIRECTOR) $director = true;
            if ($this->$attribute[$i] == self::BUSINESS_TITLE_OFFICER) $officer = true;
            if ($this->$attribute[$i] == self::BUSINESS_TITLE_OFFICER) $employee = true;
        }
        
        if ($director) {
            if ($officer) {
                $this->addError($attribute, 'The Business Title must be either "Officer" or "Director". You must choose only one.');
            }
            if ($employee) {
                $this->addError($attribute, 'The Business Title must be either "Director" or "Employee". You must choose only one.');
            }
        } */
    }
    
    public function validateBusinessTitleUpdate($attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, [self::BUSINESS_TITLE_DIRECTOR])) {
            if (!in_array($this->$attribute, [self::BUSINESS_TITLE_OFFICER])) {
                $this->addError($attribute, 'The Business Title must be either "Officer" or "Director". You must select only one.');
            } else if (!in_array($this->$attribute, [self::BUSINESS_TITLE_EMPLOYEE])) {
                $this->addError($attribute, 'The Business Title title must be either "Director" or "Employee". You must select only one.');
            }
        }
    }
    
    public function validateGoods($attribute, $params, $validator)
    {
        foreach ($this->goods as $row) {
            $descGood = new DescriptionOfGoods();
            $descGood->load($row);
            
            if (!$descGood->validate()) {
                $this->addError($attribute, $descGood->getErrors());
            }
        }
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getGoods()
    {
        return DescriptionOfGoods::find()
            ->where(['application_id' => $this->application_id])
            ->all();
        // return $this->hasMany(DescriptionOfGoods::className(), ['application_id' => 'application_id']);
    }
    
    public static function getAllApplicationType() 
    {
        return [
            self::APPLICATION_TYPE_NEW => 'New', 
            self::APPLICATION_TYPE_REASSESMENT => 'Re-Assesment'
        ];
    }
    
    public static function getAllBusinessTitle()
    {
        return [
            self::BUSINESS_TITLE_OWNER => self::BUSINESS_TITLE_OWNER,
            self::BUSINESS_TITLE_AUTHORIZED_INDIVIDUAL => self::BUSINESS_TITLE_AUTHORIZED_INDIVIDUAL,
            self::BUSINESS_TITLE_DESIGNATED_OFFICIAL => self::BUSINESS_TITLE_DESIGNATED_OFFICIAL,
            self::BUSINESS_TITLE_OFFICER => self::BUSINESS_TITLE_OFFICER,
            self::BUSINESS_TITLE_DIRECTOR => self::BUSINESS_TITLE_DIRECTOR,
            self::BUSINESS_TITLE_EMPLOYEE => self::BUSINESS_TITLE_EMPLOYEE
        ];
    }
    
    public static function getAllLanguage()
    {
        return [
            self::LANG_ENGLISH => 'English',
            self::LANG_FRENCH => 'French'
        ];
    }
}
