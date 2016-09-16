<h3> View All Applications </h3>
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
        <td colspan="7"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
<!--    <tr>
        <td colspan="7" class="add-link"><?php echo CHtml::link("Add New", array('/applications/add')); ?></td>
    </tr>-->
    <tr class="headings">
        <td><strong><?php echo CHtml::label("Status", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("Application ID", null); ?></strong></td> 
        <td><strong><?php echo CHtml::label("Name", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Email", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Phone", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Occupation", null); ?></strong></td>
        <td><strong><?php echo CHtml::label("Actions", null); ?></strong></td>
    </tr>
    <?php if(count($models)==0) { ?>
        <tr>
            <td colspan="7" class="marginSet-1"><div class="flash-notice">Oops...! No records found !</div></td>
        </tr>
    <?php } else { ?>
        <?php          
                $pending_image = CHtml::image(Yii::app()->request->baseUrl."/images/pending.png","Pending",array("width"=>"20px","height"=>"20px","title"=>"Click here to change it to pending"));
                $accept_image = CHtml::image(Yii::app()->request->baseUrl."/images/accepted.png","accepted",array("width"=>"20px","height"=>"20px","title"=>"Click here to accept"));
                $hold_image = CHtml::image(Yii::app()->request->baseUrl."/images/hold.png","hold",array("width"=>"20x","height"=>"20px","title"=>"Click here to make it hold"));
                $declined_image = CHtml::image(Yii::app()->request->baseUrl."/images/declined.png","declined",array("width"=>"20px","height"=>"20px","title"=>"Click here to decline"));
                $student_image = CHtml::image(Yii::app()->request->baseUrl."/images/student.png","declined",array("width"=>"20px","height"=>"20px","title"=>"Already a student"));
        
        foreach($models as $index=>$application) {
        ?>
            <tr class="rows">
                <td><?php 
                    if($application->status== Application::STATUS_PENDING)
                        echo $pending_image;
                    else if($application->status== Application::STATUS_APPROVED)
                        echo $accept_image;
                    else if($application->status== Application::STATUS_HOLD)
                        echo $hold_image;    
                    else if($application->status== Application::STATUS_DECLINED)
                        echo $declined_image;
                    else if($application->status== Application::STATUS_STUDENT)
                        echo $student_image;
                  ?></td>
                <td><a class="app-view-lnk" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/applications/viewDetails/id/<?php echo $application['id'];?>"><?php echo $application->id; ?></a> </td>           
                <td><?php echo $application->name; ?></td>                
                <td><?php echo $application->email; ?></td>
                <td><?php echo $application->mobile_phone; ?></td>
                <td><?php echo $application->occupation; ?></td>
                <td>
                    <?php 
                        if($application->status!= Application::STATUS_STUDENT)
                        {
                            echo CHtml::link($pending_image, array('/applications/status/PId/'.$application->id),array('confirm' => 'Are you sure?'));
                            echo " | ".CHtml::link($accept_image, array('/applications/status/AId/'.$application->id),array('confirm' => 'Are you sure?'));
                            echo " | ".CHtml::link($hold_image, array('/applications/status/HId/'.$application->id),array('confirm' => 'Are you sure?'));                
                            echo " | ".CHtml::link($declined_image, array('/applications/status/DId/'.$application->id),array('confirm' => 'Are you sure?'));
                            echo " | ";
                             if($application->status== Application::STATUS_APPROVED) echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/student.png","Enroll as a student",array("width"=>"20px","height"=>"20px","title"=>"Click here to enroll this appication as a student.")), array('/applications/student/appId/'.$application->id),array('confirm' => 'Are you sure?'));
                        }
                        else  echo $student_image;
                   ?>
                    <?php echo CHtml::link("Edit", array('/applications/edit/id/'.$application->id)); ?> | <?php echo CHtml::link("delete", array('/applications/delete/id/'.$application->id),array('confirm' => 'Are you sure?')); ?>
                </td>
            </tr>
        <?php } ?>
            <?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
    <?php } ?>
    
</table>