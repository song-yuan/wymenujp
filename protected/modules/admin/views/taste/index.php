<div class="page-content">
	<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
	<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
	<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('head'=>yii::t('app','口味分组管理'),'subhead'=>yii::t('app','口味分组列表'),'breadcrumbs'=>array(array('word'=>yii::t('app','口味分组管理'),'url'=>''))));?>
	
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id' => 'taste-form',
				'action' => $this->createUrl('taste/delete' , array('companyId' => $this->companyId,'type'=>$type)),
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
					<div class="caption"><i class="fa fa-globe"></i><?php if($type) echo yii::t('app','整单口味分组列表');else echo yii::t('app','单品口味分组列表');?></div>
					<div class="actions">
						<a href="<?php echo $this->createUrl('taste/create' , array('companyId' => $this->companyId,'type'=>$type));?>" class="btn blue"><i class="fa fa-pencil"></i> <?php echo yii::t('app','添加');?></a>
                        <a href="javascript:void(0)" class="btn red" onclick="document.getElementById('taste-form').submit();"><i class="fa fa-times"></i> <?php echo yii::t('app','删除');?></a>
					</div>
				</div>
				<div class="portlet-body" id="table-manage">
					<table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
							<tr>
								<th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
								<th><?php echo yii::t('app','口味分组名称');?></th>
								<th><?php echo yii::t('app','添加时间');?></th>
								<th>&nbsp;</th>
                                                                <th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php if($models):?>
						<?php foreach ($models as $model):?>
							<tr class="odd gradeX">
								<td><input type="checkbox" class="checkboxes" value="<?php echo $model->lid;?>" name="lid[]" /></td>
								<td ><?php echo $model->name;?></td>
								<td><?php echo $model->create_at;?></td>
								<td class="center">
								<a href="<?php echo $this->createUrl('taste/update',array('lid' => $model->lid , 'companyId' => $model->dpid,'type'=>$type));?>"><?php echo yii::t('app','编辑');?></a>
								</td>
                                                                <td class="center">
								<a href="<?php echo $this->createUrl('taste/detailIndex',array('groupid' => $model->lid,'groupname'=>$model->name ,'type'=>$type, 'companyId' => $model->dpid));?>"><?php echo yii::t('app','编辑明细');?></a>
								</td>
							</tr>
						<?php endforeach;?>
						<?php endif;?>
						</tbody>
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