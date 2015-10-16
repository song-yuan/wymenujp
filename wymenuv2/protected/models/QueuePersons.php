<?php

/**
 * This is the model class for table "nb_queue_persons".
 *
 * The followings are the available columns in table 'nb_queue_persons':
 * @property string $lid
 * @property string $dpid
 * @property string $create_at
 * @property string $update_at
 * @property string $stlid
 * @property string $splid
 * @property string $queue_no
 * @property string $status
 * @property string $slid
 */
class QueuePersons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nb_queue_persons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lid', 'required'),
			array('lid, dpid, stlid, splid, slid', 'length', 'max'=>10),
			array('queue_no', 'length', 'max'=>20),
			array('status', 'length', 'max'=>1),
			array('create_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lid, dpid, create_at, update_at, stlid, splid, queue_no, status, slid', 'safe', 'on'=>'search'),
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
			'lid' => '自身id，统一dpid下递增',
			'dpid' => '店铺id',
			'create_at' => 'Create At',
			'update_at' => '更新时间',
			'stlid' => '座位类型的lid',
			'splid' => '对应座位人数表的id',
			'queue_no' => '排队号，每天从001开始，前面加上座位类型，如：A001,B010',
			'status' => '状态，0等位中，1过号，2转移到正式座位',
			'slid' => '转移到的座位对应的lid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lid',$this->lid,true);
		$criteria->compare('dpid',$this->dpid,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('update_at',$this->update_at,true);
		$criteria->compare('stlid',$this->stlid,true);
		$criteria->compare('splid',$this->splid,true);
		$criteria->compare('queue_no',$this->queue_no,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('slid',$this->slid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QueuePersons the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
