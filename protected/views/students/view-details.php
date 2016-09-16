<h3>View Student Details</h3>



<?php  if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<div class="form">
    <table border="0" >
        <tr>
            <td width="250" class="label">Name</td>
            <td width="1">:</td>
            <td class="label-details"><?php echo $model->name; ?></td>
        </tr>     
         <tr>
            <td class="label">Email Id</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->email; ?></td>
        </tr>
         <tr>
            <td class="label">Permanent Address</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->permenant_address; ?></td>
        </tr>
        <?php if($model->temporary_address){?>
        <tr>
            <td class="label">Temporary Address</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->temporary_address; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->dob){?>
         <tr>
            <td class="label">Date of Birth</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->dob; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->place_of_birth){?>
         <tr>
            <td class="label">Place of birth</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->place_of_birth; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->mother_tongue){?>
         <tr>
            <td class="label">Mother Tongue</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->mother_tongue; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->gender){?>
         <tr>
            <td class="label">Gender</td>
            <td>:</td>            
            <td class="label-details"><?php if($model->gender==Application::GENDER_MALE) echo "Male";else if($model->gender==Application::GENDER_FEMALE) echo "Female"; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->occupation){?>
         <tr>
            <td class="label">Occupation</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->occupation; ?></td>
        </tr> 
        <?php } ?>
         <?php if($model->marital_status){?>
        <tr>
            <td class="label">Marital Status</td>
            <td>:</td>
            <td class="label-details"><?php if($model->marital_status==1) echo "Single";else if($model->marital_status==2) echo "Married";else if($model->marital_status==3) echo "Divorced"; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->church_denomination){?>
         <tr>
            <td class="label">Church Denomination</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->church_denomination; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->church_address){?>
         <tr>
            <td class="label">Church Address</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->church_address; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->received_time){?>
         <tr>
            <td class="label">Received Time Jesus Christ as Personal Savior</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->received_time; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->date_of_baptism){?>
         <tr>
            <td class="label">Date of water baptism</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->date_of_baptism; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->holyspirit_info){?>
         <tr>
            <td class="label">Filled with Holy Spirit or not?</td>
            <td>:</td>
            <td class="label-details"><?php if($model->holyspirit_info==Application::HOLYSPIRIT_YES) echo "Yes";else if($model->holyspirit_info==Application::HOLYSPIRIT_NO) echo "No"; ?></td>
        </tr>
        <?php } ?>
         <?php if($model->reson_for_study){?>
         <tr>
            <td class="label">Reason to study the word of God</td>
            <td>:</td>
            <td class="label-details"><?php echo $model->reson_for_study; ?></td>
        </tr>
        <?php } ?>
        
        <?php if($attachments) { ?>
            <tr>
                <td class="label">Profile Image</td>
                <td>:</td>
                <td class="label-details">
                    <?php foreach($attachments as $index=>$attachment) {                         
                        if($attachment->type==Attachment::TYPE_PHOTO){?>                
                    <a href="/students/download/file/<?php echo $attachment->id;?>"><img src="/<?php echo Yii::app()->params['ApplicationFilePath'].$attachment->attachment;?>" height="100px" width="100px"/></a><br/>              
                    <?php } } ?>
                </td>
            </tr>
            <tr>
                <td class="label">Educational Documents</td>
                <td>:</td>
                <td class="label-details">
                    <?php foreach($attachments as $index=>$attachment) { 
                        if($attachment->type==Attachment::TYPE_DOCUMENT){ ?>                
                    <a href="/students/download/file/<?php echo $attachment->id;?>"><?php echo $attachment->original_name;?></a><br/><br/>                
                    <?php } } ?>
                </td>
            </tr>
           
        <?php } ?>
       
        
    </table>
    
       
</div>
