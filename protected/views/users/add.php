<h3>Add New User</h3>
<?php if(Yii::app()->user->hasFlash('success')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>

<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>


<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'contact-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    
    
    <div class="row">
            <?php echo $form->labelEx($model,'name'); ?> 
            <?php echo $form->textField($model,'name', array('value'=>$model->name)); ?>
             <?php echo $form->error($model,'name'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'roles'); ?> 
            <?php echo $form->dropDownList($model,'roles',$rolesList, array('value'=>'')); ?>
             <?php echo $form->error($model,'roles'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'username'); ?>
           <?php echo $form->textField($model,'username', array('value'=>$model->username)); ?>
             <?php echo $form->error($model,'username'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php if(isset($_GET['id'])) {?>
                <?php echo $form->textField($model,'password', array('value'=>"******")); ?>
            <?php }else{?>
                <?php echo $form->textField($model,'password', array('value'=>$model->password)); ?>
            <?php } ?>
             <?php echo $form->error($model,'password'); ?>
    </div>
     <div class="row">
            <?php echo $form->labelEx($model,'email'); ?> 
           <?php echo $form->textField($model,'email', array('value'=>$model->email)); ?>
             <?php echo $form->error($model,'email'); ?>
    </div>
     <div class="row">
            <?php echo $form->labelEx($model,'phone'); ?> 
           <?php echo $form->textField($model,'phone',array('value'=>$model->phone)); ?>
    </div>
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
         <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
