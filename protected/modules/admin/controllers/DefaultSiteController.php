<?php

class DefaultSiteController extends BackendController
{
        
        public function actionShowSite()
	{
		$typeId = Yii::app()->request->getParam('typeId');
                $compayId=Yii::app()->request->getParam('companyId');
                $stypeId = Yii::app()->request->getParam('stypeId','0');
                $sistemp = Yii::app()->request->getParam('sistemp','0');
                $ssid = Yii::app()->request->getParam('ssid','0');
                $op = Yii::app()->request->getParam('op','0');
                $title=yii::t('app','请选择餐桌');
                $criteria = new CDbCriteria;		
                $models=array();
                if($typeId == 'queue'){
                    $sql = 'select distinct t.dpid as dpid,t.splid as splid,t.type_id as typeid,st.name as name,'
                            . 'sp.min_persons as min,sp.max_persons as max, tq.queuepersons as queuepersons, sf.sitenum as sitefree'
                            . '  from nb_site t'
                            . ' LEFT JOIN nb_site_type st on t.dpid=st.dpid and t.type_id=st.lid'
                            . ' LEFT JOIN nb_site_persons sp on t.dpid=sp.dpid and t.splid=sp.lid'
                            . ' LEFT JOIN (select distinct qp.dpid as dpid,qp.stlid as stlid,qp.splid as splid, count(qp.lid) as queuepersons'
                            . '  from nb_queue_persons qp where qp.delete_flag=0 and qp.status=0 '
                            . ' and qp.create_at >"'.date('Y-m-d',time()).' 00:00:00"' .' and qp.create_at<"'.date('Y-m-d',time()).' 23:59:59"'
                            . ' group by dpid,stlid,splid) tq'
                            . ' on t.dpid=tq.dpid and t.type_id=tq.stlid and t.splid=tq.splid'
                            . ' LEFT JOIN (select distinct subt.dpid as dpid,subt.splid as splid,subt.type_id as typeid,count(*) as sitenum '
                            . 'from nb_site subt where subt.status not in(1,2,3) and subt.delete_flag=0'
                            . ' group by dpid,splid,typeid) sf'
                            . ' on sf.dpid=t.dpid and sf.splid=t.splid and sf.typeid=t.type_id'
                            . ' where t.delete_flag=0 and t.dpid= '.$compayId
                            . ' group by dpid,splid,typeid,name,min,max'
                            . ' order by typeid,min';
                    $connect = Yii::app()->db->createCommand($sql);
                    $models = $connect->queryAll();
                    //var_dump($sql);exit;                    
                }elseif($typeId == 'tempsite'){
                        $criteria->condition =  't.delete_flag = 0 and t.status in ("1","2","3") and t.is_temp = 1 and t.dpid='.$compayId ;
                        $criteria->order = ' t.number desc,t.site_id desc ';
                        //$criteria->group = ' t.number ';
                        $models = SiteNo::model()->findAll($criteria);
                        //var_dump($models);exit;
                }else{
                        $criteria->with = 'siteType';
                        $criteria->condition =  't.delete_flag = 0 and t.type_id = '.$typeId.' and t.dpid='.$compayId ;
                        $criteria->order = ' t.serial asc ';
                        $models = Site::model()->findAll($criteria);
                }
                if($op=='switch')
                {
                    if($sistemp=='0')
                    {
                        $siteTypes = SiteClass::getTypes($this->companyId);
                        $title=yii::t('app','被换餐桌：').$siteTypes[$stypeId];
                        $modelsite = Site::model()->find('lid=:lid and dpid=:dpid', array(':lid' => $ssid,':dpid'=>  $this->companyId));
                        $title=$title.'-->'.$modelsite->serial.'('.$modelsite->site_level.')'.yii::t('app','::请选择目标餐桌');
                    }else{
                        $title=yii::t('app','被换餐桌：临时台/排队-->').($ssid%1000).yii::t('app','：：请选择目标餐桌');
                    }
                }
                elseif($op=='union')
                {
                    if($sistemp=='0')
                    {
                        $siteTypes = SiteClass::getTypes($this->companyId);
                        $title=yii::t('app','被并餐桌：').$siteTypes[$stypeId];
                        $modelsite = Site::model()->find('lid=:lid and dpid=:dpid', array(':lid' => $ssid,':dpid'=>  $this->companyId));
                        $title=$title.'-->'.$modelsite->serial.'('.$modelsite->site_level.')'.yii::t('app','：：请选择目标餐桌');
                    }else{
                        $title=yii::t('app','被并餐桌：临时台/排队-->').($ssid%1000).yii::t('app','：：请选择目标餐桌');
                    }
                }
		$this->renderPartial('indexsite',array(
				'models'=>$models,
				'typeId' => $typeId,
                                'title' => $title,
                                'ssid' => $ssid,
                                'sistemp' => $sistemp,
                                'stypeId'=>$stypeId,
                                'op'=>$op
		));
	}
        
        public function actionShowSiteAll()
	{
		$typeId = Yii::app()->request->getParam('typeId');
                $compayId=Yii::app()->request->getParam('companyId');
                $criteriat = new CDbCriteria;
                $criteria = new CDbCriteria;
		//$title=yii::t('app','请选择餐桌');
                    $sql = 'select distinct t.dpid as dpid,t.splid as splid,t.type_id as typeid,st.name as name,'
                            . 'sp.min_persons as min,sp.max_persons as max, tq.queuepersons as queuepersons, sf.sitenum as sitefree'
                            . '  from nb_site t'
                            . ' LEFT JOIN nb_site_type st on t.dpid=st.dpid and t.type_id=st.lid'
                            . ' LEFT JOIN nb_site_persons sp on t.dpid=sp.dpid and t.splid=sp.lid'
                            . ' LEFT JOIN (select distinct qp.dpid as dpid,qp.stlid as stlid,qp.splid as splid, count(qp.lid) as queuepersons'
                            . '  from nb_queue_persons qp where qp.delete_flag=0 and qp.status=0 '
                            . ' and qp.create_at >"'.date('Y-m-d',time()).' 00:00:00"' .' and qp.create_at<"'.date('Y-m-d',time()).' 23:59:59"'
                            . ' group by dpid,stlid,splid) tq'
                            . ' on t.dpid=tq.dpid and t.type_id=tq.stlid and t.splid=tq.splid'
                            . ' LEFT JOIN (select distinct subt.dpid as dpid,subt.splid as splid,subt.type_id as typeid,count(*) as sitenum '
                            . 'from nb_site subt where subt.status not in(1,2,3) and subt.delete_flag=0'
                            . ' group by dpid,splid,typeid) sf'
                            . ' on sf.dpid=t.dpid and sf.splid=t.splid and sf.typeid=t.type_id'
                            . ' where t.delete_flag=0 and t.dpid= '.$compayId
                            . ' group by dpid,splid,typeid,name,min,max'
                            . ' order by typeid,min';
                    $connect = Yii::app()->db->createCommand($sql);
                    $queueModels = $connect->queryAll();
                    //var_dump($queueModels);exit;
                    
                        $tempnow = new DateTime(date('Y-m-d H:i:s',time()));
                        //var_dump($tempnow->format('Y-m-d H:i:s'));
                        $tempnow->modify("-12 hour");
                        $begintime=$tempnow->format('Y-m-d H:i:s');
                        $tempnow->modify("24 hour");
                        $endtime=$tempnow->format('Y-m-d H:i:s');
                        //var_dump($begintime,$endtime);exit;
                        $criteriat->condition =  't.delete_flag = 0 and t.status in ("1","2","3") and t.is_temp = 1 and t.dpid='.$compayId 
                                . ' and t.create_at >"'.$begintime .'" and t.create_at<"'.$endtime.'"';
                        $criteriat->order = ' t.number desc,t.site_id desc ';
                        $tempsiteModels = SiteNo::model()->findAll($criteriat);
                        //var_dump($tempsiteModels);exit;
                
                        $criteria->with = 'siteType';
                        $criteria->condition =  't.delete_flag = 0 and t.dpid='.$compayId ;
                        $criteria->order = ' t.serial asc ';
                        $models = Site::model()->findAll($criteria);
                        //var_dump($models);exit;
                
		$this->renderPartial('indexsite',array(
				'models'=>$models,
				'queueModels' => $queueModels,
                                'tempsiteModels' => $tempsiteModels,
                                'typeId'=>$typeId
		));
	}
        
        public function actionGetSiteAll()
	{
		$typeId = Yii::app()->request->getParam('typeId');
                $compayId=Yii::app()->request->getParam('companyId');
                $criteriat = new CDbCriteria;
                $criteria = new CDbCriteria;
		$models=array();
                if($typeId=="queue")
                {
                    $sql = 'select distinct t.dpid as dpid,t.splid as splid,t.type_id as typeid,st.name as name,'
                            . 'sp.min_persons as min,sp.max_persons as max, tq.queuepersons as queuepersons, sf.sitenum as sitefree'
                            . '  from nb_site t'
                            . ' LEFT JOIN nb_site_type st on t.dpid=st.dpid and t.type_id=st.lid'
                            . ' LEFT JOIN nb_site_persons sp on t.dpid=sp.dpid and t.splid=sp.lid'
                            . ' LEFT JOIN (select distinct qp.dpid as dpid,qp.stlid as stlid,qp.splid as splid, count(qp.lid) as queuepersons'
                            . '  from nb_queue_persons qp where qp.delete_flag=0 and qp.status=0 '
                            . ' and qp.create_at >"'.date('Y-m-d',time()).' 00:00:00"' .' and qp.create_at<"'.date('Y-m-d',time()).' 23:59:59"'
                            . ' group by dpid,stlid,splid) tq'
                            . ' on t.dpid=tq.dpid and t.type_id=tq.stlid and t.splid=tq.splid'
                            . ' LEFT JOIN (select distinct subt.dpid as dpid,subt.splid as splid,subt.type_id as typeid,count(*) as sitenum '
                            . 'from nb_site subt where subt.status not in(1,2,3) and subt.delete_flag=0'
                            . ' group by dpid,splid,typeid) sf'
                            . ' on sf.dpid=t.dpid and sf.splid=t.splid and sf.typeid=t.type_id'
                            . ' where t.delete_flag=0 and t.dpid= '.$compayId
                            . ' group by dpid,splid,typeid,name,min,max'
                            . ' order by typeid,min';
                    $connect = Yii::app()->db->createCommand($sql);
                    $models = $connect->queryAll();
                    //var_dump($queueModels);exit;
                }elseif($typeId=="tempsite"){
                        $tempnow = new DateTime(date('Y-m-d H:i:s',time()));
                        //var_dump($tempnow->format('Y-m-d H:i:s'));
                        $tempnow->modify("-12 hour");
                        $begintime=$tempnow->format('Y-m-d H:i:s');
                        $tempnow->modify("24 hour");
                        $endtime=$tempnow->format('Y-m-d H:i:s');
                        //var_dump($begintime,$endtime);exit;
                        $criteriat->select="t.number,t.status,t.site_id,t.update_at";
                        $criteriat->condition =  't.delete_flag = 0 and t.status in ("1","2","3") and t.is_temp = 1 and t.dpid='.$compayId 
                               ;// . ' and t.create_at >"'.$begintime .'" and t.create_at<"'.$endtime.'"';
                        $criteriat->order = ' t.number desc,t.site_id desc ';
                        $tempmodels = SiteNo::model()->findAll($criteriat);
                        foreach ($tempmodels as $model)
                        {
                            array_push($models,array('number'=>$model->number,'status'=>$model->status,'site_id'=>$model->site_id,'update_at'=>$model->update_at));
                        }
                        //var_dump($models);exit;
                }else{
                        $criteria->select = 't.lid,t.status,t.type_id,t.serial,t.update_at';
                        //$criteria->with = 'siteType';
                        $criteria->condition =  't.delete_flag = 0 and t.dpid='.$compayId ;
                        $criteria->order = ' t.serial asc ';
                        $sitemodels = Site::model()->findAll($criteria);
                        foreach ($sitemodels as $model)
                        {
                            array_push($models,array('lid'=>$model->lid,'status'=>$model->status,'type_id'=>$model->type_id,'serial'=>$model->serial,'update_at'=>$model->update_at));
                        }                        
                }
		//var_dump(json_encode($models));exit;
                Yii::app()->end(json_encode($models));
	}
        
        public function actionOpSite()
	{
		$typeId = Yii::app()->request->getParam('typeId');
                $compayId=Yii::app()->request->getParam('companyId');
                $stypeId = Yii::app()->request->getParam('stypeId','0');
                $sistemp = Yii::app()->request->getParam('sistemp','0');
                $ssid = Yii::app()->request->getParam('ssid','0');
                $op = Yii::app()->request->getParam('op','0');
                $title=yii::t('app','请选择餐桌');
                $criteria = new CDbCriteria;
		$models=array();
                
                if($op=='switch')
                {
                    if($sistemp=='0')
                    {
                        $siteTypes = SiteClass::getTypes($this->companyId);
                        $title=yii::t('app','被换餐桌：').$siteTypes[$stypeId];
                        $modelsite = Site::model()->find('lid=:lid and dpid=:dpid', array(':lid' => $ssid,':dpid'=>  $this->companyId));
                        $title=$title.'-->'.$modelsite->serial.'('.$modelsite->site_level.')'.yii::t('app','::请选择目标餐桌');
                    }else{
                        $title=yii::t('app','被换餐桌：临时台/排队-->').($ssid%1000).yii::t('app','：：请选择目标餐桌');
                    }
                }
                elseif($op=='union')
                {
                    if($sistemp=='0')
                    {
                        $siteTypes = SiteClass::getTypes($this->companyId);
                        $title=yii::t('app','被并餐桌：').$siteTypes[$stypeId];
                        $modelsite = Site::model()->find('lid=:lid and dpid=:dpid', array(':lid' => $ssid,':dpid'=>  $this->companyId));
                        $title=$title.'-->'.$modelsite->serial.'('.$modelsite->site_level.')'.yii::t('app','：：请选择目标餐桌');
                    }else{
                        $title=yii::t('app','被并餐桌：临时台/排队-->').($ssid%1000).yii::t('app','：：请选择目标餐桌');
                    }
                }
//		$this->renderPartial('indexsite',array(
//				'typeId' => $typeId,
//                                'title' => $title,
//                                'ssid' => $ssid,
//                                'sistemp' => $sistemp,
//                                'stypeId'=>$stypeId,
//                                'op'=>$op
//		));
                //直接Yii::app()->end(title,);
                //或者直接在页面上设置op等。
	}
        
        public function actionNextPerson()
	{
		$companyId=Yii::app()->request->getParam('companyId');
                $splid = Yii::app()->request->getParam('splid','0');
                $stlid = Yii::app()->request->getParam('stlid','0');
                $callno = Yii::app()->request->getParam('callno','0');
                $queueno="";
                $sitefree=0;
                $queueNum=0;
                //Yii::app()->end(json_encode(array("status"=>true,"callno"=>$callno)));
                $criteria = new CDbCriteria;
                $criteria->condition =  't.status=0 and t.dpid='.$companyId.' and t.stlid='.$stlid.' and t.splid='.$splid.' and queue_no="'.$callno.'"'
                        .' and create_at <="'.date('Y-m-d',time()).' 23:59:59" and create_at >= "'.date('Y-m-d',time()).' 00:00:00"' ;
                $criteria->order = ' t.lid ';
                $queue = QueuePersons::model()->find($criteria);
                if(!empty($queue))
                {
                    $queue->status=2;
                    if($queue->save())
                    {
                        $criteria2 = new CDbCriteria;
                        $criteria2->condition =  't.status=0 and t.dpid='.$companyId.' and t.stlid='.$stlid.' and t.splid='.$splid
                                .' and t.create_at <="'.date('Y-m-d',time()).' 23:59:59" and t.create_at >= "'.date('Y-m-d',time()).' 00:00:00"' ;
                        $criteria2->order = ' t.lid ';
                        $queue2 = QueuePersons::model()->find($criteria2);
                        if(!empty($queue2))
                        {
                            $queueno=$queue2->queue_no;
                        }
                    }
                }
                $sqlfree='select count(*) as sitenum '
                            . 'from nb_site subt where subt.status not in(1,2,3) and subt.delete_flag=0'
                            . ' and subt.dpid='.$companyId.' and subt.splid='.$splid.' and subt.type_id='.$stlid;
                $connectfree = Yii::app()->db->createCommand($sqlfree);
                $sitefree = $connectfree->queryScalar();
                
                $sqlqueue='select count(qp.lid) as queuepersons'
                            . '  from nb_queue_persons qp where qp.delete_flag=0 and qp.status=0 '
                            . ' and qp.create_at >"'.date('Y-m-d',time()).' 00:00:00"' .' and qp.create_at<"'.date('Y-m-d',time()).' 23:59:59"'
                            . ' and qp.dpid='.$companyId.' and qp.splid='.$splid.' and qp.stlid='.$stlid;
                $connectqueue = Yii::app()->db->createCommand($sqlqueue);
                $queueNum = $connectqueue->queryScalar();
                
                Yii::app()->end(json_encode(array("status"=>true,"callno"=>$queueno,"sitefree"=>$sitefree,"queuenum"=>$queueNum)));
        }
        
        public function actionButton() {
		$sid = Yii::app()->request->getParam('sid','0');
                $status = Yii::app()->request->getParam('status','0');
                $istemp = Yii::app()->request->getParam('istemp','0');
                $typeId = Yii::app()->request->getParam('typeId','0');
                $queueno="";
                if($typeId=="queue")
                {
                    $criteria = new CDbCriteria;
                    $criteria->condition =  't.status=0 and t.dpid='.$this->companyId.' and t.stlid='.$istemp.' and t.splid='.$sid
                            .' and t.create_at <="'.date('Y-m-d',time()).' 23:59:59" and t.create_at >= "'.date('Y-m-d',time()).' 00:00:00"' ;
                    $criteria->order = ' t.lid ';
                    $queue = QueuePersons::model()->find($criteria);
                    //var_dump($criteria);exit;
                    if(!empty($queue))
                    {
                        $queueno=$queue->queue_no;
                    }
                }else{
                    $criteria2 = new CDbCriteria;
                    $criteria2->condition =  't.status in ("1","2","3") and t.dpid='.$this->companyId.' and t.site_id='.$sid.' and t.is_temp='.$istemp ;
                    $criteria2->order = ' t.lid desc ';
                    $siteNo = SiteNo::model()->find($criteria2);
                    if(empty($siteNo))
                    {
                        $status="0";
                    }else{
                        $status=$siteNo->status;
                    }
                }
                $model=array();
                //var_dump($status);exit;
		$this->renderPartial('button' , array(
				'model' => $model,
				'sid' => $sid,
                                'status' => $status,                                
                                'istemp' => $istemp,
                                'typeId' => $typeId,
                                'nexpersons'=>$queueno
		));
	}
        
        public function actionOpensite() {
		if(Yii::app()->request->isPostRequest) {
                    
			$sid = Yii::app()->request->getPost('sid');
                        $siteNumber = Yii::app()->request->getPost('siteNumber');
                        $companyId = Yii::app()->request->getPost('companyId');
                        $padId = Yii::app()->request->getPost('padId',"0000000000");
                        if(!Until::validOperateJson($companyId, $this))
                        {
                            echo json_encode(array('status'=>0,'message'=>yii::t('app','云端不能操作本地数据'),'siteid'=>$sid));
                            return true;
                        }
                        //$sid = Yii::app()->request->getPost('sid');
                        $istemp = Yii::app()->request->getPost('istemp','0');
                        
                        $ret=SiteClass::openSite($companyId,$siteNumber,$istemp,$sid);

                        Yii::app()->end(json_encode($ret));
                        //return true;
		}
	}
        
        public function actionOpensiteprint() {
		if(Yii::app()->request->isPostRequest) {
                    
			$sid = Yii::app()->request->getPost('sid');
                        $siteNumber = Yii::app()->request->getPost('siteNumber');
                        $companyId = Yii::app()->request->getPost('companyId');
                        $padId = Yii::app()->request->getPost('padId',"0000000000");
                        if(!Until::validOperateJson($companyId, $this))
                        {
                            $ret= json_encode(array('status'=>0,'msg'=>yii::t('app','云端不能操作本地数据'),'siteid'=>$sid));
                            Yii::app()->end($ret);
                        }
                        //$sid = Yii::app()->request->getPost('sid');
                        $istemp = Yii::app()->request->getPost('istemp','0');
                        
                        $ret=SiteClass::openSite($companyId,$siteNumber,$istemp,$sid);
                        
                            
                        if($ret["status"]==1)
                        {
                            $siteno;
                            $site=new Site();
                            $siteid=$ret['siteid'];
                            $criteria = new CDbCriteria;
                            $criteria->condition =  't.dpid='.$companyId.' and t.site_id='.$siteid.' and t.is_temp='.$istemp ;
                            $criteria->order = ' t.lid desc ';                    
                            $siteno = SiteNo::model()->find($criteria);
                            //Yii::app()->end(json_encode(array('status'=>0,'msg'=>"222")));
                            //order site 和 siteno都需要更新状态 所以要取出来
                            if($istemp=="0")
                            {
                                $criteria2 = new CDbCriteria;
                                $criteria2->condition =  't.dpid='.$companyId.' and t.lid='.$siteid ;
                                $criteria2->order = ' t.lid desc ';                    
                                $site = Site::model()->with("siteType")->find($criteria2);
                            }
                            
                            $pad=Pad::model()->find(' dpid=:dpid and lid=:lid',array(':dpid'=>$companyId,'lid'=>$padId));
                            if(!empty($pad))
                            {
                                //$precode="1B70001EFF00";//开钱箱
                                $precode="";
                                $printserver="1";
                                $memo="请等待叫号！";
                                
                                $ret=Helper::printSite($siteno,$site,$pad,$precode,$printserver,$memo);
                            }else{
                                $ret = array('status'=>0,'msg'=>yii::t('app','没有找到PAD'),'siteid'=>$siteid);
                            }                            
                        }
                        Yii::app()->end(json_encode($ret));                        
		}
	}
        
        public function actionClosesite() {
		if(Yii::app()->request->isPostRequest) {
			$sid = Yii::app()->request->getPost('sid');
                        $companyId = Yii::app()->request->getPost('companyId');
                        $istemp = Yii::app()->request->getPost('istemp','0');
                        Until::validOperate($companyId, $this);
                        $db = Yii::app()->db;
                        $transaction = $db->beginTransaction();
                        try {  
                            if($istemp=="0")
                            {
                                $sqlsite="update nb_site set status='7' where lid=:sid and dpid=:companyId";
                                $commandsite=$db->createCommand($sqlsite);
                                $commandsite->bindValue(":sid" , $sid);
                                $commandsite->bindValue(":companyId" , $companyId);
                                $commandsite->execute();
                            }

                            $sqlsiteno="update nb_site_no set status='7' where site_id=:sid and is_temp=:istemp and dpid=:companyId and status in ('1','2')";
                            $commandsiteno=$db->createCommand($sqlsiteno);
                            $commandsiteno->bindValue(":sid" , $sid);
                            $commandsiteno->bindValue(":istemp" , $istemp);
                            $commandsiteno->bindValue(":companyId" , $companyId);
                            $commandsiteno->execute();
                            
                            $sqlorder="update nb_order set order_status='7' where site_id=:sid and is_temp=:istemp and dpid=:companyId and order_status in ('1','2')";
                            $commandorder=$db->createCommand($sqlorder);
                            $commandorder->bindValue(":sid" , $sid);
                            $commandorder->bindValue(":istemp" , $istemp);
                            $commandorder->bindValue(":companyId" , $companyId);
                            $commandorder->execute();
                            
                            $sqlfeedback = "update nb_order_feedback set is_deal='1' where dpid=:companyId and site_id=:siteId and is_temp=:istemp";
                            $commandfeedback = $db->createCommand($sqlfeedback);
                            $commandfeedback->bindValue(":companyId",$companyId);
                            $commandfeedback->bindValue(":siteId",$sid);
                            $commandfeedback->bindValue(":istemp",$istemp);
                            //var_dump($sqlsite);exit;
                            $commandfeedback->execute();
                            
                            //FeedBackClass::cancelAllOrderMsg($sid,$istemp,"0000000000",$companyId);
                            
                            $transaction->commit(); //提交事务会真正的执行数据库操作
                            //
                            $criteria = new CDbCriteria;
                            $criteria->condition =  't.dpid='.$companyId.' and t.site_id='.$sid.' and t.is_temp='.$istemp ;
                            $criteria->order = ' t.lid desc ';
                            $siteNo = SiteNo::model()->find($criteria);
                            SiteClass::deleteCode($siteNo->dpid,$siteNo->code);
                            //var_dump($sid);exit;
                            
                            //apc_delete($siteNo->dpid.$siteNo->code);
                            echo json_encode(array('status'=>1,'message'=>yii::t('app','撤台成功')));  
                            return true;
                    } catch (Exception $e) {
                            $transaction->rollback(); //如果操作失败, 数据回滚
                            echo json_encode(array('status'=>0,'message'=>yii::t('app','撤台失败')));
                            return false;
                    }
		}
	}
        
        public function actionSwitchsite() {
		if(Yii::app()->request->isPostRequest) {
			$sid = Yii::app()->request->getPost('sid');
                        $companyId = Yii::app()->request->getPost('companyId');
                        $istemp = Yii::app()->request->getPost('istemp','0');
                        $ssid = Yii::app()->request->getPost('ssid',0);
                        $sistemp = Yii::app()->request->getPost('sistemp','0');
                        Until::validOperate($companyId, $this);
                        //echo json_encode(array('status'=>0,'message'=>$sid.'dd'.$companyId.'dd'.$istemp.'dd'.$ssid.'dd'.$sistemp));exit;
                        $db = Yii::app()->db;
                        $transaction = $db->beginTransaction();
                        try {
                            $number=0;
                            $status='1';
                            
                            $smodelsn = SiteNo::model()->find('dpid=:companyId and delete_flag=0 and site_id=:lid and is_temp=:istemp and status in ("1","2","3")' , array(':companyId' => $companyId,':lid'=>$ssid,':istemp'=>$sistemp)) ;
                            
                            if($sistemp=='0')
                            {
                                $smodel = Site::model()->find('dpid=:companyId and delete_flag=0 and lid=:lid' , array(':companyId' => $companyId,':lid'=>$ssid)) ;
                                $number=$smodel->number;
                                $status=$smodel->status;
                            }else{
                                $number=$smodelsn->number;
                                $status=$smodelsn->status;
                            }
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
                            if($istemp=="0")
                            {
                                $sqlsite="update nb_site set status=:status,number=:number where lid=:sid and dpid=:companyId";
                                $commandsite=$db->createCommand($sqlsite);
                                $commandsite->bindValue(":number" , $number);
                                $commandsite->bindValue(":status" , $status);
                                $commandsite->bindValue(":sid" , $sid);
                                $commandsite->bindValue(":companyId" , $companyId);
                                $commandsite->execute();
                            }
                            if($sistemp=="0")
                            {
                                $sqlsite="update nb_site set status='6' where lid=:sid and dpid=:companyId";
                                $commandsite=$db->createCommand($sqlsite);
                                $commandsite->bindValue(":sid" , $ssid);
                                $commandsite->bindValue(":companyId" , $companyId);
                                $commandsite->execute();
                            }
                            $se=new Sequence("site_no");
                            $lid = $se->nextval();
                            $data = array(
                                'lid'=>$lid,
                                'dpid'=>$companyId,
                                'create_at'=>date('Y-m-d H:i:s',time()),
                                'update_at'=>date('Y-m-d H:i:s',time()),
                                'is_temp'=>$istemp,
                                'site_id'=>$sid,
                                'status'=>$status,
                                'code'=>$smodelsn->code,
                                'number'=>$smodelsn->number,
                                'delete_flag'=>'0'
                            );
                            $db->createCommand()->insert('nb_site_no',$data);
                            
                            $smodelsn->status='6';
                            $smodelsn->save();
                            
                            $sqlorder="update nb_order set is_temp=:istemp,site_id=:sid where site_id=:ssid and is_temp=:sistemp and dpid=:companyId and order_status in ('1','2','3')";
                            $commandorder=$db->createCommand($sqlorder);
                            $commandorder->bindValue(":sid" , $sid);
                            $commandorder->bindValue(":istemp" , $istemp);
                            $commandorder->bindValue(":ssid" , $ssid);
                            $commandorder->bindValue(":sistemp" , $sistemp);
                            $commandorder->bindValue(":companyId" , $companyId);
                            $commandorder->execute();                                                 
                            
                            $transaction->commit(); //提交事务会真正的执行数据库操作
                            echo json_encode(array('status'=>1,'message'=>yii::t('app','换台成功')));  
                            return true;
                    } catch (Exception $e) {
                            $transaction->rollback(); //如果操作失败, 数据回滚
                            echo json_encode(array('status'=>0,'message'=>yii::t('app','换台失败')));
                            return false;
                    }
		}                
	}
        
        public function actionUnionsite() {
		if(Yii::app()->request->isPostRequest) {
			$sid = Yii::app()->request->getPost('sid');
                        $companyId = Yii::app()->request->getPost('companyId');
                        $istemp = Yii::app()->request->getPost('istemp','0');
                        $ssid = Yii::app()->request->getPost('ssid',0);
                        $sistemp = Yii::app()->request->getPost('sistemp','0');
                        Until::validOperate($companyId, $this);
                        //echo json_encode(array('status'=>0,'message'=>$sid.'dd'.$companyId.'dd'.$istemp.'dd'.$ssid.'dd'.$sistemp));exit;
                        $db = Yii::app()->db;
                        $transaction = $db->beginTransaction();
                        try {
                            $number=0;
                            $status='1';                            
                            $smodelsn = SiteNo::model()->find('dpid=:companyId and delete_flag=0 and site_id=:lid and is_temp=:istemp and status in ("1","2")' , array(':companyId' => $companyId,':lid'=>$ssid,':istemp'=>$sistemp)) ;
                            
                            if($sistemp=='0')
                            {
                                $smodel = Site::model()->find('dpid=:companyId and delete_flag=0 and lid=:lid' , array(':companyId' => $companyId,':lid'=>$ssid)) ;
                                $number=$smodel->number;
                                $status=$smodel->status;
                            }else{
                                $number=$smodelsn->number;
                                $status=$smodelsn->status;
                            }
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
                            if($istemp=="0")
                            {
                                $sqlsite="update nb_site set status=IF(:sstatus>status,:sstatus,status),number=number+:snumber where lid=:sid and dpid=:companyId";
                                $commandsite=$db->createCommand($sqlsite);
                                $commandsite->bindValue(":snumber" , $number);
                                $commandsite->bindValue(":sstatus" , $status);
                                $commandsite->bindValue(":sid" , $sid);
                                $commandsite->bindValue(":companyId" , $companyId);
                                $commandsite->execute();
                            }
                            if($sistemp=="0")
                            {
                                $sqlsite="update nb_site set status='5' where lid=:sid and dpid=:companyId";
                                $commandsite=$db->createCommand($sqlsite);
                                $commandsite->bindValue(":sid" , $ssid);
                                $commandsite->bindValue(":companyId" , $companyId);
                                $commandsite->execute();
                            }
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
                            //更新目标site_no人数和状态
                            $modelsn=SiteNo::model()->find('dpid=:companyId and delete_flag=0 and site_id=:lid and is_temp=:istemp and status in ("1","2")' , array(':companyId' => $companyId,':lid'=>$sid,':istemp'=>$istemp)) ;
                            if($status > $modelsn->status)
                            {
                                $modelsn->status=$status;
                            }
                            $modelsn->number=$modelsn->number+$number;
                            $modelsn->save();
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
                            //更新源site_no，让上网密码code 指向目标订单
                            $smodelsn->status='5';
                            $smodelsn->site_id=$modelsn->site_id;
                            $smodelsn->is_temp=$modelsn->is_temp;
                            $smodelsn->save();
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
                            //更新目标订单状态和人数
                            $tocriteria = new CDbCriteria;
                            $tocriteria->condition =  ' t.order_status in ("1","2") and  t.dpid='.$companyId.' and t.site_id='.$sid.' and t.is_temp='.$istemp ;
                            $tocriteria->order = ' t.lid desc ';
                            $torder = Order::model()->find($tocriteria);
                            if(empty($torder))
                            {
                                //新生成订单
                                $torder=new Order();
                                $se=new Sequence("order");
                                $torder->lid = $se->nextval();
                                $torder->dpid=$companyId;
                                $torder->username=Yii::app()->user->name;
                                $torder->create_at = date('Y-m-d H:i:s',time());
                                $torder->lock_status = '0';
                                $torder->site_id = $sid;
                                $torder->is_temp = $istemp;
                                $torder->order_status=$status;
                                $torder->number=$modelsn->number+$number;
                                $torder->save();
                            }else{
                                if($status > $torder->order_status)
                                {
                                    $torder->order_status=$status;
                                }
                                $torder->number=$torder->number+$number;
                                $torder->save();
                            }
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
                            //...
                            //更新源订单状态
                            $socriteria = new CDbCriteria;
                            $socriteria->condition =  ' t.order_status in ("1","2") and  t.dpid='.$companyId.' and t.site_id='.$ssid.' and t.is_temp='.$sistemp ;
                            $socriteria->order = ' t.lid desc ';
                            $sorder = Order::model()->find($socriteria);
                            if(!empty($sorder))
                            {
                                $sorder->order_status="5";
                                $sorder->save();
                            }
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
                            //...
                            //更新源订单明细，指向目标订单。
                            if(!empty($sorder))
                            {
                                $sqlorder="update nb_order_product set order_id=:torderid where dpid=:companyId and order_id=:sorderid";
                                $commandorder=$db->createCommand($sqlorder);
                                $commandorder->bindValue(":torderid" , $torder->lid);
                                $commandorder->bindValue(":sorderid" , $sorder->lid);
                                $commandorder->bindValue(":companyId" , $companyId);
                                $commandorder->execute();   
                            }
                            //echo json_encode(array('status'=>0,'message'=>$number.'dd'.$status));exit;
//                            $sqlorder="update nb_order set is_temp=:istemp,site_id=:sid where site_id=:ssid and is_temp=:sistemp and dpid=:companyId and order_status in ('1','2','3')";
//                            $commandorder=$db->createCommand($sqlorder);
//                            $commandorder->bindValue(":sid" , $sid);
//                            $commandorder->bindValue(":istemp" , $istemp);
//                            $commandorder->bindValue(":ssid" , $ssid);
//                            $commandorder->bindValue(":sistemp" , $sistemp);
//                            $commandorder->bindValue(":companyId" , $companyId);
//                            $commandorder->execute();
                            $transaction->commit(); //提交事务会真正的执行数据库操作
                            echo json_encode(array('status'=>1,'message'=>yii::t('app','并台成功')));  
                            return true;
                    } catch (Exception $e) {
                            $transaction->rollback(); //如果操作失败, 数据回滚
                            echo json_encode(array('status'=>0,'message'=>yii::t('app','并台失败')));
                            //echo json_encode(array('status'=>0,'message'=>  var_dump($e)));
                            return false;
                    }
		}                
	}
        
}