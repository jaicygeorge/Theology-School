<h3>Add New Course semester</h3>
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
        'id'=>'course-semester-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    
    
    <div class="row">
        <?php if(empty($courseModel)){?>
            <?php echo $form->labelEx($model,'course_id'); ?> 
            <?php echo $form->dropDownList($model,'course_id',$courseList, array('value'=>'')); ?>
            <?php echo $form->error($model,'course_id'); ?>
        <?php }else { ?>
         <?php echo $form->labelEx($model,'course_id'); ?> 
         <?php echo $courseModel->name;?>
         <?php echo $form->hiddenField($model, 'course_id',array('value'=>$courseModel->id)); ?>
        <?php } ?>
    </div>
    
      
    <div class="row">
            <?php echo $form->labelEx($model,'semester_id'); ?> 
            <?php echo $form->dropDownList($model,'semester_id[]',$semesterList, array('value'=>'','multiple'=>true,'style'=>'width:150px;','size'=>'10')); ?>
            <?php echo $form->error($model,'semester_id'); ?>
    </div>
   
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
         <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
