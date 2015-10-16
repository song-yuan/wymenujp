<div class="page-content">
	<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
	<div class="modal fade" id="portlet-pad-bind" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Modal title</h4>
				</div>
				<div class="modal-body">
					Widget settings form goes here
				</div>
				<div class="modal-footer">
					<button type="button" class="btn blue">Save changes</button>
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
	<!-- BEGIN PAGE HEADER-->
	<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('head'=>yii::t('app','PAD管理'),'subhead'=>yii::t('app','PAD列表'),'breadcrumbs'=>array(array('word'=>yii::t('app','PAD管理'),'url'=>''),array('word'=>yii::t('app','PAD列表'),'url'=>''))));?>
	
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
            <?php $form=$this->beginWidget('CActiveForm', array(
				'id' => 'pad-form',
				'action' => $this->createUrl('pad/delete' , array('companyId' => $this->companyId)),
				'errorMessageCssClass' => 'help-block',
				'htmlOptions' => array(
					'class' => 'form-horizontal',
					'enctype' => 'multipart/form-data'
				),
		)); ?>
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-globe"></i><?php echo yii::t('app','PAD列表');?></div>
					<div class="actions">
						<!--<a href="#" class="btn green" id="bindPadId"><i class="fa fa-android"></i> <?php echo yii::t('app','绑定设备识别');?></a>-->
						<a href="<?php echo $this->createUrl('pad/create' , array('companyId' => $this->companyId));?>" class="btn blue"><i class="fa fa-pencil"></i> <?php echo yii::t('app','添加');?></a>
						<!-- <div class="btn-group">
							<a class="btn green" href="#" data-toggle="dropdown">
							<i class="fa fa-cogs"></i> Tools
							<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li><a href="#"><i class="fa fa-ban"></i> <?php echo yii::t('app','删除');?></a></li>
							</ul>
						</div> -->
                                                <div class="btn-group">
							<button type="submit"  class="btn red" ><i class="fa fa-ban"></i> <?php echo yii::t('app','删除');?></button>
						</div>
					</div>
				</div>
				<div class="portlet-body" id="table-manage">
					<table class="table table-striped table-bordered table-hover" id="sample_1">
					<?php if($models):?>
						<thead>
							<tr>
								<th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
								<th><?php echo yii::t('app','PAD名称');?></th>
                                                                <th><?php echo yii::t('app','打印机');?></th>
                                                                <th><?php echo yii::t('app','网络打印机服务器地址');?></th>
                                                                <th><?php echo yii::t('app','类型');?></th>
                                                                <th><?php echo yii::t('app','绑定');?></th>
								<!--<th>IP地址</th>
								<th>串口名称</th>
                                                                <th>波特率</th>-->
                                                                <th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						
						<?php foreach ($models as $model):?>
							<tr class="odd gradeX">
								<td><input type="checkbox" class="checkboxes" value="<?php echo $model->lid;?>" name="ids[]" /></td>
								<td ><?php echo $model->name;?></td>
                                                                <td ><?php if(empty($model->printer)) echo ""; else echo $model->printer->name;?></td>
								<td ><?php echo $model->server_address ;?></td>
                                                                <td ><?php if($model->pad_type=='0') echo yii::t('app','收银台'); elseif($model->pad_type=='1') echo yii::t('app','日本点单pad'); elseif($model->pad_type=='2') echo yii::t('app','中国点单PAD');?></td>
								<td ><?php if($model->is_bind=='0') echo yii::t('app','未绑定'); elseif($model->is_bind=='1') echo yii::t('app','已绑定');?></td>
								<td class="center">
								<a href="<?php echo $this->createUrl('pad/update',array('lid' => $model->lid , 'companyId' => $model->dpid));?>"><?php echo yii::t('app','编辑');?></a>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
						<?php else:?>
						<tr><td><?php echo yii::t('app','还没有添加PAD');?></td></tr>
						<?php endif;?>
					</table>
						<?php if($pages->getItemCount()):?>
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class="dataTables_info">
									<?php echo yii::t('app','共');?> <?php echo $pages->getPageCount();?> <?php echo yii::t('app','页');?>  , <?php echo $pages->getItemCount();?> <?php echo yii::t('app','条数据');?> , <?php echo yii::t('app','当前是第');?> <?php echo $pages->getCurrentPage()+1;?> <?php echo yii::t('app','页');?>
								</div>
							</div>
							<div class="col-md-7 col-sm-12">
								<div class="dataTables_paginate paging_bootstrap">
								<?php $this->widget('CLinkPager', array(
									'pages' => $pages,
									'header'=>'',
									'firstPageLabel' => '<<',
									'lastPageLabel' => '>>',
									'firstPageCssClass' => '',
									'lastPageCssClass' => '',
									'maxButtonCount' => 8,
									'nextPageCssClass' => '',
									'previousPageCssClass' => '',
									'prevPageLabel' => '<',
									'nextPageLabel' => '>',
									'selectedPageCssClass' => 'active',
									'internalPageCssClass' => '',
									'hiddenPageCssClass' => 'disabled',
									'htmlOptions'=>array('class'=>'pagination pull-right')
								));
								?>
								</div>
							</div>
						</div>
						<?php endif;?>					
					
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
            <?php $this->endWidget(); ?>
	</div>
	<!-- END PAGE CONTENT-->
    <script language="JavaScript" type="text/JavaScript">
        $('#bindPadId').click(function(){ 
            var companyId=<?php echo $this->companyId;?>;            
            var padInfo=Androidwymenuprinter.getPadInfo();
            alert(padInfo);
            if(padId=="00000000000000000000")
            {
                alert("<?php echo yii::t('app','设备未绑定！');?>");
            }else{
                $('#portlet-pad-bind').find('.modal-content').load('<?php echo $this->createUrl('pad/bind',array('companyId'=>$this->companyId));?>/padId/'+padId);
                $('#portlet-pad-bind').modal();
            }
        });
    </script>