<h3>Add New Grade</h3>
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
        'id'=>'grade-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    
    
    <div class="row">
            <?php echo $form->labelEx($model,'grade'); ?> 
            <?php echo $form->textField($model,'grade', array('value'=>$model->grade)); ?>
            <?php echo $form->error($model,'grade'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'percentage_from'); ?> 
            <?php echo $form->textField($model,'percentage_from', array('value'=>$model->percentage_from)); ?>
            <?php echo $form->error($model,'percentage_from'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'percentage_to'); ?> 
            <?php echo $form->textField($model,'percentage_to', array('value'=>$model->percentage_to)); ?>
            <?php echo $form->error($model,'percentage_to'); ?>
    </div>
   
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
          <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
