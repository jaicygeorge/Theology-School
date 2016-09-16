<h3> View Exam Report</h3>
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
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.js"></script>
<!--<script type="text/javascript" src="/js/jquery.min.js"></script>-->
 <script type="text/javascript">
    function checkForm()
    {
        if(!$("#batch").val()){
            alert("Please select any batches");
            return false;
        }
        if(!$("#student").val()){
            alert("Please select student");
            return false;
        }
        return true;
    };
    function getStudent()
    {           
        $.ajax({
            type: "POST",
            cache:false,
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php/reports/student/",
            data: { batch_id:$("#batch").val() }
            })
            .done(function( msg ) {               
                if(msg) msg =  $.parseJSON(msg);
                $("#student-span").html('');
                var dropdown = '<select name="student" id="student" onchange="getYears();"><option value="">-Select Student-</option>';
                if(msg){
                $.each(msg, function(key, val) {                      
                   dropdown += '<option value="'+key+'">'+key+' - '+val+'</option>';
                });}
                dropdown += '</select>';
                $("#student-span").html(dropdown);
                $("#semester-span").html('');
                var dropdown = '<select name="semester" id="semester"><option value="">-Select All-</option></select>';
                $("#semester-span").html(dropdown);
            });
       
    };
    function getYears()
    {           
        $.ajax({
            type: "POST",
            cache:false,
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php/reports/courseYears/",
             data: { batch_id:$("#batch").val(),student_id:$("#student").val() }
            })
            .done(function( msg ) {               
                if(msg) msg =  $.parseJSON(msg);
                $("#year-span").html('');
                var dropdown = '<select name="courseYears" id="courseYears" onchange="getSemester();"><option value="">-Select All-</option>';
                if(msg){
                    $.each(msg, function(key, val) {                      
                       dropdown += '<option value="'+key+'">'+val+'</option>';
                    });
                }
                dropdown += '</select>';
                $("#year-span").html(dropdown);
                
            });       
    };
    function getSemester()
    {           
        $.ajax({
            type: "POST",
            cache:false,
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php/reports/semester/",
             data: { batch_id:$("#batch").val(),year_id:$("#courseYears").val(),student_id:$("#student").val() }
            })
            .done(function( msg ) {               
                if(msg) msg =  $.parseJSON(msg);
                $("#semester-span").html('');
                var dropdown = '<select name="semester" id="semester"><option value="">-Select All-</option>';
                if(msg){
                    $.each(msg, function(key, val) {                      
                       dropdown += '<option value="'+key+'">'+val+'</option>';
                    });
                }
                dropdown += '</select>';
                $("#semester-span").html(dropdown);
                
            });       
    };
</script>
<form name="report-form" id="report-form" action="" method="post">
<table width="100%">
    <tr>
        <td colspan="2"><?php if(isset($message)) echo $message; unset($message); ?></td>
    </tr>
    <tr>
        <td width="150"><strong><?php echo CHtml::label("Select Batch", null); ?> <span style="color:red;">*</span></strong></td> 
        <td>
            <select name="batch" id="batch" onchange="getStudent();">
                <option value="">-Select Batch-</option> 
                <?php if($batchModel){foreach($batchModel as $key=>$val){?>
                <option value="<?php echo $val->id; ?>"><?php echo substr($val->start_date,0,4)."-".substr($val->end_date,0,4). " ( " . $val->getCourseName($val->course_id). " ) " ?></option> 
                <?php } }?>
            </select>
            
        </td> 
    </tr>
    <tr>
        <td><strong><?php echo CHtml::label("Select Student", null); ?> <span style="color:red;">*</span></strong></td>
        <td>
            <span id="student-span">
            <select name="batches">
                <option value="">-Select-</option>                
            </select>
            </span>
        </td> 
    </tr>  
     <tr>
         <td><strong><?php echo CHtml::label("Course Years", null); ?></strong></td>
         <td>
              <span id="year-span">
            <select name="courseYears">
                <option value="">-Select-</option>                
            </select>
              </span>
        </td> 
    </tr>  
     <tr>
         <td><strong><?php echo CHtml::label("Select Semesters", null); ?></strong></td>
         <td>
              <span id="semester-span">
            <select name="semesters">
                <option value="">-Select-</option>                
            </select>
              </span>
        </td> 
    </tr>  
    <tr>
         <td colspan="2" class="btn">
              <?php echo CHtml::submitButton("View mark sheet" ,array('name'=>'addSub'),array("onChange"=>"return checkForm();")); ?>
         </td>
    </tr>
</table>
</form>