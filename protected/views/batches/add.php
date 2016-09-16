<h3>Add New Batch</h3>
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

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.MultiFile.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css" />

 <script>
    $(function() {
        $( "#startDate" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-90:c+10'
        });
        $( "#endDate" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-90:c+10'
        });
        
    });
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'batch-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    
    
<!--    <div class="row">
            <?php echo $form->labelEx($model,'name'); ?> 
            <?php echo $form->textField($model,'name', array('value'=>$model->name)); ?>
             <?php echo $form->error($model,'name'); ?>
    </div>-->
    <div class="row">
            <?php echo $form->labelEx($model,'course_id'); ?> 
            <?php echo $form->dropDownList($model,'course_id',$courseList, array('value'=>'')); ?>
            <?php echo $form->error($model,'course_id'); ?>
   </div>
      <div class="row">
            <?php echo $form->labelEx($model,'start_date'); ?> 
            <?php echo $form->textField($model,'start_date', array('value'=>$model->start_date,"id"=>"startDate","readonly"=>"readonly")); ?>
             <?php echo $form->error($model,'start_date'); ?>
    </div>
      <div class="row">
            <?php echo $form->labelEx($model,'end_date'); ?> 
            <?php echo $form->textField($model,'end_date', array('value'=>$model->end_date,"id"=>"endDate","readonly"=>"readonly")); ?>
             <?php echo $form->error($model,'end_date'); ?>
    </div>
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
         <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
