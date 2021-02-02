<? echo "
<html>

<head>
<meta http-equiv=Content-Type
content=text/html; charset=iso-8859-1>

<title>Submit new discussion topic</title>
</head>

<body background=pics/bg5.jpg>

<p align=center><font color=#000000 size=5><strong>Submit Response or New Discussion Topic</strong></font></p>

<form action=email1.php method=POST>
<table align=center BGCOLOR=#33CCFF cell padding=3 cell spacing=3>
<input type=hidden name=Form value=Forum>

<tr><td valign=top><b>Your Name</b><br>
</td><td valign=top><input type=text size=45 name=name><br>
</td><td></td></tr>

<tr><td valign=top><b>Email</b><br>
</td><td valign=top><input type=text size=45 name=email><br>
</td><td></td></tr>

<tr><td valign=top><b>Company</b><br>
</td><td valign=top><input type=text size=45 name=company><br>
</td><td></td></tr>

<tr><td valign=top><b>Discussion Title</b> <br>
</td><td valign=top><input type=text size=45 name=title><br>
</td><td></td></tr>

<tr><td valign=top><b>Comments</b><br>
</td><td valign=top><textarea name=comments rows=8 cols=45 wrap=physical></textarea></p>
</td><td></td></tr>";

$gen_valid_nr = rand(10000,99000);

echo "
<tr><td valign=top><b>Validation Number</b> <br>
</td><td valign=top><input type=text size=8 name=valid_nr> To prevent spam, please enter the following<br>&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Validation Number: 
<b>$gen_valid_nr</b><br>
</td><td></td></tr>
<input type=hidden name=gen_valid_nr value=$gen_valid_nr>
</table>


<p align=center><b>Please verify the information for accuracy before submitting</b>
<br><br><center><input type=submit value=Submit Topic>&nbsp;<input type=reset></center>
<p>


</form>
<center><b>Return To<br><a href=http://wildlife-mitigation.tc.faa.gov>Home Page</b></a></center>

</body>
</html>";
