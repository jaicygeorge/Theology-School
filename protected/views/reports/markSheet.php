<h3> View Exam Report</h3>
<?php if(Yii::app()->user->hasFlash('success')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>

<div cla ss="flash-error">
	<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>
<hr>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('tr.rows td:first-child').addClass('first');
    $('tr.rows td:last-child').addClass('last');
    $('#content >hr').addClass('line');
    $('#content >h3').addClass('heading');
});
</script>
<script type="text/javascript">
<!--
function printContent(id){
str=document.getElementById(id).innerHTML
newwin=window.open('','printwin','left=100,top=100,width=400,height=400')
newwin.document.write('<HTML>\n<HEAD>\n')
newwin.document.write('<TITLE>Print Page</TITLE>\n')
newwin.document.write('<script>\n')
newwin.document.write('function chkstate(){\n')
newwin.document.write('if(document.readyState=="complete"){\n')
newwin.document.write('window.close()\n')
newwin.document.write('}\n')
newwin.document.write('else{\n')
newwin.document.write('setTimeout("chkstate()",2000)\n')
newwin.document.write('}\n')
newwin.document.write('}\n')
newwin.document.write('function print_win(){\n')
newwin.document.write('window.print();\n')
newwin.document.write('chkstate();\n')
newwin.document.write('}\n')
newwin.document.write('<\/script>\n')
newwin.document.write('</HEAD>\n')
newwin.document.write('<BODY onload="print_win()">\n')
newwin.document.write(str)
newwin.document.write('</BODY>\n')
newwin.document.write('</HTML>\n')
newwin.document.close()
}
//-->
</script>
<style type="text/css">
#marksheetHeader { display: none; }
@media print {
#marksheetHeader{display: block;width: 100%;margin-bottom: 20px;text-align: center;}
#marksheetHeader span{display: block;padding: 10px 0;color: #000;font-size: 12px;text-align: center;}
#marksheetHeader h3{color: #000;display: block;font-size: 44px;font-weight: normal; padding:30px;}
#marksheetHeader p{color: #000;font-size: 14px;font-weight: bold;padding-bottom: 12px;}
tr.headings-print td{background: none !important;border-color: #fff;padding-left: 0 !important;font-size: 23px;
font-weight: normal;text-align: center;padding-top: 50px!important;}
tr.sub-heading1 td div{margin-top: 10px;font-size: 20px;text-align: center;}
tr.sub-heading2 td div{padding-bottom: 25px;font-size: 18px;border-right:0px;text-align: center;margin-top: 10px;}
tr.sub-heading1 td div, tr.sub-heading2 td div,tr.sub-heading3 td div{font-weight: normal; border:none !important;color: #000 !important;padding-left: 0 !important;}
tr.sub-heading3 td{text-align: left;padding: 10px !important;font-weight: bold;border:1px solid #000;border-right:0;}
tr.sub-heading3 td.first{border-left:1px solid #000;}
tr.rows td{border-left:1px solid #000;}
tr.rows td.last,tr.sub-heading3 td.last{border-right:1px solid #000;}
#marksheetHeader h5{border-bottom:  1px solid #000;padding-bottom: 10px;}
.sub-heading3 >td{border-color: #000!important;}
.sub-heading3 >td{border-left:0!important;}
.sub-heading3 >td.first{border-left:1px solid #000 !important;}
}
</style>

<div class="marksheet-header" id="marksheetHeader">
<span>(...and teaching every man in all wisdom; that we may present every man perfect in Christ Jesus.Colo:1:28)</span>
<h3>Dallas School Of Theology</h3>
<p>1918, BELTLINE RD, GARLAND, TX 75044, Phone(469)682-5031, www.dstdallas.org</p>
<h5><?php echo $courseName;?></h5>
</div>

<table width="100%" id="print-main" cellpadding="0" cellspacing="0" >    
     <?php if($subjectCount>16){ ?>
    <tr class="headings-print">
        <td colspan="6"><?php echo CHtml::label("Student Name", null); ?> - <?php echo $studentModel->name;?> (#<?php echo $studentModel->id;?>)</td>
    </tr>
    <?php if($markArray) { 
        $displayedHeading = false;
        $start = "even";
        foreach($markArray as $key=>$mark){
             
            if($mark['course_year']){ ?>    
                <tr class="sub-heading1">
                  <td colspan="6"><div class="row-year"><?php echo $mark['course_year'];?> ( <?php echo $mark['course_year_range'];?> )</div></td>                  
                </tr>
            <?php } if($mark['semester']){?>
                <tr class="sub-heading2">
                  <td colspan="6"><div class="row-sem"><?php echo $mark['semester'];?></div></td>                  
                </tr>  
              <?php } ?>
              <?php   if($displayedHeading==false){                ?> 
                
                <tr class="sub-heading2 sub-heading3">
                  <td class="first">Course of Study</td>    
                  <td>Instructor</td>    
                  <td class="last">Grade</td>
                  <td class="first">Course of Study</td>    
                  <td>Instructor</td>    
                  <td class="last">Grade</td>
                </tr> 
                 <?php $displayedHeading = true;} ?>  
        <?php  if($start=="even") {$i = 0;echo "<tr class='rows'>";}?>           
            <td class="first <?php if($mark['subject_type']==Subject::TYPE_COLLEGE_SUBJECT) echo "type1";else echo "type2";?>"><?php echo $mark['subject'];?></td> 
            <td class="teacher"><?php echo $mark['teacher_code'];?></td> 
            <td class="grade"><?php echo $mark['grade'];?></td> 
            
        <?php if($i==0 && ($markArray[$key+1]['course_year']||$markArray[$key+1]['semester'])){echo "<td colspan='3'>&nbsp</td></tr>";$start = "even";}else if($i==1){$start = "even";echo "</tr>";}else $start = "odd";$i++;?>
    <?php } } }else { ?>        
         <tr class="headings-print">
        <td colspan="3"><?php echo CHtml::label("Student Name", null); ?> - <?php echo $studentModel->name;?> (#<?php echo $studentModel->id;?>)</td>
    </tr>
    <?php if($markArray) { 
        $displayedHeading = false;
        foreach($markArray as $key=>$mark){
            if($mark['course_year']){ ?>    
                <tr class="sub-heading1">
                  <td colspan="3"><div class="row-year"><?php echo $mark['course_year'];?> ( <?php echo $mark['course_year_range'];?> )</div></td>                  
                </tr>
            <?php } if($mark['semester']){?>
                <tr class="sub-heading2">
                  <td colspan="3"><div class="row-sem"><?php echo $mark['semester'];?></div></td>                  
                </tr>  
              <?php } ?>
              <?php   if($displayedHeading==false){
                ?>   
                 <tr class="sub-heading2 sub-heading3">
                  <td class="first">Course of Study</td>    
                  <td>Instructor</td>    
                  <td class="last">Grade</td>
                </tr> 
                 <?php $displayedHeading = true;} ?>   
            <tr class='rows'>
            <td class="first <?php if($mark['subject_type']==Subject::TYPE_COLLEGE_SUBJECT) echo "type1";else echo "type2";?>"><?php echo $mark['subject'];?></td> 
            <td class="teacher"><?php echo $mark['teacher_code'];?></td> 
            <td class="grade last"><?php echo $mark['grade'];?></td> 
           
            </tr>
    
   
    <?php } } } ?>
   
</table>  

<table width="100%" id="print-second" cellpadding="0" cellspacing="0" style="display:none;" >    
    <tr class="headings-print">
        <td colspan="6">Degree Program: <?php echo $courseName;?><?php echo CHtml::label("Student Name", null); ?> - <?php echo $studentModel->name;?></td>
        <td>Registration Number: #<?php echo $studentModel->id;?></td>
    </tr>
    <tr class="headings-print">
        <td colspan="6">Student’s Name: <?php echo CHtml::label("Student Name", null); ?> - <?php echo $studentModel->name;?></td>
   
    </tr>
    <?php if($markArray) { 
        $displayedHeading = false;
       
        foreach($markArray as $key=>$mark){
            if($mark['course_year']){ ?>    
                <tr class="sub-heading1">
                  <td colspan="6"><div class="row-year"><?php echo $mark['course_year'];?> ( <?php echo $mark['course_year_range'];?> )</div></td>                  
                </tr>
                <tr class="sub-heading2 sub-heading3">
                    <td class="first">S/N</td>    
                    <td class="first">Course of Study</td>    
                    <td>Intructor</td>    
                    <td class="last">Grade</td>    
                  </tr> 
            <?php $cnt= 1; } ?>
     <?php if($subjectCount>16){
          if(($key%2)==0 && $mark['subject_type']==Subject::TYPE_UNIVERSITY_SUBJECT) {$i = 0;echo "<tr class='rows'>";}?>   
            <td><?php echo $cnt;?></td>
            <td class="first"><?php echo $mark['subject'];?></td> 
            <td class="teacher"><?php echo $mark['teacher_code'];?></td> 
            <td class="grade"><?php echo $mark['grade'];?></td> 
            
        <?php if(($key1%2)==0 && $i!=0) {echo "</tr>";$cnt++;}$i++;?>
    <?php }else if($mark['subject_type']==Subject::TYPE_UNIVERSITY_SUBJECT) { ?>
            <tr class='rows'>
            <td><?php echo $cnt;?></td>
            <td class="first"><?php echo $mark['subject'];?></td> 
            <td class="teacher" ><?php echo $mark['teacher_code'];?></td> 
            <td class="grade last"><?php echo $mark['grade'];?></td> 
            </tr>
            <?php $cnt++;} ?>
    <?php } } ?>
   
</table>   

<a onclick="window.print();" id="printButton" href="#" target="_blank">Print DST Grade</a>&nbsp;&nbsp;
<!--<span onclick="printContent('print-second');" id="printButton">Print Manakala Grade</span>-->