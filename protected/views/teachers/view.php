<h3> View All Teachers </h3>
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
        <td colspan="2"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
    <tr>
        <td colspan="2" class="add-link"><?php echo CHtml::link("Add New", array('/teachers/add')); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Instructor Name", null); ?></strong></td>    
        <td><strong><?php echo CHtml::label("Instructor Code", null); ?></strong></td>    
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
           <td colspan="2" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$teacher) {
        ?>
            <tr class="rows">
                <td><?php echo $teacher->name; ?></td> 
                <td><?php echo $teacher->code; ?></td> 
                <td><?php echo CHtml::link("Edit", array('/teachers/edit/id/'.$teacher->id)); ?> | <?php echo CHtml::link("delete", array('/teachers/delete/id/'.$teacher->id),array('confirm' => 'Are you sure?')); ?> </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>