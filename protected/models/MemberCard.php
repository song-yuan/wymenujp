<?php

/**
 * This is the model class for table "nb_member_card".
 *
 * The followings are the available columns in table 'nb_member_card':
 * @property string $lid
 * @property string $dpid
 * @property string $create_at
 * @property string $update_at
 * @property string $selfcode
 * @property string $rfid
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property string $haspassword
 * @property string $password_hash
 * @property string $sex
 * @property string $ages
 * @property string $all_money
 * @property string $delete_flag
 */
class MemberCard extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberCard the static model class
	 */
	public $password_hash1;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nb_member_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lid, dpid, all_money,selfcode,rfid', 'length', 'max'=>10),
			array('name, mobile, ages', 'length', 'max'=>20),
			//array('rfid', 'length', 'max'=>128),
			array('email', 'length', 'max'=>100),
			array('haspassword, sex, delete_flag', 'length', 'max'=>1),
			array('password_hash', 'length', 'max'=>60),
			array('create_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lid, dpid, create_at, update_at, selfcode, rfid, name, mobile, email, haspassword, password_hash, sex, ages, all_money, delete_flag', 'safe', 'on'=>'search'),
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
			'lid' => 'Lid',
			'dpid' => 'Dpid',
			'create_at' => 'Create At',
			'update_at' => 'Update At',
			'selfcode' => '会员号',
			'rfid' => '卡号',
			'name' => '姓名',
			'mobile' => '联系方式',
			'email' => '邮箱',
			'haspassword' => 'Haspassword',
			'password_hash' => '支付密码',
			'password_hash1' => '确认支付密码',
			'sex' => '性别',
			'ages' => '年龄',
			'all_money' => '总金额',
			'delete_flag' => 'Delete Flag',
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

		$criteria->compare('lid',$this->lid,true);
		$criteria->compare('dpid',$this->dpid,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('update_at',$this->update_at,true);
		$criteria->compare('selfcode',$this->selfcode,true);
		$criteria->compare('rfid',$this->rfid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('haspassword',$this->haspassword,true);
		$criteria->compare('password_hash',$this->password_hash,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('ages',$this->ages,true);
		$criteria->compare('all_money',$this->all_money,true);
		$criteria->compare('delete_flag',$this->delete_flag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}