<?php

/**
 * This is the model class for table "nb_site_no".
 *
 * The followings are the available columns in table 'nb_site_no':
 * @property string $lid
 * @property string $dpid
 * @property string $create_at
 * @property string $update_at
 * @property string $site_id
 * @property string $is_temp
 * @property string $status
 * @property string $delete_flag
 * @property string $waiter_id
 * @property integer $number
 * @property string $code
 */
class SiteNo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nb_site_no';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('update_at, code', 'required'),
			array('number', 'numerical', 'integerOnly'=>true),
			array('lid, dpid, site_id, waiter_id, code', 'length', 'max'=>10),
			array('is_temp, status, delete_flag', 'length', 'max'=>1),
			array('create_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lid, dpid, create_at, update_at, site_id, is_temp, status, delete_flag, waiter_id, number, code', 'safe', 'on'=>'search'),
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
                   // 'site'=>
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
			'site_id' => '打印机id',
			'is_temp' => 'site_id临时台还是固定台：0固定，1临时',
			'status' => '状态：0开台未下单、1开台已下单、2已结单、3被并台、5被换台、5被撤台。除0、1外，其他状态下该台都可以再开台。',
			'delete_flag' => 'Delete Flag',
			'waiter_id' => '服务员id',
			'number' => 'Number',
			'code' => 'Code',
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
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('is_temp',$this->is_temp,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('delete_flag',$this->delete_flag,true);
		$criteria->compare('waiter_id',$this->waiter_id,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SiteNo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
