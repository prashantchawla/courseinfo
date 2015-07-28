<?php

error_reporting(E_ERROR | E_PARSE);

$course = $_GET['q'];
$oarsinfourl = "http://172.26.142.75:6060/Utils/CourseInfoPopup.asp?Course=";

$html = new DOMDocument();
$html->loadHTMLFile($oarsinfourl.$course);

$table = $html->getElementsByTagName('table');

if ($table->length == 0) {
    echo 'ERROR!';
}
else{
	$table = $html->getElementsByTagName('table')->item(0);
	$string = '<!DOCTYPE html>
<html lang="en">
<head>
  <title>Course Information</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <script src="scripts/jquery.min.js"></script>
  <script src="scripts/bootstrap.min.js"></script>
  <link rel="stylesheet" href="styles/jquery-ui.css">
  <script src="scripts/jquery-1.10.2.js"></script>
  <script src="scripts/jquery-ui.js"></script>
  
  <script>
  $(function() {
    var availableTags = [
      "",
      ""
    ];
    
    $.ajax({
            url: "values.txt",
            type: "GET",
            data: {},
            async: false, //blocks window close
            success : function(data) {
				availableTags = data.split("\n");
			}
        });
    $( "#course" ).autocomplete({
		source: availableTags
    });
  });

	function genUserFriendlyCourseStatus(status)
	{
		var stat=new String(status);
		var answer;
		if (stat.valueOf()=="A")
			answer="Auto-Accept";
		else if (stat.valueOf()=="R")
			answer="Auto-Deny";
		else
			answer="Request";
		document.write(answer);
	}
</script>
  
</head>
<body>

<div class="container" style="height: 100%; margin-top: 5%; padding-left: 20%;">'.$html->saveHTML($table).'

</div>
<br>
<br>
<div align="center" >
	<button class="btn btn-info" id="getlistbutton">Get Student List</button>
	<br>
	<br>
	<br>
	<button class="btn btn-success btn-lg" id="anothercoursebutton">Check Another Course</button>
</div>

<script>

$("#getlistbutton").click(function(){
	window.location.assign("http://oars.cc.iitk.ac.in:6060/Course/download/excelnologin.asp?ccc='.$course.'");
});

$("#anothercoursebutton").click(function(){
	window.location.assign("index.html");
});

</script>

</body>
</html>';

echo $string;

}

?>
