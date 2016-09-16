<h3> View All Courses </h3>
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
        <td colspan="5" class="add-link"><?php echo CHtml::link("Add New", array('/courses/add')); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Course", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Category", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Description", null); ?></strong></td>       
        <td><strong><?php echo CHtml::label("Period( No. of years)", null); ?></strong></td>       
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="5" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$course) {
        ?>
            <tr class="rows">
                <td><?php echo $course->name; ?></td>
                <td><?php echo $course->getCategoryName();   ?></td>
                <td><?php echo $course->description; ?></td> 
                <td><?php echo $course->period; ?></td> 
                <td><?php echo CHtml::link("View Years", array('Courses/viewYears/courseId/'.$course->id)); ?> | <?php echo CHtml::link("Edit", array('/courses/edit/id/'.$course->id)); ?> | <?php echo CHtml::link("delete", array('/courses/delete/id/'.$course->id),array('confirm' => 'Are you sure?')); ?> | <?php if($course->status==Course::STATUS_ACTIVE) echo CHtml::link("Disable", array('/courses/status/DId/'.$course->id),array('confirm' => 'Are you sure?'));else if($course->status==Course::STATUS_DISABLED)echo CHtml::link("Enable", array('/courses/status/EId/'.$course->id),array('confirm' => 'Are you sure?')); ?></td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>