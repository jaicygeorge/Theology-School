<h3> View All Semesters with in the course <b><?php if($courseModel) echo ' - <a href="/courses/view">'. $courseModel->name."</a>"; ?></b> </h3>
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
        <td colspan="3" class="add-link"><?php if($courseModel) echo CHtml::link("Add New", array('/courseSemesters/add/courseId/'.$courseModel->id));else echo CHtml::link("Add New", array('/courseSemesters/add')); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Course Name", null); ?></strong></td>      
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
                <td><?php echo $semester->getCourseName(); ?></td>         
                <td><?php echo $semester->getSemesterName(); ?></td>         
                <td><?php echo CHtml::link("View Subjects", array('subjects/view/courseId/'.$semester->course_id.'/semesterId/'.$semester->semester_id));  ?> | 
                    <?php if($courseModel) echo CHtml::link("delete", array('/courseSemesters/delete/id/'.$semester->id.'/courseId/'.$courseModel->id),array('confirm' => 'Are you sure?')); else echo CHtml::link("delete", array('/courseSemesters/delete/id/'.$semester->id),array('confirm' => 'Are you sure?')); ?> </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>