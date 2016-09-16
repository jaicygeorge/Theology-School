<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site.css" />  
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript">
	function goBack(){	  
	  	window.history.back()
	}
</script>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
	
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('users/dashboard'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Applications', 'url'=>array('applications/view'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Courses', 'url'=>array('courses/view'), 'visible'=>!Yii::app()->user->isGuest),	
                                array('label'=>'Batch', 'url'=>array('batches/view'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Students', 'url'=>array('students/view'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Semesters', 'url'=>array('semesters/view'), 'visible'=>!Yii::app()->user->isGuest),                                
                                array('label'=>'Instructors', 'url'=>array('teachers/view'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Grades', 'url'=>array('grades/view'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Subjects', 'url'=>array('subjects/view'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Exams', 'url'=>array('exams/view'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Reports', 'url'=>array('reports/view'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'User Management', 'url'=>array('users/view'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Login', 'url'=>array('users/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout', 'url'=>array('users/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>            
	</div><!-- mainmenu -->
        <span style="float:right;"><a href="#" class="backBtn" onclick="goBack();">Back</a></span>
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	

</div><!-- page -->
<div class="full-width">
<div id="footer">
		<p>&copy; <?php echo date('Y'); ?> School Of Theology Online. All Rights Reserved.</p>
	</div><!-- footer -->
</div>
</body>
</html>