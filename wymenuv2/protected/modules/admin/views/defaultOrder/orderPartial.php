	<!-- BEGIN PAGE -->  
        <ul class="selectProduct" orderid="<?php echo $model->lid; ?>">
            <input type="hidden" value="<?php echo $productDisTotal; ?>" id="productDisTotal">
            <span id="order_status" orderStatus="<?php echo $model->order_status; ?>">
                                        *<?php echo $model->create_at;?></span>
            <li lid="0000000000" class="selectProductA">                                    
                    已付<span id="order_reality_pay"><?php echo $model->reality_total;?></span>元/应付<span id="order_should_pay"><?php echo number_format($total['total'], 2);?></span>元
            </li>
                <?php foreach ($orderProducts as $orderProduct):?>
                                    <li lid="<?php echo $orderProduct['lid'];?>" 
                                        setid="<?php echo $orderProduct['set_id'];?>"
                                        productid="<?php echo $orderProduct['product_id'];?>"
                                        order_status="<?php echo $orderProduct['product_order_status'];?>" 
                                        is_giving="<?php echo $orderProduct['is_giving'];?>" 
                                        is_print="<?php echo $orderProduct['is_print'];?>" 
                                        is_retreat="<?php echo $orderProduct['is_retreat'];?>" 
                                        tasteids="<?php if(!empty($tasteidsOrderProducts[$orderProduct['lid']])){ echo $tasteidsOrderProducts[$orderProduct['lid']];}?>" 
                                        tastememo="<?php echo $orderProduct['taste_memo'];?>" 
                                        class="selectProductA">
                                    <span style="background-color:#005580;" class="special badge" content="">
                                        <?php  echo $orderProduct['is_giving']==1?'赠':'';
                                                echo $orderProduct['is_print']==1?'印':'';
                                                echo $orderProduct['is_retreat']==1?'退':'';
                                                echo $orderProduct['set_id']=='0000000000'?'':'套';
                                                if(!empty($orderProduct['taste_memo']) || !empty($tasteids))
                                                {  echo "味";}
                                        ?></span>
                                    <span style="font-size:20px !important;height:auto;" class="badge"><?php echo $orderProduct['amount'];?></span>
                                    <span class="selectProductPrice" style="color:#976125;display:none"><?php echo number_format($orderProduct['original_price'],2);?></span>
                                    <span class="selectProductDiscount" style="color:#976125;display:none"><?php echo $orderProduct['offprice'];?></span>
                                    <span class="selectProductNowPrice" style="color:#976125"><?php echo number_format($orderProduct['price'],2);?></span>
                                    <span style="position:absolute;" class="selectProductName"><?php echo $orderProduct['product_name'];?></span>
                                    <img class="selectProductDel" style="position: absolute;right:0.3em; width: 3.0em;height: 2.0em;padding:5px 10px 5px 10px;" 
                                         src="<?php echo Yii::app()->request->baseUrl;?>/img/product/icon_cart_m.png">                                   
                                   </li>
                <?php endforeach;?>
        </ul>
        全单设定：
            <?php 
            $ordertastename="";
            $ordertasteid="";
            foreach($allOrderTastes as $taste){$ordertastename.=$taste['name'].' ';$ordertasteid.=$taste['tasteid'].'|';} 
            ?>
            <span id="ordertasteall" tid="<?php echo $ordertasteid; ?>"><?php echo $ordertastename; ?></span>
            <span id="ordertastememoall"><?php echo $model->taste_memo; ?></span>  
            
            <!---------------taste------------------>
            <div id="tastebox" style="display: none">
                <div class="clearfix col-md-12">
                <?php if($tastegroups):?>
                <?php foreach ($tastegroups as $tastegroup):?> 
                    <div class="btn-group" data-toggle="buttons" style="margin: 5px;border: 1px solid red;background: rgb(245,230,230);">
                            <?php 
                            $tastes=TasteClass::gettastes($tastegroup['lid'],$this->companyId);
                            foreach ($tastes as $taste):?> 
                            <label tasteid="<?php echo $taste['lid']; ?>" group="tastegroup_<?php echo $tastegroup['lid']; ?>" class="selectTaste btn btn-default <?php if(in_array($taste['lid'],$orderTastes)) echo 'active'; ?>">
                                <input type="checkbox" class="toggle"> <?php echo $taste['name'];?>
                            </label>
                            <?php endforeach;?> 
                   </div>
                <?php endforeach;?> 
                <?php endif;?>                                                            
                </div>                                             
                <div class="form-group">                                                            
                    <div class="col-md-12">
                        <textarea class="form-control" id="taste_memo_edit" placeholder="<?php echo yii::t('app','请输入其他口味要求');?>" id="Order_remark"><?php echo $tasteMemo; ?></textarea>                                                                                                                                                   
                    </div>
                </div>
                <div style="margin: 1.0em; text-align: center;">
                    <input type="button" class="btn green-stripe" id="alltaste_ok" value="<?php echo yii::t('app','确定');?>">
                    <input type="button" class="btn green-stripe" id="alltaste_cancel" value="<?php echo yii::t('app','取消');?>">
                </div>
            </div>
        	<!-- END PAGE -->                  
                    <script type="text/javascript">
                        var syscallid='<?php echo $syscallId; ?>';
                        var sysautoaccount='<?php echo $autoaccount; ?>';
                        //alert(sysautoaccount);
                        var scanon=false;
                        $(document).ready(function () {
                            $('body').addClass('page-sidebar-closed');
                            $('#site_list_button').val("<?php echo $total['remark'] ;?>(<?php switch($model->order_status) {case 1:{echo yii::t('app','未下单');break;} case 2:{echo yii::t('app','下单未支付');break;} case 3:{echo yii::t('app','已支付');break;} }?>)");
                            var orderstatus="<?php echo $model->order_status; ?>";
                            $("#btnswitchsite").hide();
                            $("#btnunionsite").hide();
                            $("#btnclosesite").hide();
                            if(orderstatus=="1"){
                                $("#btnswitchsite").show();
                                $("#btnunionsite").show();
                                $("#btnclosesite").show();
                            }else if(orderstatus=="2"){
                                $("#btnswitchsite").show();
                                $("#btnunionsite").show();
                            }else if(orderstatus=="3"){
                                $("#btnswitchsite").show();
                            }
                            if(syscallid>"Ca000" && syscallid<"Ca999")
                            {
                                accountmanul();
                            }
                            if(sysautoaccount=="1")
                            {
                                accountmanul();
                            }
                            $('#callbarscanid').focus();
                        });
                        
                        $('#alltaste_ok').on(event_clicktouchstart,function(){
                            var tids="";
                            var tnames="";
                            $(".selectTaste").each(function(){
                                if($(this).hasClass("active"))
                                {
                                    tids+=$(this).attr("tasteid")+"|"
                                    tnames+=$(this).text()+"/";
                                }
                            });
                            //alert(tnames);
                            $("#ordertasteall").attr("tid",tids);
                            $("#ordertasteall").text(tnames);
                            //alert($("#taste_memo_edit").val());
                            $("#ordertastememoall").text($("#taste_memo_edit").val());
                            layer.close(layer_index3);
                        });
                        
                        $('#alltaste_cancel').on(event_clicktouchstart,function(){
                            layer.close(layer_index3);
                            layer_index3=0;
                        });
                        
                        function accountmanul(){
                            var pad_id="0000000000";
                            if (typeof Androidwymenuprinter == "undefined") {
                                alert("<?php echo yii::t('app','无法获取PAD设备信息，请在PAD中运行该程序！');?>");
                                //return false;
                            }else{
                                var padinfo=Androidwymenuprinter.getPadInfo();
                                pad_id=padinfo.substr(10,10);
                            }
                            var loadurl='<?php echo $this->createUrl('defaultOrder/accountManul',array('companyId'=>$this->companyId,'typeId'=>$typeId,'orderId'=>$model->lid,'total'=>$total['total']));?>/padId/'+pad_id;
                            
                            var callid= $('#callbarscanid').val();
                            if(callid>"Ca000" && callid<"Ca999")
                            {
                                loadurl=loadurl+'/callId/'+callid;
                            }
                            //alert(loadurl);
                            //var $modalconfig = $('#portlet-config');
                            var $modalconfig = $('#modal-wide');
                                $modalconfig.find('.modal-content')
                                        .load(loadurl
                                            , ''
                                            , function(){
                                                $modalconfig.modal();
                                });
                        }
                        
                        function openaccount(payback){
                            var pad_id="0000000000";
                            if (typeof Androidwymenuprinter == "undefined") {
                                alert("<?php echo yii::t('app','无法获取PAD设备信息，请在PAD中运行该程序！');?>");
                                //return false;
                            }else{
                                var padinfo=Androidwymenuprinter.getPadInfo();
                                pad_id=padinfo.substr(10,10);
                            }
                            var loadurl='<?php echo $this->createUrl('defaultOrder/account',array('companyId'=>$this->companyId,'typeId'=>$typeId,'orderId'=>$model->lid,'total'=>$total['total']));?>/padId/'+pad_id;
                            if(payback==1)
                            {
                                loadurl=loadurl+'/payback/1'
                            }
                            var callid= $('#callbarscanid').val();
                            if(callid>"Ca000" && callid<"Ca999")
                            {
                                loadurl=loadurl+'/callId/'+callid;
                            }
                            //alert(loadurl);
                            var $modalconfig = $('#modal-wide');
                                $modalconfig.find('.modal-content')
                                        .load(loadurl
                                            , ''
                                            , function(){
                                                $modalconfig.modal();
                                });
                        }
                        
                        $('#btn_account').on(event_clicktouchstart,function(){
                                 //openaccount('0');
                                 accountmanul();
                        });
                        $('#btn_payback').on(event_clicktouchstart,function(){
                            //alert(0);
                                 openaccount('1');
                        });
                        /*
                        $('#btn_pay').click(function(){
                                var $modalconfig = $('#portlet-config');
                                $modalconfig.find('.modal-content').load('<?php echo $this->createUrl('defaultOrder/pay',array('companyId'=>$this->companyId,'typeId'=>$typeId,'orderId'=>$model->lid,'total'=>$total['total']));?>', '', function(){
                                            $modalconfig.modal();
                                          }); 
                        });
                        */
                        $('#print-btn').on(event_clicktouchstart,function(){
                            var pad_id="0000000000";
                            if (typeof Androidwymenuprinter == "undefined") {
                                alert("<?php echo yii::t('app','无法获取PAD设备信息，请在PAD中运行该程序！');?>");
                                //return false;
                            }else{
                                var padinfo=Androidwymenuprinter.getPadInfo();
                                pad_id=padinfo.substr(10,10);
                            }
                            //var pad_id="0000000016";
                            var $modal=$('#portlet-config');
                            $modal.find('.modal-content').load('<?php echo $this->createUrl('defaultOrder/printList',array('companyId'=>$this->companyId));?>/orderId/'+"<?php echo $model->lid; ?>"+'/typeId/'+"<?php echo $typeId; ?>"+'/padId/'+pad_id
                                    ,'', function(){
                                                $modal.modal();
                                        });
                            /*
                            $.get('<?php echo $this->createUrl('defaultOrder/printList',array('companyId'=>$this->companyId,'orderId'=>$model->lid));?>/padId/'+pad_id,function(data){
                                    if(data.status) {
                                        if(data.type='local')
                                        {
                                            if(Androidwymenuprinter.printJob(company_id,data.jobid))
                                            {
                                                alert("<?php echo yii::t('app','打印成功');?>");
                                            }
                                            else
                                            {
                                                alert("<?php echo yii::t('app','PAD打印失败！，请确认打印机连接好后再试！');?>");                                                                        
                                            }
                                        }else{
                                            var $modal=$('#portlet-config');
                                            $modal.find('.modal-content').load('<?php echo $this->createUrl('defaultOrder/printListNet',array('companyId'=>$this->companyId));?>/orderId/'+"<?php echo $model->lid; ?>"+'/typeId/'+"<?php echo $typeId; ?>"
                                                    ,'', function(){
                                                                $modal.modal();
                                                        });
                                        }
                                    } else {
                                            alert(data.msg);
                                    }
                            },'json');*/
                        });
                        
                        function printKiten(callid){
                            var $modalloading = $('#portlet-print-loading');                                
                           $modalloading.find('.modal-content').load('<?php echo $this->createUrl('defaultOrder/printKitchen',array('companyId'=>$this->companyId,'typeId'=>$typeId,'orderId'=>$model->lid));?>/callId/'+callid, '', function(){
                                $modalloading.modal();
                            });
                        }
                        
                        function printKitenAll(callid){
                            var $modalloading = $('#portlet-print-loading');                                
                           $modalloading.find('.modal-content').load('<?php echo $this->createUrl('defaultOrder/printKitchenAll',array('companyId'=>$this->companyId,'typeId'=>$typeId,'orderId'=>$model->lid));?>/callId/'+callid, '', function(){
                                $modalloading.modal();
                            });
                        }
                        
                        $('#kitchen-btn').on(event_clicktouchstart,function(){
                            var statu = confirm("<?php echo yii::t('app','下单，并厨打，确定吗？');?>");
                                if(!statu){
                                    return false;
                                }
                             //由于打印机不能连续厨打，
                            //printKiten('0');       
                            //采用以下函数
                            printKitenAll('0'); 
                        });
                        
                        $('#alltaste-btn').on(event_clicktouchstart,function(){
                                var $modalconfig = $('#portlet-config');
                                $modalconfig.find('.modal-content').load('<?php echo $this->createUrl('defaultOrder/productTaste',array('companyId'=>$this->companyId,'typeId'=>$typeId,'lid'=>$model->lid,'isall'=>'1'));?>', '', function(){
                                            $modalconfig.modal();
                                          }); 
                        });
                        
                        $('#callbarscanid').keyup(function(){
                            if($(this).val().length==5 && scanon==false)
                            {
                                scanon=true;
                                var callid=$(this).val();
                                //alert(callid);
                                if(callid>"Ca000" && callid<"Ca999")
                                {
                                    
                                    if(syscallid!='0')
                                    {
                                        if(syscallid==callid)
                                        {
                                            openaccount('0');
                                        }else{
                                            alert("<?php echo yii::t('app','请再次扫描呼叫器：');?>"+syscallid+"<?php echo yii::t('app','，系统自动结单！');?>");
                                            $('#callbarscanid').val("");
                                            scanon=false;
                                            return false;
                                        }
                                    }else{   
                                        //菜品分单子打印时调用此函数
                                        //printKiten(callid);
                                        //由于打印机问题厨打，暂时用清单，调用以下函数
                                        printKitenAll(callid);
                                    }
                                }else{
                                    alert("<?php echo yii::t('app','呼叫器编码不正确！');?>");
                                    $('#callbarscanid').val("");
                                    scanon=false;
                                    return false;
                                }
                            }
                        });
                        
                        $('.selectTaste').click(function(){
                            var groupid=$(this).attr("group");
                            var lit=$('label.selectTaste[group="'+groupid+'"]');
                            var chk=$(this).hasClass("active");
                            lit.each(function(){
                                $(this).removeClass('active');
                            });
                            if(chk)
                            {
                                return false;
                            }
                       });
                        
                        
                    </script>