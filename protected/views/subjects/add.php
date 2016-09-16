<h3>Add New Subject</h3>
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
        'id'=>'subject-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    
    
    <div class="row">
            <?php echo $form->labelEx($model,'subject'); ?> 
            <?php echo $form->textField($model,'subject', array('value'=>$model->subject)); ?>
             <?php echo $form->error($model,'subject'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'type'); ?> 
            <?php echo $form->dropDownList($model,'type',array(''=>"-Select-",Subject::TYPE_COLLEGE_SUBJECT=>"College Subject",Subject::TYPE_UNIVERSITY_SUBJECT=>"University Subject"), array('value'=>'')); ?>
             <?php echo $form->error($model,'type'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'total_mark'); ?>
           <?php echo $form->textField($model,'total_mark', array('value'=>$model->total_mark)); ?>
             <?php echo $form->error($model,'total_mark'); ?>
    </div>  
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
         <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
