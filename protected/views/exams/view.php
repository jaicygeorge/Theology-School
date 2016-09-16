<h3> View All Exams </h3>
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
<table width="100%">
    <tr>
        <td colspan="5"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
    <tr>
        <td colspan="5" class="add-link"><?php echo CHtml::link("Add New", array('/exams/add')); ?></td>
    </tr>
    <tr class="headings">
<!--        <td><strong><?php //echo CHtml::label("Exam Name", null); ?></strong></td> -->
         <td><strong><?php echo CHtml::label("Batch", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("Course - Year - Semester", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
             <td colspan="5" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$exam) {
        ?>
            <tr class="rows">
                <!--<td><?php// echo $exam->name; ?></td>-->   
                <td><?php echo $exam->getBatchName($exam->batch_id); ?></td>   
                <td><?php echo $exam->getCourseYearName($exam->course_year_semester_id)." - ".$exam->getSemesterName($exam->course_year_semester_id); ?></td>   
                <td><?php echo CHtml::link("Manage Result", array('/exams/students/examId/'.$exam->id)); ?> |  <?php echo CHtml::link("Edit", array('/exams/edit/id/'.$exam->id)); ?> | <?php echo CHtml::link("delete", array('/exams/delete/id/'.$exam->id),array('confirm' => 'Are you sure?')); ?> </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>