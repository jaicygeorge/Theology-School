<h3> View All Students </h3>
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
        <td colspan="8"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
    <tr>
        <td colspan="8" class="add-link"><?php echo CHtml::link("Add New", array('/students/add')); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Student ID", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Application ID", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("Name", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Batch Name", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Email", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Phone", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Occupation", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="8" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php    
        foreach($models as $index=>$student) {
        ?>
            <tr class="rows">            
                <td><?php echo CHtml::link($student->id, array('/students/viewDetails/id/'.$student->id)); ?></td>           
                <td><?php if($student->application_id){?><?php echo CHtml::link($student->application_id, array('/students/viewDetails/id/'.$student->application_id)); ?><?php } else {echo "NA";}?> </td>           
                <td><?php echo $student->name; ?></td>   
                <td><?php echo $student->getBatchName($student->batch_id); ?></td>   
                <td><?php echo $student->email; ?></td>
                <td><?php echo $student->mobile_phone; ?></td>
                <td><?php echo $student->occupation; ?></td>
                <td>
              <?php echo CHtml::link("Assign to Batch", array('/students/assignBatch/id/'.$student->id)); ?> |
                    <?php echo CHtml::link("Edit", array('/students/edit/id/'.$student->id)); ?> | 
                        <?php echo CHtml::link("delete", array('/students/delete/id/'.$student->id),array('confirm' => 'Are you sure?'));?>
                         | <?php if($student->status==Student::STATUS_ENABLED) echo CHtml::link("Disable", array('/students/status/DId/'.$student->id),array('confirm' => 'Are you sure?'));else if($student->status==Student::STATUS_DISABLED)echo CHtml::link("Enable", array('/students/status/EId/'.$student->id),array('confirm' => 'Are you sure?')); ?>
                </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>