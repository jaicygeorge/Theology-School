<h3> View All Semesters with in the course
   <b><?php  if($courseModel) echo CHtml::link($courseModel->name, array('/courses/view'));?></b> </h3>
<h3>Batch ( <?php echo Batch::getBatchName($_GET['batchId']);?>)</h3>

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
<!--<hr><script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
 <script type="text/javascript">

    function changeSubjectTeacher(batch_subject_id)
    {
        if(batch_subject_id)
        {
            var teacher_id = $("#teahcer_id_"+batch_subject_id) ? $("#teacher_id_"+batch_subject_id).val(): "";             
            $.ajax({
                type: "POST",
                cache:false,
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php/batches/subjectTeacher",
                data: {batch_subject_id: batch_subject_id, teacher_id: teacher_id,batch_id: <?php echo $_GET['batchId'];?> }
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
        <td colspan="7"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
   
    <tr>
          
        <td><strong><?php echo CHtml::label("Assign faculties for each subjects", null); ?></strong></td>      
        
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

                                    <?php if($batchSubjects = $semester->getBatchSubjects($year['id'],$_GET['batchId'],$semester->semester_id)){                            
//                                        echo "<pre>";echo $year['id'];print_r($batchSubjects);exit;
                                        foreach($batchSubjects as $key=>$subject) { ?>
                                        <tr>
                                            <td width="200">
                                                <?php echo $form->hiddenField($subjectTeacher, 'batch_subject_id',array('value'=>$subject->id)); ?>
                                                <?php echo Subject::getSubjectName($subject->subject_id);?></td> 
                                            <td>
                                            <select id="teacher_id_<?php echo $subject->id;?>" name="teacher_id_<?php echo $subject->id;?>" onchange="return changeSubjectTeacher(<?php echo $subject->id; ?>);">
                                                <option value="">-Select Faculty -</option>
                                                <?php foreach($teachersList as $kk =>$teacher) {?>
                                                <option value="<?php echo $kk;?>" <?php if($semester->getSubjectTeacher($subject->id)==$kk) echo "selected";?>><?php echo $teacher;?></option>
                                                <?php } ?>                                        
                                            </select>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                </table>
                                <?php $this->endWidget(); ?>
                            </td>
                        </tr>
    <?php } } } }?>    
</table>