<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<script src="js/jquery-1.7.min.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/jquery.query.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="pousada/js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/additional-methods.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/bootstrap.min.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>
$(document).ready(function(){
	var jq17 = jQuery.noConflict();
});
</script>
<style>
.span3 {  
    height: 200px !important;
}
</style>
<body >
	<ul class='nav nav-tabs'>
		<li class='active'>
			<a href='#first' data-toggle='tab' style='border-radius: 8px; ' >teste1</a>
		</li>
		<li>
			<a href='#second' data-toggle='tab'  style='border-radius: 8px;'>teste2</a>
		</li>
		<li>
			<a href='#third' data-toggle='tab' style='border-radius: 8px;'>teste3</a>
		</li>
	</ul>

	<div class='tab-content'>
		<div id='first' class='tab-pane active'>
			<p>
				<div class='alert' aling='center'>
					<div align='center'>
						msg1
					</div>
				</div>
			</p>
		</div>
		<div id='second' class='tab-pane'>
			<p>
				<div class='alert' aling='center'>
					<div align='center'>
						msg2
					</div>
				</div>
			</p>
		</div>
		<div id='third' class='tab-pane'>
			<p>
				<div class='alert' aling='center'>
					<div align='center'>
						msg3
					</div>
				</div>
			</p>
		</div>
	</div>

</body>
</html>
