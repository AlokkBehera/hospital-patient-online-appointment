<?php
session_start();
include("header.php");
include("dbconnection.php");
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
      <li class="first">Add your Complaint</li></ul>
  </div>
</div>
<div class="wrapper col4">
  <div id="container">
  

   <form method="post" action="" name="frmpatapp" onSubmit="return validateform()">
    <table width="532" border="3">
      <tbody>
       
        <tr>
          <td><strong>Complaint Date</strong></td>
          <td><input type="date" min="<?php echo date("Y-m-d"); ?>" name="complaintdate" id="complaintdate"></td>
        </tr>
        <tr>
          <td><strong>Complaint Time</strong></td>
          <td><input type="time" name="complainttime" id="complainttime"></td>
        </tr>   
        <tr>
          <td><strong>Department</strong></td>
          <td>
          <select name="department" id="department" onchange="loaddoctor(this.value)">
          <option value="" name ="department">Select department</option>
          <?php
		  	$sqldept = "SELECT * FROM department WHERE status='Active'";
			$qsqldept = mysqli_query($con,$sqldept);
			while($rsdept = mysqli_fetch_array($qsqldept))
			{
			echo "<option value='$rsdept[departmentid]'>$rsdept[departmentname]</option>";
			}
		  ?>
          </select>
          </td>
        </tr>   
		<tr>
          <td><strong>Complaint Type</strong></td>
          <td>
			<div id="comptype" name="complaintype">
			  <select name="complaintype" id="ctype">
			  <option value="" name="complaintype">Select Complaint Type</option> 
			  <option value="Absence of due care">Absence of due care</option> 
			  <option value="Nursing care">Nursing care</option> 
			  <option value="Health service care">Health service care</option> 
			  <option value="Grievance handling">Grievance handling</option> 
			  <option value="Accommodation">Accommodation</option> 
			  <option value="Medical records">Medical records</option> 
			  <option value="Transport"> Transport</option>         
			  </select>   
			</div>
          </td>
        </tr>        
        <tr>
          <td><strong>Complaint Description</strong></td>
          <td><textarea name="comp_reason"></textarea></td>
        </tr>
         <tr>
          <td><strong>Generated by</strong></td>
          <td>
          <select name="compname" id="compname">
          <option value="">Your Name</option>
          <?php
		  	$sqldept = "SELECT * FROM patient WHERE status='Active'";
			$qsqldept = mysqli_query($con,$sqldept);
			while($rsdept = mysqli_fetch_array($qsqldept))
			{
			echo "<option value='$rsdept[patientname]'>$rsdept[patientname]</option>";
			}
		  ?>
          </select>
          </td>
        </tr> 
        <tr>
          <td><strong>Assigned to</strong></td>
          <td>
			<div id="divdoc">
			  <select name="doct" id="doct">
			  <option value="">Select Doctor</option>         
			  </select>   
			</div>
          </td>
        </tr> 
        <tr>
          <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" /></td>
        </tr>
      </tbody>
    </table>
    </form>
    <p>&nbsp;</p>

  </div>
</div>
</div>
 <div class="clear"></div>
  </div>
</div>
<?php
include("footer.php");
?>
<script type="application/javascript">


function validateform()
{

	if(document.frmpatapp.complaintdate.value == "")
	{
		alert("complaint date should not be empty..");
		document.frmpatapp.complaintdate.focus();
		return false;
	}
	else if(document.frmpatapp.complainttime.value == "")
	{
		alert("complaint time should not be empty..");
		document.frmpatapp.complainttime.focus();
		return false;
	}
	else if(document.frmpatapp.department.value == "")
	{
		alert("department  should not be empty..");
		document.frmpatapp.department.focus();
		return false;
	}
	else if(document.frmpatapp.complaintype.value == "")
	{
		alert("complain type should not be empty..");
		document.frmpatapp.complaintype.focus();
		return false;
	}
	else if(document.frmpatapp.comp_reason.value == "")
	{
		alert("Your description should not be empty..");
		document.frmpatapp.comp_reason.focus();
		return false;
	}
	else if(document.frmpatapp.compname.value == "")
	{
		alert("generated name should not be empty..");
		document.frmpatapp.compname.focus();
		return false;
	}
	else if(document.frmpatapp.doct.value == "")
	{
		alert("Assigned name should not be empty..");
		document.frmpatapp.doct.focus();
		return false;
	}

	  
	
	else
	{
		return true;
	}
}

function loaddoctor(deptid)
{
	    if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("divdoc").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","departmentDoctor.php?deptid="+deptid,true);
        xmlhttp.send();
}
</script>


<?php
if(isset($_POST[submit]))
{
	$dt = date("Y-m-d");
		$tim = date("H:i:s");
		$sql ="INSERT INTO complaint_details(comp_date,comp_time,department,complain_type,comp_description,generated_by,assigned_to,status) values('$_POST[complaintdate]','$_POST[complainttime]','$_POST[department]','$_POST[complaintype]','$_POST[comp_reason]','$_POST[compname]','$_POST[doct]','active')";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<script>alert('Your complain Registered Sucessfully');</script>"; 
		}
		else
		{
			echo mysqli_error($con);
		}
		
}



  ?>