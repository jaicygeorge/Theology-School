<h3> View All Batches </h3>
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
        <td colspan="5" class="add-link"><?php echo CHtml::link("Add New", array('/batches/add')); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Batch", null); ?></strong></td>     
        <td><strong><?php echo CHtml::label("Course", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("Start Date", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("End Date", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="5" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php foreach($models as $index=>$batch) { ?>
            <tr class="rows">
                <td><?php echo substr($batch->start_date,0,4)." - ".substr($batch->end_date,0,4); ?></td>   
                <td><?php echo $batch->getCourseName($batch->course_id); ?></td>   
                <td><?php echo $batch->start_date; ?></td>   
                <td><?php echo $batch->end_date; ?></td>   
                <td><?php echo CHtml::link("Manage Subjects", array('/batches/manageSubjects/batchId/'.$batch->id));  ?> | <?php echo CHtml::link("Manage Instructors", array('/batches/semesters/batchId/'.$batch->id)); ?>  |  <?php echo CHtml::link("Edit", array('/batches/edit/id/'.$batch->id)); ?> | <?php echo CHtml::link("delete", array('/batches/delete/id/'.$batch->id),array('confirm' => 'Are you sure?')); ?></td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>