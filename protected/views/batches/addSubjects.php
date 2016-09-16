<h3> Add/Edit All Subjects </h3>
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
<hr>
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
 <script type="text/javascript">

    function changeBatchSubject(courseYearId,semesterID)
    {
        if(semesterID && courseYearId)
        {
            var subject_id = $("#subject_"+courseYearId+"_"+semesterID) ? $("#subject_"+courseYearId+"_"+semesterID).val(): "";             
            $.ajax({
                type: "POST",
                cache:false,
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php/batches/saveSubjects",
                data: { course_year_id:courseYearId, semester_id: semesterID, subjects: subject_id,batch_id: <?php echo $_GET['batchId'];?> }
                })
                .done(function( msg ) {
                alert(msg);
                });
        }
        else return false;
    };
  
</script>
<table width="100%">
    <tr>
        <td colspan="7"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
   
    <tr>
          
        <td><strong><?php echo CHtml::label("Add/Remove subjects", null); ?></strong></td>      
        
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="7" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php  foreach($courseYears as $kee=>$year) { ?>
            <tr>
                <td><span style="font-size: medium;font-weight: bold;text-decoration: underline;color: #3388BB;"><?php echo $year['year_name'];?></span></td>
            </tr>
          <?php  foreach($models as $index=>$semester) { 
                    if($semester->course_year_id==$year['id']){ ?>
                        <tr>
                            <td><b><?php echo $semester->getSemesterName(); ?></b>  
                              <?php  $form=$this->beginWidget('CActiveForm', array('id'=>'subject-form_'.$index)); ?>
                                <table style="padding-left: 30px;">
                                    <?php if($semester->subjects){   ?>
                                        <tr>
                                            <td><h4>Select Subjects</h4>
                                            </td>
                                            <td>
                                                <select id="subject_<?php echo $year['id']."_".$semester->semester_id;?>" name="sub_id_<?php echo $subject->id;?>" multiple="true" style="height: 200px;">
                                                    <option value="">-Select Subject -</option>
                                                    <?php foreach($semester->subjects as $key=>$subject) { ?>
                                                    <option value="<?php echo $subject->id;?>" <?php if($rr = $semester->isSelectedBatchSubject( $year['id'],$semester->semester_id,$_GET['batchId'],$subject->id)) echo "selected='selected'"; ?>><?php echo $subject->subject;?></option>
                                                    <?php } ?>                                        
                                                </select>
                                            </td>
                                            <td><input type="button" name="save" value="SAVE" onclick="return changeBatchSubject(<?php echo $year['id'];?>,<?php echo $semester->semester_id;?>);"/> </td>
                                        </tr>
                                    <?php  } ?>
                                </table>
                                <?php $this->endWidget(); ?>
                            </td>

                        </tr>
    <?php } } } }?>
    
</table>