	<!-- BEGIN HEADER -->   
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="header-inner">
			<!-- BEGIN LOGO -->  
			<a class="navbar-brand" href="<?php echo $this->createUrl('default/index',array("companyId"=>$this->companyId));?>">
			<span style="margin-left:20px;"><?php echo yii::t('app','我要MENU')?></span>
			</a>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER --> 
			<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<img src="<?php echo Yii::app()->request->baseUrl;?>/img/menu-toggler.png" alt="" />
			</a> 
			<!-- END RESPONSIVE MENU TOGGLER -->
                        
			<!-- BEGIN TOP NAVIGATION MENU -->
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
				<li class="dropdown" id="header_notification_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="notification_banner_id"
						data-close-others="true">
					<i class="fa fa-warning"></i>
					<span class="badge" id="allnotificationnum">0</span>
					</a>
                                    <ul class="dropdown-menu extended notification" style="max-width: 800px !important; width:600px !important;">
						<li>
							<p><?php echo yii::t('app','未读消息,点击消除消息');?></p>
						</li>
						<li>
							<ul id="header_notification_list" class="dropdown-menu-list scroller" style="height: 420px;">
                                                                <li>  
									<a href="#">
									<span class="badge">4</span> 
									<?php echo yii::t('app','卡座');?>：A123 
									<span class="time"><?php echo yii::t('app','刚刚');?></span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-success"><i class="fa fa-plus"></i></span>
									New user registered. 
									<span class="time">Just now</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>
									Server #12 overloaded. 
									<span class="time">15 mins</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-warning"><i class="fa fa-bell-o"></i></span>
									Server #2 not responding.
									<span class="time">22 mins</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-info"><i class="fa fa-bullhorn"></i></span>
									Application error.
									<span class="time">40 mins</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>
									Database overloaded 68%. 
									<span class="time">2 hrs</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>
									2 user IP blocked.
									<span class="time">5 hrs</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-warning"><i class="fa fa-bell-o"></i></span>
									Storage Server #4 not responding.
									<span class="time">45 mins</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-info"><i class="fa fa-bullhorn"></i></span>
									System Error.
									<span class="time">55 mins</span>
									</a>
								</li>
								<li>  
									<a href="#">
									<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>
									Database overloaded 68%. 
									<span class="time">2 hrs</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="external">   
							<a href="#"><!-- <i class="m-icon-swapright"></i>--></a>
						</li>
					</ul>
				</li>
				<!-- END NOTIFICATION DROPDOWN -->
				<!-- END TODO DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
                                <li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="<?php echo Yii::app()->request->baseUrl;?>/img/house_small.jpg"/>
					<span class="username"><?php echo Helper::getCompanyName($this->companyId);?></span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
                                                <li><a href="<?php echo $this->createUrl('company/index').'/companyId/'.$this->companyId;?>" data-method='get'><i class="fa fa-key"></i> <?php echo yii::t('app','选择其他店铺');?></a>
						</li>
					</ul>
				</li>
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="<?php echo Yii::app()->request->baseUrl;?>/img/avatar1_small.jpg"/>
                                        <span class="username"><?php echo Yii::app()->user->name; ?></span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:;" id="queueindex"><i class="fa fa-move"></i> <?php echo yii::t('app','排队取号');?></a>
						</li>
						<li>
                                                    <a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i> <?php echo yii::t('app','全屏显示');?></a>
						</li>
                                                <li id="lock_screen">
                                                    <a href="javascript:;" ><i class="fa fa-key"></i> <?php echo yii::t('app','锁定屏幕');?></a>
						</li>
						<li id="shift_logout">
                                                    <a href="<?php echo $this->createUrl('default/shiftlogout',array("companyId"=>$this->companyId));?>" ><i class="fa fa-key"></i> <?php echo yii::t('app','交班退出');?></a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
        <div id="portlet-lockscreen1111" style="margin:10px; display: none;">
                <DIV style="margin:10px;float:left;width:95%;font-size: 1.5em;border:1px solid red;"><?php echo yii::t('app','密码');?><input id="user_input_password" style="width:60%;border:none;" type="password" value="12345"></DIV>
                <div style="text-align:center;">
                    <input type="button" class="btn green" id="lock_screen_close" value="<?php echo yii::t('app','确 定');?>">
                </div>
        </div>
        
	<div class="clearfix"></div>
        <script type="text/javascript">
            var layer_index_lock_screen;
            $(document).ready(function() {
                //alert(typeof Androidwymenuprinter);
                if (typeof Androidwymenuprinter == "undefined") {
                    //alert("click");
                      event_clicktouchstart="click";
                      event_clicktouchend="click";
                }else{
                    //alert("touch");
                    event_clicktouchstart="touchstart";
                    event_clicktouchend="touchend";
                }
                //$('<audio id="chatAudio"><source src="/wymenuv2/admin/audio/notify.ogg" type="audio/ogg"><source src="/wymenuv2/admin/audio/notify.mp3" type="audio/mpeg"><source src="/wymenuv2/admin/audio/notify.wav" type="audio/wav"></audio>').appendTo('body');
                getnotificationnum();
                //$('#header_notification_list').load('<?php echo $this->createUrl('default/messageliall',array('companyId'=>$this->companyId));?>'); 
                
                ////////interval = setInterval(getnotificationnum,"15000");
            });            
            
            $('#notification_banner_id').on(event_clicktouchstart, function(){
                //client_open_site("dd");
                getnotificationnum();
                $('#header_notification_list').load('<?php echo $this->createUrl('default/messageliall',array('companyId'=>$this->companyId));?>'); 
            });
            
            $('#lock_screen_close').on(event_clicktouchstart, function(){
                var password=$("#user_input_password").val();
                //alert(password);
                $.get('<?php echo $this->createUrl(
                    'login/unlock',array('companyId'=>$this->companyId));?>/password/'+password,
                    function(data){
                        //alert(data.msg);
                        if(data.status)
                        {                           
                            layer.close(layer_index_lock_screen);
                        }else{
                            alert("密码错误");
                            //$('#card_pay_input_password').clear();
                        }
                    },'json');                
            });
            
            $('#lock_screen').on(event_clicktouchstart, function(){
//                var $modal=$('#portlet-lockscreen');
//                $modal.modal();
                //自定页
                layer_index_lock_screen=layer.open({
                    type: 1,
                    title:"<?php echo Yii::app()->user->name; ?>锁定屏幕",
                    skin: 'layui-layer-demo', //样式类名
                    closeBtn: false, //不显示关闭按钮
                    shift: 2,
                    shadeClose: false, //开启遮罩关闭
                    content: $('#portlet-lockscreen1111')
                });
            });
            
            function getnotificationnum(){
                $.get('<?php echo $this->createUrl('default/msgnum',array('companyId'=>$this->companyId));?>',function(data){
                if(data.status) {
                      document.getElementById('allnotificationnum').innerHTML = data.num;
                      if(data.num>0)
                      {
                           // $('#chatAudio')[0].play();
                           if (typeof Androidwymenuprinter == "undefined") {
                                //alert("<?php echo yii::t('app','无法获取PAD设备信息，请在PAD中运行该程序！');?>");
                            }else{
                                Androidwymenuprinter.padAlarm();
                            }
                      }
                    } 
                },'json');
            }
            //clearTimeout(interval); 
            
            //前台开台 company_id:xx,site_id:xx,is_temp:xx;
            //消息提示
            //如果在餐桌界面，对应的餐桌状态改变
            function client_open_site(do_data){
                var data = eval('(' + do_data + ')');
                if(data.company_id!="<?php echo $this->companyId; ?>")
                {
                    return false;
                }
                var lit=$('li.modalaction[sid="'+data.site_id+'"][istemp="'+data.is_temp+'"]');
                if(typeof lit.attr("status")!="undefined")
                {
                    lit.attr("status","1");
                    lit.removeClass("bg-blue");
                    lit.removeClass("bg-green");
                    lit.addClass("bg-yellow");
                }
                getnotificationnum();
            }
            
            //前台下单 company_id:xx,site_id:xx,is_temp:xx;
            //消息提醒
            //打印机自动出单1份，客人确认无误后扫描、下单、厨打。
            //如果停留在座位页面，对应座位状态变化
            function client_order(do_data){
                var data = eval('(' + do_data + ')');
                if(data.company_id!="<?php echo $this->companyId; ?>")
                {
                    return false;
                }
                var lit=$('li.modalaction[sid="'+data.site_id+'"][istemp="'+data.is_temp+'"]');
                if(typeof lit.attr("status")!="undefined")
                {
                    lit.attr("status","2");
                    lit.removeClass("bg-yellow");
                    lit.removeClass("bg-green");
                    lit.addClass("bg-blue");
                }
                getnotificationnum();
            }
            
            $('#queueindex').click(function(){
                //var stlid=$(this).attr('lid');
                var randtime=new Date().getTime()+""+Math.round(Math.random()*100);
                var url='<?php echo $this->createUrl('queue/index',array("companyId"=>$this->companyId)); ?>'+'/rand/'+randtime;
                location.href=url;
            });
	</script>