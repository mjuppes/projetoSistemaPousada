<?php //include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<!--<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>

function testeFecha(idobj)
{
	alert('teste '+idobj);
	

	$("#"+idobj+"").hide();	
	
}
$(document).ready(function(){
		var jq17 = jQuery.noConflict();
});
</script>
<body>
<a href="#myModal_2" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
 
<!-- Modal -->
<div id="myModal_2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
<h4 id="myModalLabel">Visualizar informações</h4>
</div>
<div class="modal-body">
<p>One fine body…</p>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br>
</div>
<div class="modal-footer">
<button class="btn" onclick="testeFecha('myModal_2')" >Close</button><!--data-dismiss="modal" aria-hidden="true">Close</button>-->
<button class="btn btn-primary">Save changes</button>
</div>
</div>
</body>  
</html>