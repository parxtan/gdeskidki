<?php

/**
 * This is the model class for table "tbl_form".
 *
 * The followings are the available columns in table 'tbl_form':
 * @property string $date
 * @property string $name
 * @property string $lastname
 * @property string $email
 * @property string $text
 * @property integer $id
 * @property string $file
 * @property integer $vacancy
 * @property string $age
 * @property string $sex
 * @property string $color
 * @property string $tirazh
 * @property string $width
 * @property string $height
 * @property integer $gold
 * @property integer $platina
 * @property string $arts
 * @property string $delivered
 * @property integer $user_id
 * @property string $tel
 */
class Form extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Form the static model class
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
		return 'tbl_form';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, lastname, email, tel, color, tirazh, width, height', 'required', 'on'=>'new'),
		
			array('vacancy, gold, platina, user_id, rubric_id', 'numerical', 'integerOnly'=>true),
			array('date, lastname, age, sex, color, tirazh, width, height, delivered, tel', 'length', 'max'=>50),
			array('name, email', 'length', 'max'=>255),
			array('email', 'email'),			
			array('file', 'length', 'max'=>30),
			array('arts', 'length', 'max'=>100),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, name, lastname, email, text, id, file, vacancy, age, sex, color, tirazh, width, height, gold, platina, arts, delivered, user_id, tel', 'safe', 'on'=>'search'),
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
			'date' => 'Дата',
			'name' => 'Имя',
			'lastname' => 'Фамилия',
			'email' => 'E-mail',
			'text' => 'Примечание',
			'id' => 'ID',
			'file' => 'Макет рисунка',
			'vacancy' => 'Vacancy',
			'age' => 'Age',
			'sex' => 'Sex',
			'color' => 'Количество цветов',
			'tirazh' => 'Требуемый тираж',
			'width' => 'Ширина',
			'height' => 'Высота',
			'gold' => 'Золото',
			'platina' => 'Платина',
			'arts' => 'Артикул позиции под нанесение',
			'delivered' => 'Желаемая дата готовности тиража',
			'user_id' => 'User',
			'tel' => 'Контактный телефон',
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

		$criteria->compare('date',$this->date,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('vacancy',$this->vacancy);
		$criteria->compare('age',$this->age,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('tirazh',$this->tirazh,true);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('gold',$this->gold);
		$criteria->compare('platina',$this->platina);
		$criteria->compare('arts',$this->arts,true);
		$criteria->compare('delivered',$this->delivered,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('tel',$this->tel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}