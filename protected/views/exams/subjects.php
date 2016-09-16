<h3> View All Subjects and add marks for the student <b><?php echo $student->name;?></b></h3>
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
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.js"></script>
<!--<script type="text/javascript" src="/js/jquery.min.js"></script>-->
 <script type="text/javascript">
     function isNumberKey(evt)
{

    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
     
    function saveMark(subjectID)
    {
        if(subjectID)
        {            
            var mark = $("#mark_"+subjectID) ? $("#mark_"+subjectID).val(): "";  
            var mark1 = $("#mark1_"+subjectID) ? $("#mark1_"+subjectID).val(): "";  
            var mark2 = $("#mark2_"+subjectID) ? $("#mark2_"+subjectID).val(): "";  
            $.ajax({
                type: "POST",
                cache:false,
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php/exams/saveMarkEntry/student_id/<?php echo $_GET['id'];?>/examId/<?php echo $_GET['examId'];?>",
                data: { subject_id:subjectID, mark: mark,mark1: mark1,mark2: mark2,student_id: <?php echo $_GET['id'];?>,course_year_id:<?php echo $course_year_id;?>,semester_id:<?php echo $semester_id;?> }
                })
                .done(function( msg ) {
                alert(msg);
                });
        }
        else
        return false;
    };
    
</script>
<table width="100%">
    <tr>
        <td colspan="2"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
   
    <tr class="headings">
        <td width="250"><strong><?php echo CHtml::label("Subject Name", null); ?></strong></td>        
        <td><strong><?php echo CHtml::label("Ist exam's mark", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("2nd exam's mark", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Assignement Mark", null); ?></strong></td>
    </tr>
    <?php if(count($subjects)==0) { ?>
        <tr>
            <td colspan="2" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php     
        foreach($subjects as $index=>$subject) {
            $subObj = $subject->getSubject($subject->subject_id);
        ?>
           <tr class="rows">
                <td><?php echo $subObj->subject; ?></td>   
                <td><input name="mark_<?php echo $subObj->id; ?>" id="mark_<?php echo $subObj->id; ?>" value="<?php echo $subject->getStudentMark($student->id,$course_year_id,$semester_id);?>" style="width:100px;" onChange="return saveMark(<?php echo $subObj->id; ?>);" onkeypress="return isNumberKey(event);"/></td>   
                <td><input name="mark1_<?php echo $subObj->id; ?>" id="mark1_<?php echo $subObj->id; ?>" value="<?php echo $subject->getStudentMark1($student->id,$course_year_id,$semester_id);?>" style="width:100px;" onChange="return saveMark(<?php echo $subObj->id; ?>);" onkeypress="return isNumberKey(event);"/></td>   
                <td><input name="mark2_<?php echo $subObj->id; ?>" id="mark2_<?php echo $subObj->id; ?>" value="<?php echo $subject->getStudentMark2($student->id,$course_year_id,$semester_id);?>" style="width:100px;" onChange="return saveMark(<?php echo $subObj->id; ?>);" onkeypress="return isNumberKey(event);"/></td>   
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>