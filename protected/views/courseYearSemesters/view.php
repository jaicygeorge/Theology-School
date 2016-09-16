<h3> View All Semesters ( <strong><?php echo CHtml::link(Course::getCourseName($courseYearModel->course_id), array('/courses/view'));?> - <?php echo CHtml::link($courseYearModel->year_name, array('/courses/viewYears/courseId/'.$courseYearModel->course_id));?></strong> ) </h3>
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
        <td colspan="3"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
    <tr>
        <td colspan="3" class="add-link"><?php echo CHtml::link("Add New", array('/courseYearSemesters/add/courseYearId/'.$courseYearModel->id));?></td>
    </tr>
    <tr class="headings">       
        <td><strong><?php echo CHtml::label("Semester", null); ?></strong></td>      
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="3" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$semester) {
        ?>
             <tr class="rows">                 
                <td><?php echo $semester->getSemesterName(); ?></td>         
                <td><?php echo CHtml::link("delete", array('/courseYearSemesters/delete/id/'.$semester->id.'/courseYearId/'.$courseYearModel->id),array('confirm' => 'Are you sure?')); ?> </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>