<?php
class SiteClass
{
        public static function getSitePersons($companyId,$siteTypeLid){
		$sql = 'select distinct t.dpid as dpid,t.splid as splid,t.type_id as typeid,'
                            . 'sp.min_persons as min,sp.max_persons as max, tq.queuepersons as queuepersons, sf.sitenum as sitefree'
                            . '  from nb_site t'
                            . ' LEFT JOIN nb_site_persons sp on t.dpid=sp.dpid and t.splid=sp.lid'
                            . ' LEFT JOIN (select distinct qp.dpid as dpid,qp.stlid as stlid,qp.splid as splid, count(qp.lid) as queuepersons'
                            . '  from nb_queue_persons qp where qp.delete_flag=0 and qp.status=0 '
                            . ' and qp.create_at >="'.date('Y-m-d',time()).' 00:00:00"' .' and qp.create_at<="'.date('Y-m-d',time()).' 23:59:59"'
                            . ' group by dpid,stlid,splid) tq'
                            . ' on t.dpid=tq.dpid and t.type_id=tq.stlid and t.splid=tq.splid'
                            . ' LEFT JOIN (select distinct subt.dpid as dpid,subt.splid as splid,subt.type_id as typeid,count(*) as sitenum '
                            . 'from nb_site subt where subt.status not in(1,2,3) and subt.delete_flag=0'
                            . ' group by dpid,splid,typeid) sf'
                            . ' on sf.dpid=t.dpid and sf.splid=t.splid and sf.typeid=t.type_id'
                            . ' where t.delete_flag=0 and t.dpid= '.$companyId.' and t.type_id='.$siteTypeLid
                            . ' group by dpid,splid,typeid,min,max'
                            . ' order by typeid,min';
                    $connect = Yii::app()->db->createCommand($sql);
                    $models = $connect->queryAll();
                    return $models;
	}
        
        public static function getSitePersonsAll($companyId){
		$sql = 'select distinct t.dpid as dpid,t.splid as splid,t.type_id as typeid,'
                            . 'sp.min_persons as min,sp.max_persons as max, tq.queuepersons as queuepersons, sf.sitenum as sitefree'
                            . '  from nb_site t'
                            . ' LEFT JOIN nb_site_persons sp on t.dpid=sp.dpid and t.splid=sp.lid'
                            . ' LEFT JOIN (select distinct qp.dpid as dpid,qp.stlid as stlid,qp.splid as splid, count(qp.lid) as queuepersons'
                            . '  from nb_queue_persons qp where qp.delete_flag=0 and qp.status=0 '
                            . ' and qp.create_at >="'.date('Y-m-d',time()).' 00:00:00"' .' and qp.create_at<="'.date('Y-m-d',time()).' 23:59:59"'
                            . ' group by dpid,stlid,splid) tq'
                            . ' on t.dpid=tq.dpid and t.type_id=tq.stlid and t.splid=tq.splid'
                            . ' LEFT JOIN (select distinct subt.dpid as dpid,subt.splid as splid,subt.type_id as typeid,count(*) as sitenum '
                            . 'from nb_site subt where subt.status not in(1,2,3) and subt.delete_flag=0'
                            . ' group by dpid,splid,typeid) sf'
                            . ' on sf.dpid=t.dpid and sf.splid=t.splid and sf.typeid=t.type_id'
                            . ' where t.delete_flag=0 and t.dpid= '.$companyId
                            . ' group by dpid,splid,typeid,min,max'
                            . ' order by typeid,min';
                    $connect = Yii::app()->db->createCommand($sql);
                    $models = $connect->queryAll();
                    return $models;
	}
    
        public static function getTypes($companyId){
		$types = SiteType::model()->findAll('dpid=:companyId and delete_flag=0' , array(':companyId' => $companyId)) ;
		$types = $types ? $types : array();
		return CHtml::listData($types, 'lid', 'name');
	}
        
         public static function getRandChar($length){
            $str = null;
            $strPol = "0123456789";
            $max = strlen($strPol)-1;

            for($i=0;$i<$length;$i++){
                $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
            }
            return $str;
        }
        
        public static function getCode($companyId){
		$code= SiteClass::getRandChar(6);
                //var_dump($code);exit;
                //return $code;/*apc should be deleted*/
                Gateway::getOnlineStatus();
                $store = Store::instance('wymenu');
                $ret = $store->get($companyId.$code);
                while(!empty($ret))
                {
                    $code= $this->getRandChar(6); 
                    $ret = $store->get($companyId.$code);                    
                }
                $store->set($companyId.$code,'1',0,0);
                /*if(Yii::app()->params->has_cache)
                {
                    $ccode = apc_fetch($companyId.$code);
                    while(!empty($ccode))
                    {
                        $code= $this->getRandChar(6);                    
                        $ccode = apc_fetch($companyId.$code);
                    }
                    apc_store($companyId.$code,'1',0);//永久存储用apc_delete($key)删除
                }*/
                return $code;
	}
        
        public static function deleteCode($companyId,$code)
        {		
            Gateway::getOnlineStatus();
            $store = Store::instance('wymenu');
            $ret = $store->delete($companyId.$code);
            /*if(Yii::app()->params->has_cache)
            {
                $ccode = apc_delete($companyId.$code);                    
            }*/                
	}
        
        public static function getSiteNmae($companyId,$id,$istemp){
		if($istemp)
                {
                    return yii::t('app','临时座：').$id%1000;
                }else{
                    $site=Site::model()->with('siteType')->find(' t.dpid=:dpid and t.lid=:lid',array(':dpid'=>$companyId,':lid'=>$id));
                    //var_dump($site);exit;
                    return $site->siteType->name.': '.$site->serial;
                }                
	}
	
	public static function openTempSite($companyId = 0,$istemp = 1,$siteNumber = 1){
		$db = Yii::app()->db;
        $transaction = $db->beginTransaction();
        try {  
        	 $se=new Sequence("site_no");
             $lid = $se->nextval();
             $se=new Sequence("temp_site");
             $site_id = $se->nextval();
             $code = SiteClass::getCode($companyId);
            $data = array(
                'lid'=>$lid,
                'dpid'=>$companyId,
                'create_at'=>date('Y-m-d H:i:s',time()),
                'update_at'=>date('Y-m-d H:i:s',time()),
                'is_temp'=>$istemp,
                'site_id'=>$site_id,
                'status'=>'1',
                'code'=>$code,
                'number'=>$siteNumber,
                'delete_flag'=>'0'
            );                            
            $db->createCommand()->insert('nb_site_no',$data);
            
            $sef=new Sequence("order_feedback");
            $lidf = $sef->nextval();
            $dataf = array(
                'lid'=>$lidf,
                'dpid'=>$companyId,
                'create_at'=>date('Y-m-d H:i:s',time()),
                'update_at'=>date('Y-m-d H:i:s',time()),
                'is_temp'=>$istemp,
                'site_id'=>$site_id,
                'is_deal'=>'0',
                'feedback_id'=>0,
                'order_id'=>0,
                'is_order'=>'1',
                'feedback_memo'=>yii::t('app','开台'),
                'delete_flag'=>'0'
            );
            $db->createCommand()->insert('nb_order_feedback',$dataf);  
            
             
             $transaction->commit();
	         return $code;
        } catch (Exception $e) {
            $transaction->rollback(); //如果操作失败, 数据回滚
            return false;
        } 
	}
        
        public static function openSite($companyId = 0,$siteNumber = 1,$istemp = 1,$sid = 0){
                $db = Yii::app()->db;
                //return array('status'=>0,'msg'=>yii::t('app','开台失败122'),'siteid'=>"111");
                $transaction = $db->beginTransaction();
                try {                          
                    if($istemp=="0")
                    {
                        $sqlsite="update nb_site set status=1,number=:number where lid=:sid and dpid=:companyId";
                        $commandsite=$db->createCommand($sqlsite);
                        $commandsite->bindValue(":number" , $siteNumber);
                        $commandsite->bindValue(":sid" , $sid);
                        $commandsite->bindValue(":companyId" , $companyId);
                        $commandsite->execute();
                    }                           
                             
                    $se=new Sequence("site_no");
                    $lid = $se->nextval();
                    $site_id=$sid;
                    if($istemp!=0)
                    {
                        $se=new Sequence("temp_site");
                        $site_id = $se->nextval();                            
                    }
                    //return array('status'=>0,'message'=>"dddddd22",'siteid'=>$sid);
                    ///开台之前删除可能产生的脏数据
                    
                    $sqlsiteno="update nb_site_no set status='7' where site_id=:sid and is_temp=:istemp and dpid=:companyId and status in ('1','2')";
                    $commandsiteno=$db->createCommand($sqlsiteno);
                    $commandsiteno->bindValue(":sid" , $sid);
                    $commandsiteno->bindValue(":istemp" , $istemp);
                    $commandsiteno->bindValue(":companyId" , $companyId);
                    $commandsiteno->execute();
                    /////
                    
                    $code = "0000";//SiteClass::getCode($companyId);
                    
                    $data = array(
                        'lid'=>$lid,
                        'dpid'=>$companyId,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                        'update_at'=>date('Y-m-d H:i:s',time()),
                        'is_temp'=>$istemp,
                        'site_id'=>$site_id,
                        'status'=>'1',
                        'code'=>$code,
                        'number'=>$siteNumber,
                        'delete_flag'=>'0'
                    );                            
                    $db->createCommand()->insert('nb_site_no',$data);

                    ///***********insert to order feedback
//                    $sef=new Sequence("order_feedback");
//                    $lidf = $sef->nextval();
//                    $dataf = array(
//                        'lid'=>$lidf,
//                        'dpid'=>$companyId,
//                        'create_at'=>date('Y-m-d H:i:s',time()),
//                        'update_at'=>date('Y-m-d H:i:s',time()),
//                        'is_temp'=>$istemp,
//                        'site_id'=>$site_id,
//                        'is_deal'=>'0',
//                        'feedback_id'=>0,
//                        'order_id'=>0,
//                        'is_order'=>'1',
//                        'feedback_memo'=>'开台',
//                        'delete_flag'=>'0'
//                    );
//                    $db->createCommand()->insert('nb_order_feedback',$dataf);
                    ///*************print
                    $transaction->commit(); //提交事务会真正的执行数据库操作
                    return array('status'=>1,'msg'=>yii::t('app','开台成功'),'siteid'=>$site_id);  
                    //return true;
            } catch (Exception $e) {
                    $transaction->rollback(); //如果操作失败, 数据回滚
                    return array('status'=>0,'msg'=>yii::t('app','开台失败'),'siteid'=>$site_id); 
                    //return false;
            }    
        }
}