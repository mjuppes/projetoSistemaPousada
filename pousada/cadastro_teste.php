<?php //include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>

<style>
/* The Modal (background) */
.modal_teste {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 190px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content_teste {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 25%;
	height:10%;
	-moz-border-radius:7px;
	-webkit-border-radius:7px;
	border-radius:7px;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
<script>

function testeConfirmModal()
{
	// Get the modal
	var modal = document.getElementById('myModal');

	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	/*
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}*/
}
$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	
	testeConfirmModal();
});
</script>
<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<div style="margin-left:10px;">
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<div class="erros"></div>


<!-- Trigger/Open The Modal -->
<button id="myBtn">Open Modal</button>

<!-- The Modal -->
<div id="myModal" class="modal_teste" style="">

  <!-- Modal content -->
  <div class="modal-content_teste">
	<!--
		<span class="close">&times;</span>
	-->
	<div style="margin-top:5%;width:100%;">
		<div class=".btn-group pull-left" style="margin-left:0%;width:50%">
			<button class="btn" style="width:90%;" type="button"> Sim </button>
		</div>
		<div class=".btn-group pull-left" style="margin-left:0%;margin-right:0%;margin-top:0%;width:50%">
			<button class="btn" style="width:90%" type="button"> Não </button>
		</div>
	</div>	
  </div>
</div>





</body>
</html>





