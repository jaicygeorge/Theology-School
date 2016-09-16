<h3>Add New Course Year Semester</h3>
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
        'id'=>'course-year-semester-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    
    
    <div class="row">
       <h4><strong><?php echo CourseYear::getCourseName($_GET['courseYearId']);?> - <?php echo CourseYear::getCourseYearName($_GET['courseYearId']);?> </strong></h4>
    </div>
    
      
    <div class="row">
            <?php echo $form->labelEx($model,'semester_id'); ?> 
            <?php echo $form->dropDownList($model,'semester_id[]',$semesterList, array('value'=>'','multiple'=>true,'style'=>'width:200px;height:200px;','size'=>'10')); ?>
            <?php echo $form->error($model,'semester_id'); ?>
    </div>
   
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
         <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
