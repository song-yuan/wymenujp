							<?php $form=$this->beginWidget('CActiveForm', array(
									'id' => 'feedback-form',
									'errorMessageCssClass' => 'help-block',
									'htmlOptions' => array(
										'class' => 'form-horizontal',
										'enctype' => 'multipart/form-data'
									),
							)); ?>
								<div class="form-body">
									<div class="form-group">
										<?php echo $form->label($model, 'name',array('class' => 'col-md-3 control-label'));?>
										<div class="col-md-4">
											<?php echo $form->textField($model, 'name',array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('name')));?>
											<?php echo $form->error($model, 'name' )?>
										</div>
									</div>
                                                                        <div class="form-group">
										<?php echo $form->label($model, 'tip',array('class' => 'col-md-3 control-label'));?>
										<div class="col-md-4">
											<?php echo $form->textField($model, 'tip',array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('tip')));?>
											<?php echo $form->error($model, 'tip' )?>
										</div>
									</div>
									<div class="form-actions fluid">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn blue"><?php echo yii::t('app','确定');?></button>
											<a href="<?php echo $this->createUrl('feedback/index' , array('companyId' => $model->dpid,'allflag'=>$allflag));?>" class="btn default"><?php echo yii::t('app','返回');?></a>                              
										</div>
									</div>
							<?php $this->endWidget(); ?>