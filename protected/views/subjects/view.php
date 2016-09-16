<h3> View All Subjects </h3>
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
        <td colspan="4"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
    <tr>
        <td colspan="4" class="add-link"><?php echo CHtml::link("Add New", array('/subjects/add')); ?></td>
    </tr>
     <tr class="headings">
        <td><strong><?php echo CHtml::label("Subject", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Type", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Total Mark", null); ?></strong></td>           
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
           <td colspan="4" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$subject) {
        ?>
            <tr class="rows">
                <td><?php echo $subject->subject; ?></td>
                <td><?php if($subject->type==Subject::TYPE_COLLEGE_SUBJECT) echo "College Subject";else if($subject->type==Subject::TYPE_UNIVERSITY_SUBJECT)echo "University Subject";   ?></td>
                <td><?php echo $subject->total_mark; ?></td>               
                <td><?php echo CHtml::link("Edit", array('/subjects/edit/id/'.$subject->id)); ?> | <?php echo CHtml::link("delete", array('/subjects/delete/id/'.$subject->id),array('confirm' => 'Are you sure?')); ?> | <?php if($subject->status==User::STATUS_ACTIVE) echo CHtml::link("Disable", array('/subjects/status/DId/'.$subject->id),array('confirm' => 'Are you sure?'));else if($subject->status==User::STATUS_DISABLED)echo CHtml::link("Enable", array('/subjects/status/EId/'.$subject->id),array('confirm' => 'Are you sure?')); ?></td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>