<h3>Add New Exam</h3>
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
        'id'=>'exam-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
<!--    
    
    <div class="row">
            <?php echo $form->labelEx($model,'name'); ?> 
            <?php echo $form->textField($model,'name', array('value'=>$model->name)); ?>
             <?php echo $form->error($model,'name'); ?>
    </div>-->
    <div class="row">
            <?php echo $form->labelEx($model,'course_year_semester_id'); ?> 
            <?php echo $form->dropDownList($model,'course_year_semester_id',$courseList, array('value'=>'')); ?>
            <?php echo $form->error($model,'course_year_semester_id'); ?>
   </div>
     <div class="row">
            <?php echo $form->labelEx($model,'batch_id'); ?> 
            <?php echo $form->dropDownList($model,'batch_id',$batchList, array('value'=>'')); ?>
            <?php echo $form->error($model,'batch_id'); ?>
   </div>
   
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
         <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
