<h3> View All Semesters </h3>
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
        <td colspan="2" class="add-link"><?php echo CHtml::link("Add New", array('/semesters/add')); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Semester Name", null); ?></strong></td>      
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
           <td colspan="2" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$semester) {
        ?>
            <tr class="rows">
                <td><?php echo $semester->name; ?></td>                
                <td><?php echo CHtml::link("Edit", array('/semesters/edit/id/'.$semester->id)); ?> | <?php echo CHtml::link("delete", array('/semesters/delete/id/'.$semester->id),array('confirm' => 'Are you sure?')); ?> </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>