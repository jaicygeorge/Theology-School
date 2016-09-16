<h3> View All Course Years of <strong><?php echo CHtml::link(Course::getCourseName($_GET['courseId']), array('/courses/view'));?></strong></h3>
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
        <td colspan="5" class="add-link"><?php echo CHtml::link("Add New", array('/courses/addCourseYear/courseId/'.$_GET['courseId'])); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Year Name", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Created Date", null); ?></strong></td>  
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="5" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$courseYear) {
        ?>
            <tr class="rows">
                <td><?php echo $courseYear->year_name; ?></td>
                <td><?php echo $courseYear->created;   ?></td>                
                <td><?php echo CHtml::link("View Semesters", array('/CourseYearSemesters/view/courseYearId/'.$courseYear->id)); ?> | <?php echo CHtml::link("Edit", array('/Courses/editCourseYear/courseId/'.$_GET['courseId'].'/id/'.$courseYear->id)); ?> | <?php echo CHtml::link("delete", array('/courses/deleteCourseYear/courseId/'.$_GET['courseId'].'/id/'.$courseYear->id),array('confirm' => 'Are you sure?')); ?> </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>