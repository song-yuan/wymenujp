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
	<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('head'=>yii::t('app','产品管理'),'subhead'=>yii::t('app','产品列表'),'breadcrumbs'=>array(array('word'=>yii::t('app','产品管理'),'url'=>''))));?>
	
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id' => 'product-form',
				'action' => $this->createUrl('product/delete' , array('companyId' => $this->companyId)),
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
					<div class="caption"><i class="fa fa-globe"></i><?php echo yii::t('app','产品列表');?></div>
					<div class="actions">
						<div class="btn-group">
							<?php echo CHtml::dropDownList('selectCategory', $categoryId, $categories , array('class'=>'form-control'));?>
						</div>
						<a href="<?php echo $this->createUrl('product/create' , array('companyId' => $this->companyId));?>" class="btn blue"><i class="fa fa-pencil"></i> <?php echo yii::t('app','添加');?></a>
						<div class="btn-group">
							<button type="submit"  class="btn red" ><i class="fa fa-ban"></i> <?php echo yii::t('app','删除');?></button>
						</div>
					</div>
				</div>
				<div class="portlet-body" id="table-manage">
					<table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
							<tr>
								<th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
								<th style="width:20%"><?php echo yii::t('app','名称');?></th>
								<th ><?php echo yii::t('app','图片');?></th>
								<th><?php echo yii::t('app','类别');?></th>
								<th><?php echo yii::t('app','现价');?></th>
                                                                <th><?php echo yii::t('app','单位');?></th>
                                                                <th><?php echo yii::t('app','称重');?></th>
                                                                <th><?php echo yii::t('app','重量单位');?></th>                                                                
                                                                <th><?php echo yii::t('app','星级');?></th>
                                                                <th><?php echo yii::t('app','点单数');?></th>
                                                                <th><?php echo yii::t('app','点赞数');?></th>
								<th><?php echo yii::t('app','是否折扣');?></th>
                                                                <th><?php echo yii::t('app','是否配菜');?></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php if($models) :?>
						<?php foreach ($models as $model):?>
							<tr class="odd gradeX">
								<td><input type="checkbox" class="checkboxes" value="<?php echo $model->lid;?>" name="ids[]" /></td>
								<td style="width:20%"><?php echo $model->product_name;?></td>
								<td ><img width="100" src="<?php echo $model->main_picture;?>" /></td>
								<td><?php if(!empty($model->category->category_name)) echo $model->category->category_name;?></td>
								<td ><?php echo $model->original_price;?></td>
                                                                <td ><?php echo $model->product_unit;?></td>
                                                                <td ><?php echo $model->is_weight_confirm=='0'?yii::t('app','否'):yii::t('app','是');?></td>
                                                                <td ><?php echo $model->weight_unit;?></td>
                                                                <td ><?php echo $model->rank;?></td>
                                                                <td ><?php echo $model->order_number;?></td>
                                                                <td ><?php echo $model->favourite_number;?></td>
								<td ><?php echo $model->is_discount=='0'?yii::t('app','否'):yii::t('app','是');?></td>
                                                                <td ><?php echo $model->is_show=='0'?yii::t('app','是'):yii::t('app','否');?></td>
                                                                
								<td class="center">
								<a href="<?php echo $this->createUrl('product/update',array('id' => $model->lid , 'companyId' => $model->dpid));?>"><?php echo yii::t('app','编辑');?></a>
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
									<?php echo yii::t('app','共');?> <?php echo $pages->getPageCount();?> <?php echo yii::t('app','页');?> , <?php echo $pages->getItemCount();?> <?php echo yii::t('app','条数据');?> , <?php echo yii::t('app','当前是第');?> <?php echo $pages->getCurrentPage()+1;?> <?php echo yii::t('app','页');?>
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
	<script type="text/javascript">
	$(document).ready(function(){
		$('#product-form').submit(function(){
			if(!$('.checkboxes:checked').length){
				alert("<?php echo yii::t('app','请选择要删除的项');?>");
				return false;
			}
			return true;
		});
		$('.s-btn').on('switch-change', function () {
			var id = $(this).find('input').attr('pid');
		    $.get('<?php echo $this->createUrl('product/status',array('companyId'=>$this->companyId));?>/id/'+id);
		});
		$('.r-btn').on('switch-change', function () {
			var id = $(this).find('input').attr('pid');
		    $.get('<?php echo $this->createUrl('product/recommend',array('companyId'=>$this->companyId));?>/id/'+id);
		});
		$('#selectCategory').change(function(){
			var cid = $(this).val();
			location.href="<?php echo $this->createUrl('product/index' , array('companyId'=>$this->companyId));?>/cid/"+cid;
		});
	});
	</script>	