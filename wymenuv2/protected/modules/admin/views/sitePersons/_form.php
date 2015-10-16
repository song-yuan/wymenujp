							<?php $form=$this->beginWidget('CActiveForm', array(
									'id' => 'siteType-form',
									'errorMessageCssClass' => 'help-block',
									'htmlOptions' => array(
										'class' => 'form-horizontal',
										'enctype' => 'multipart/form-data'
									),
							)); ?>
								<div class="form-body">
								<?php if(!$model->dpid):?>
									<div class="form-group">
										<?php echo $form->label($model, 'dpid',array('class' => 'col-md-3 control-label'));?>
										<div class="col-md-4">
											<?php echo $form->dropDownList($model, 'dpid', array_merge(array('0' => yii::t('app','-- 请选择 --')) , Helper::genCompanyOptions()) ,array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('dpid')));?>
											<?php echo $form->error($model, 'dpid' )?>
										</div>
									</div>
								<?php endif;?>
								 <div class="form-group">
										<?php echo $form->label($model, 'min_persons',array('class' => 'col-md-3 control-label'));?>
										<div class="col-md-4">
											<?php echo $form->textField($model, 'min_persons',array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('min_persons')));?>
											<?php echo $form->error($model, 'min_persons' )?>
										</div>
									</div>
									<div class="form-group">
										<?php echo $form->label($model, 'max_persons',array('class' => 'col-md-3 control-label'));?>
										<div class="col-md-4">
											<?php echo $form->textField($model, 'max_persons',array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('max_persons')));?>
											<?php echo $form->error($model, 'max_persons' )?>
										</div>
									</div>
									<div class="form-actions fluid">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn blue"><?php echo yii::t('app','确定');?></button>
											<a href="<?php echo $this->createUrl('sitePersons/index' , array('companyId' => $model->dpid));?>" class="btn default"><?php echo yii::t('app','返回');?></a>                              
										</div>
									</div>
							<?php $this->endWidget(); ?>