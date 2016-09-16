<h3> View All Users </h3>
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
        <td colspan="6"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
    <tr>
        <td colspan="6" class="add-link"><?php echo CHtml::link("Add New", array('/users/add')); ?></td>
    </tr>
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Name", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Role", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("EmailId", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Phone", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Username", null); ?></strong></td>      
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="6" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php 
        foreach($models as $index=>$user) {
        ?>
            <tr class="rows">
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->getRoleName(); ?></td>
                <td><?php echo $user->email; ?></td>
                <td><?php echo $user->phone; ?></td>
                <td><?php echo $user->username;; ?></td>
                <td><?php echo CHtml::link("Edit", array('/users/edit/id/'.$user->id)); ?> | <?php echo CHtml::link("delete", array('/users/delete/id/'.$user->id),array('confirm' => 'Are you sure?')); ?> | <?php if($user->status==User::STATUS_ACTIVE) echo CHtml::link("Disable", array('/users/status/DId/'.$user->id),array('confirm' => 'Are you sure?'));else if($user->status==User::STATUS_DISABLED)echo CHtml::link("Enable", array('/users/status/EId/'.$user->id),array('confirm' => 'Are you sure?')); ?></td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>