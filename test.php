<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>FoxNotes TAT, QC, & Line Analysis Tool</title>
</head>
<body>
<?php 
	
	//tn & sn for ubbt
	$ban 	= $_GET['ban'];
	$sn 		= $_GET['sn'];
		
	if($ban != ''){
		$m1 = 'tn';
		$m2 = 'ban';
	}
	else{
		if($sn != ''){
			$m1 = 'sn';
			$m2 = 'sn';
		}
	}
	
		if( ($ban == '') && ($sn == '') ){
		$ubbt	= 'http://lsbbt.sbc.com/lsbbt/troubleAnalysis.jsp';
		$qc		= 'about:blank';
	}
	else{
		$ubbt	= "http://lsbbt.sbc.com/lsbbt/troubleAction.do?method=$m1&elementId=&$m1=$ban";
		$qc		= "http://lsbbt.sbc.com/rgqualitycheck/RGQualityServlet?type=$m2&$m2=$ban";
	}
?>

<div align="center">
<b>FoxNotes TAT & Quality Check Tool</b>
<form name="tests" method="get" action="test.php">
<table width="50%">
<tr>
<td align="center">		<b>BAN:</b>		<input type="text" name="ban">	</td>
<td align="center">		<b>RG SN:</b>	<input type="text" name="sn">	</td>
<td align="center">		<input type="submit" name="submit" value="GO">	</td>
</tr>
</table>
</form>

<?php
print("
<table border=1 width=100%>
<tr><td><iframe name='ubbt'  	src='$ubbt' 	scrolling='auto'  height=350 width=100%></iframe></td></tr>
<tr><td><iframe name='qc'  		src='$qc' 		scrolling='auto'  height=350 width=100%></iframe></td></tr>
</tr>
</table>
");
?>


</body>
</html>

