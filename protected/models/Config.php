<?php

/**
 * This is the model class for table "tbl_config".
 *
 * The followings are the available columns in table 'tbl_config':
 * @property string $config_name
 * @property string $config_value
 */
class Config extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('config_name', 'required'),
			array('config_name', 'length', 'max'=>50),
			array('config_value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('config_name, config_value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'config_name' => 'Config Name',
			'config_value' => 'Config Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('config_name',$this->config_name,true);
		$criteria->compare('config_value',$this->config_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getConfigData()
	{
		$contactData = Config::model()->findAll();
		
		foreach($contactData as $k=>$v)
			$contacts[$v->config_name] = $v->config_value;
			
		return $contacts;
	}		
}