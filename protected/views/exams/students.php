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
        <td colspan="5"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
   
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Student ID", null); ?></strong></td>        
        <td><strong><?php echo CHtml::label("Name", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Batch Name", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Email", null); ?></strong></td>        
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($studentList)==0) { ?>
        <tr>
            <td colspan="5" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php     
        foreach($studentList as $index=>$student) {
        ?>
            <tr class="rows">         
                <td><?php echo $student->id; ?></td>           
                <td><?php echo $student->name; ?></td>   
                <td><?php echo $student->getBatchName($student->batch_id); ?></td>   
                <td><?php echo $student->email; ?></td>               
                <td>
              <?php echo CHtml::link("Enter marks", array('/exams/markEntry/id/'.$student->id.'/examId/'.$_GET['examId'])); ?>                   
                </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>