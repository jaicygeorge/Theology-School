<h3>Add New Application</h3>
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
        $( "#dob" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-30:c'
        });
        $( "#rcvd" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-90:c'
        });
        $( "#dobapt" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-100:c'
        });
    });
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'application-form',
     'enableClientValidation'=>true,
        'clientOptions' => array(
      'validateOnSubmit'=>true,
      'validateOnChange'=>true,
      'validateOnType'=>false),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'))); ?>
<div class="form">
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name', array('value'=>$model->name)); ?>
             <?php echo $form->error($model,'name'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'permenant_address'); ?> 
            <?php echo $form->textArea($model,'permenant_address',array('rows'=>3, 'cols'=>30,"value"=>$model->permenant_address)); ?>   
            <?php echo $form->error($model,'permenant_address'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'temporary_address'); ?>
           <?php echo $form->textArea($model,'temporary_address',array('rows'=>3, 'cols'=>30,"value"=>$model->temporary_address)); ?>   
             <?php echo $form->error($model,'temporary_address'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'dob'); ?> 
            <?php echo $form->textField($model,'dob', array('value'=>$model->dob,"id"=>"dob","readonly"=>"readonly")); ?>
             <?php echo $form->error($model,'dob'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'place_of_birth'); ?> 
            <?php echo $form->textField($model,'place_of_birth', array('value'=>$model->place_of_birth)); ?>
             <?php echo $form->error($model,'place_of_birth'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'mother_tongue'); ?> 
            <?php echo $form->dropDownList($model,'mother_tongue',array(""=>"-Select-","English"=>"English","Hindi"=>"Hindi","Malayalam"=>"Malayalam","Tamil"=>"Tamil","Other"=>"Other"), array('value'=>$model->mother_tongue)); ?>         
            <?php echo $form->error($model,'mother_tongue'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'gender'); ?> 
           <?php echo $form->radioButtonList($model,'gender',array(Application::GENDER_MALE=> 'Male', Application::GENDER_FEMALE => 'Female'),array('labelOptions'=>array('style'=>'display:inline'))); ?>
             <?php echo $form->error($model,'gender'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'email'); ?> 
           <?php echo $form->textField($model,'email', array('value'=>$model->email)); ?>
             <?php echo $form->error($model,'email'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'mobile_phone'); ?> 
            <?php echo $form->textField($model,'mobile_phone', array('value'=>$model->mobile_phone)); ?>
             <?php echo $form->error($model,'mobile_phone'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'occupation'); ?> 
            <?php echo $form->textField($model,'occupation', array('value'=>$model->occupation)); ?>
             <?php echo $form->error($model,'occupation'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'marital_status'); ?> 
            <?php echo $form->dropDownList($model,'marital_status',array(""=>"-Select-","1"=>"Single","2"=>"Married","3"=>"Divorced"), array('value'=>$model->marital_status)); ?>         
             <?php echo $form->error($model,'marital_status'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'church_denomination'); ?> 
            <?php echo $form->textField($model,'church_denomination', array('value'=>$model->church_denomination)); ?>
             <?php echo $form->error($model,'church_denomination'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'church_address'); ?> 
            <?php echo $form->textArea($model,'church_address',array('rows'=>3, 'cols'=>30,"value"=>$model->church_address));?>          
             <?php echo $form->error($model,'church_address'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'received_time'); ?> 
            <?php echo $form->textField($model,'received_time', array('value'=>$model->received_time,"id"=>"rcvd","readonly"=>"readonly")); ?>
             <?php echo $form->error($model,'received_time'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'date_of_baptism'); ?> 
            <?php echo $form->textField($model,'date_of_baptism', array('value'=>$model->date_of_baptism,"id"=>"dobapt","readonly"=>"readonly")); ?>
             <?php echo $form->error($model,'date_of_baptism'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'holyspirit_info'); ?>
            <?php echo $form->radioButtonList($model,'holyspirit_info',array(Application::HOLYSPIRIT_YES=>'Yes',Application::HOLYSPIRIT_NO=>'No'),array('labelOptions'=>array('style'=>'display:inline'))); ?>
            <?php echo $form->error($model,'holyspirit_info'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'educational_documents'); ?> 
            <input type="file"  id="educational_documents" name="educational_documents[]" class="multi" multiple="multiple" accept="gif|jpg|jpeg|doc|docx|xls|xlsx|pdf" maxlength="5" />
             <?php echo $form->error($model,'educational_documents'); ?>
             <?php if($attachments) { ?>
            <br/>
             <?php foreach($attachments as $index=>$attachment) { 
                        if($attachment->type==Attachment::TYPE_DOCUMENT){ ?>                
                    <?php echo $attachment->original_name;?>--<a href="/applications/deleteFile/id/<?php echo $attachment->id;?>/appId/<?php echo $model->id;?>" onclick="return confirm('Are you sure?');">Delete File</a><br/><br/>                
                    <?php } } ?>
             <?php } ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'photo'); ?> 
           <input type="file" id="photo" name="photo"/>
             <?php echo $form->error($model,'photo'); ?>
            <?php if($attachments) { ?>
            <br/>
            <?php foreach($attachments as $index=>$attachment) {                         
                        if($attachment->type==Attachment::TYPE_PHOTO){?>                
                    <img src="/<?php echo Yii::app()->params['ApplicationFilePath'].$attachment->attachment;?>" height="100px" width="100px"/>--<a href="/applications/deleteFile/id/<?php echo $attachment->id;?>/appId/<?php echo $model->id;?>" onclick="return confirm('Are you sure?');">Delete File</a><br/>              
            <?php } } ?>
            <?php } ?>
    </div>
     <div class="row">
            <?php echo $form->labelEx($model,'reson_for_study'); ?> 
          <?php echo $form->textArea($model,'reson_for_study',array('rows'=>3, 'cols'=>30,"value"=>$model->reson_for_study)); ?>   
          <?php echo $form->error($model,'reson_for_study'); ?>
    </div>
     <div class="row">
          <?php if(isset($_GET['id'])) $butLabel = "Update"; else $butLabel = "Add"; ?>
         <?php echo CHtml::submitButton($butLabel ,array('name'=>'addSub')); ?>
    </div>
       
</div>
<?php $this->endWidget(); ?>
