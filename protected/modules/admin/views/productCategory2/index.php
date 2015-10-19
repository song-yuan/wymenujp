<div class="page-content">
	<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
	<div id="responsive" class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
	<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('head'=>yii::t('app','产品类型管理'),'subhead'=>yii::t('app','产品类型列表'),'breadcrumbs'=>array(array('word'=>yii::t('app','产品类型管理'),'url'=>''))));?>
	
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id' => 'siteType-form',
				'action' => $this->createUrl('productCategory/delete' , array('companyId' => $this->companyId)),
				'errorMessageCssClass' => 'help-block',
				'htmlOptions' => array(
					'class' => 'form-horizontal',
					'enctype' => 'multipart/form-data'
				),
		)); ?>
						<div class="col-md-12">
					<div class="portlet purple box">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-cogs"></i><?php echo yii::t('app','商品类目管理');?></div>
							<div class="actions">
								<a class="btn blue add_btn" parentId="0" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo yii::t('app','添加一级类目');?></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="tree table table-striped table-hover table-bordered dataTable">
									<?php foreach($models as $model):?>
									<tr class="treegrid-<?php echo $model->lid?> <?php if($model->parent_id!='0') echo 'treegrid-parent-'.$model->parent_id;?>">
										<td width="70%"><?php echo $model->category_name;?></td>
										<td>
                                                                                <?php if($model->parent_id=='0'):?>
										<a class="btn btn-xs green add_btn" parentId="<?php echo $model->lid;?>" data-toggle="modal"><i class="fa fa-plus"></i></a>
										<?php endif;?>
                                                                                <a class="btn btn-xs blue edit_btn" id="<?php echo $model->lid;?>" data-toggle="modal"><i class="fa fa-edit"></i></a>
										<a cid="<?php echo $model->lid;?>" class="btn btn-xs red btn_delete"><i class="fa fa-times"></i></a>										
										</td>
									</tr>
									<?php endforeach;?>
								</table>
				            </div>
						</div>
					</div>
				</div>
	
		<?php $this->endWidget(); ?>
	
	<!-- END PAGE CONTENT-->
	<script type="text/javascript">
    $(document).ready(function() {
        $('.tree').treegrid({'initialState':'collapsed'});
        <?php foreach($expandNode as $node):?>
        $('.treegrid-<?php echo $node;?>').treegrid('expand');
        <?php endforeach;?>
	});
    var $modal = $('.modal');
    $('.add_btn').on('click', function(){
    	parentId = $(this).attr('parentId');
        $modal.find('.modal-content').load('<?php echo $this->createUrl('productCategory/create',array('companyId'=>$this->companyId));?>/parentId/'+parentId, '', function(){
          $modal.modal();
        });
    });
    $('.edit_btn').on('click', function(){
    	id = $(this).attr('id');
        $modal.find('.modal-content').load('<?php echo $this->createUrl('productCategory/update',array('companyId'=>$this->companyId));?>/id/'+id, '', function(){
          $modal.modal();
        });
    });
    $('.btn_delete').click(function(){
    	var cid = $(this).attr('cid');
        msg ="<?php echo yii::t('app','你确定要删除该类目吗?');?>";
        if($(this).parent().parent().hasClass('treegrid-collapsed') || $(this).parent().parent().hasClass('treegrid-expanded')){
        	msg += '<br/>该类目的子类目将会一起被删除！';
        }
        bootbox.confirm(msg, function(result) {
           if(result){
               location.href="<?php echo $this->createUrl('productCategory/delete',array('companyId'=>$this->companyId));?>/id/"+cid;
           }
        }); 
    });
	</script>