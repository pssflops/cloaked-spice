<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<script src="js/jquery-1.7.1.js"></script>  
		<script src="jQuery/jquery-ui-1.8.19.js"></script>
  <link href="css/jquery-ui-custom1.css" rel="stylesheet" type="text/css"/>		
  <script type="text/javascript" src="js/jquery.form.js"></script> 


	<title>TAC's Ticket Updater - Update tickets and put 'em back in the Open Queue.</title>
		<script>
		$(document).ready(function()
			{ 	
			$('button#submit ').click(function()
			{
			$.ajax(
				{
					   type: "POST",
					   url: "ticketupdate.php?tickentry=$Aticket",
					   cache: false,
					   dataType: 'html'
					   
				});
			});
	$('#table tr:odd').css('background', ' #ABCDEF');
	$('#table tr:even').css('background', ' #FFFFFF');
    $('#table tr:first').css('background', ' #eeeeee');

		});
		</script>
	
		<style>
		body{
			position:relative;
			margin-top:2%;
			font: 11px Arial,Verdana, sans-serif;
			width: 99%;
			background:#A6D8ED;
			color:#000000;
		}
@font-face {
	font-family: Script MT Bold;
	src: url('SCRIPTBL.ttf');
}
.corners{
		-moz-border-radius: 4px;
		border-radius: 4px;
}

input {
padding:5px;
}

	.tab{
		background:#708090;
		position:relative;
		text-align:center; 
		bottom:0px; 
		left:10px; 
		padding:1px;
	}
	#table {
		text-align: center;
		vertical-align: top;
	}
	#divtop {
	display: inline;
	text-align: center;
	vertical-align: top;
	}
	#divbottom {
	text-align: left;
	vertical-align: bottom;
	display: block;
	padding: 5px;
	}
	#colright {
	display: block;
	padding: 4px;
	clear:both;
	float:left;
	background: #888888;
	color: #FFFFCC;
	border-radius: 2px;
	opacity: 0.75;
	text-align: center;
	margin: 10px auto;
	margin-left: 5%;
	}
	
	.outline {
	border: 1px solid #444444;
	}
	
	#update {
	display: inline-block;
	 background:#FFFFCC;
	 color:#000000;
	 width: 350px;
	 height: 350px;
	 padding: 15px;
	 margin: 10px auto;
	 border-radius:4px;
	 font-size: 0.75em;
	 }
		</style>
		</head>

				<body>
<div id="divtop">	
			<script>
	  $(document).ready(function() { 
			   $("button").button();
			$('table, button, tr, span, a, p, div, textarea, input, img').addClass('corners');
			$('input, table').addClass('outline');
			});
	</script>
	<?php

error_reporting(E_ALL ^ E_NOTICE); 



$db_host = 'localhost';
$db_user = 'root';
$db_pwd = '';
$database = 'dbase';
$table = 'tickets';
$ticket = 'Ticket';


	$con = mysql_connect($db_host, $db_user, $db_pwd);
if(!mysql_connect($db_host, $db_user, $db_pwd))   
		die ("Can't connect to database");
			if(!mysql_select_db($database))   
				die ("Can't select database");
			?>
			<center>
<font face="Script MT Bold" size=6>After submitting a ticket number, make adjustments below:</font>
<br><br/>
			<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pwd = '';
$database = 'dbase';
$table = 'tickets';
$ticket = 'Ticket';
$Aticket =  $_POST['tickentry'];
	
	$con = mysql_connect($db_host, $db_user, $db_pwd);
if(!mysql_connect($db_host, $db_user, $db_pwd))   
		die ("Can't connect to database");
			if(!mysql_select_db($database))   
				die ("Can't select database");
 
 // sending query
  
 $result = mysql_query("SELECT * FROM tickets WHERE Ticket = '$Aticket'");


 if(!$result) {    
			die ("Query to show fields from table failed");
		}
 
			echo "<div class='tab' >";
			echo "<font face='Georgia' color='#000000' size=5>";
			echo "<b>Ticket Selected:</b> </font><br /><font face='arial' color='#000000' size=4>";
	if (isset($_POST['tickentry'])){
		
	$fields_num = mysql_num_fields($result);
	
	echo "<center><table id='table'><tr>";
	//	printing first table of added tickets
	
	for($i=0; $i<$fields_num; $i++){ 
				$field = mysql_fetch_field($result);
				echo "<td><b><font face='Georgia'> {$field->name} </font></b></td>";
			}
			echo "</tr>\n";
					while($row = mysql_fetch_row($result)){ 
						foreach ( $row as $cell)        

			echo "<td>$cell</td>";
			echo "</tr>\n";
			}
?>		
</table></center></div>
<?php
}	
	
		else {
		echo "<font color=#ffffff>You have not yet entered in a ticket.</font>";
		}

 mysql_free_result($result);
	// Clears the result so we can use the variable again.
mysql_close($con);
	// Closes the connection to MySQL so we don't hold an infinite session.
  ?>
</div> <!-- #End DivTop# -->
			
<div id="divbottom">			
		<div id="results" > 
			<div id='colright'>
	<sup><b>Note:</b> Checked boxes allow you to edit the field.<Br> Unchecked checkboxes will not be edited.</sup>
	</div>
		<script>
	$(document).ready(function() { 
    $('.input_control').attr('checked', true);

  
	   $('.input_control').click(function(){
            if($('input[name='+ $(this).attr('value')+']').attr('disabled') == false){
                $('input[name='+ $(this).attr('value')+']').attr('disabled', true);
            }else{
                $('input[name='+ $(this).attr('value')+']').attr('disabled', false);
            }
        });
	});
</script>

</div> <!-- #End DivResults# -->
<br />
<br />
<div id="form" style="display:block;margin-left:10%;width:300px;height:300px;" >
		<form name="tickupdate" id='update' METHOD="GET" ACTION="update.php">
Select which fields to update: 
		<hr>
<input type="hidden" name="origticket" value="<?php echo $Aticket; ?>" />
<input type="checkbox" class="input_control" value="check1"><label for="check1">Ticket # :</label><input type="text" class="input" id="TTT" MAXLENGTH=6  name="check1" placeholder="Ticket Number" TABINDEX=2>		
<br/>
<input type="checkbox"  class="input_control" value="check2"><label for="check2">Priority: </label><input type="text" class="input" id="PPP" MAXLENGTH=1 name="check2" placeholder="Priority" TABINDEX=3>
<br />
<input type="checkbox"  class="input_control" value="check3"><label for="check3">Comments: </label><input type="text" class="input" id="CCC" name="check3" placeholder="Comments" TABINDEX=4>
<br>
<input type="checkbox"  class="input_control" value="check4"><label for="check4">Site: </label><input type="text" class="input" id="SSS" name="check4" placeholder="Site Name" TABINDEX=5>
<br><br />
<button id="tickchange" >Submit</button>

</form>
	</div> <!-- #End DivForm # -->

</div>	<!-- #End DivBottom# -->
	<script>
	$(document).ready(function()
			{ 	
			$('button#tickchange ').click(function()
			{
			$.ajax(
				{
					   type: "GET",
					   url: "update.php?origticket=$Aticket&check1=$Zticket&check2=$Priority&check3=$Comments&check4=$Sname",
					   cache: false,
					   dataType: 'html'
				});
			});
	});
		</script>

			<div id="homelink" style="position:fixed;bottom:20px;right:20px;padding:15px;background:#eeeeee;color:#000000;" target="_SELF">
		<a href="http://tac-alert01/index.php" title="Get me back to the Alert Queue">Head back to the Alert System</a>
		</div>

	</body>
  </html>
  
  
  
  
  
  
  
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			