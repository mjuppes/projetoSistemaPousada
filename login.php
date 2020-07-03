<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<link rel="shortcut icon" href="http://177.70.26.45/beaverPousada/favicon.ico">
	<script src="js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/campos.focus.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.form.js" type="text/javascript" charset="utf-8"></script>

	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	
	

	<?php
		if(isset($_SESSION['idusuario']))
		{
			include('CONFIG/config.php');
			//@Implementado Rotina de Log 07/03/2014
			$link = mssql_connect(SERVER_SQL_SERVER,USUARIO_SQL_SERVER,SENHA_SQL_SERVER);
			$db = mssql_select_db(BASE_SQL_SERVER, $link); //Selecao do Banco de Dados
			$data = date("Y-m-d H:i:s");
			$strSQL = "INSERT INTO LOGACESSO (usuario,idgrupo,data,tipoacesso) values ('$_SESSION[usuario]','$_SESSION[idgrupo]','$data','S')";
			$objRS = mssql_query($strSQL,$link);
		}
		session_destroy();
	?>
<style type="text/css">
      /* Override some defaults */
      html, body {
       

      }
      body {
        padding-top: 40px; 
      }
      .container {
        width: 300px;
      }

      /* The white background content wrapper */
      .container > .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; 
        -webkit-border-radius: 10px 10px 10px 10px;
           -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
			border: 3px solid black;
      }

	  .login-form {
		margin-left: 65px;
	  }

	  legend {
		margin-right: -50px;
		font-weight: bold;
	  	color: #404040;
	  }
	
	body
	{
		width: 100%;
		height: 100%;
		/*background: url(images.jpg) no-repeat center top fixed;*/
		/*background: url(18122_x1.jpg) no-repeat center top fixed;*/
		background-color: #add8e6;
		padding-top: 40px; 
		background-repeat: no-repeat;
		-moz-background-size: 100% 100%;
		-webkit-background-size: 100% 100%;
		background-size: 100% 100%;
	}
	

}
</style>
<link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
<script type="text/javascript">
	$(document).ready( function () {
		var objParametros = eval({'controller' : 'logarUsuario'});
		$.camposFocus();	
		
		$("#formLogin_user").focus();
		$('#formLogin').ajaxForm({ 
			dataType:  'json',
			data : objParametros,
			success: function (data)
			{
				switch (data.login)
				{
					case 1:
						//alert("O sistema possui novas atualizações por favor pressione a tecla citrl e f5 juntas!")
						location.href = "inicial.php";
					break;
					case 9:
						alert("Problemas com acesso a conta contate o administrador (51)8515-8600!");
					break;
					default:
						$("#formLogin").resetForm();
						$("#formLogin_user").focus();
						alert("Usuário ou senha inválidos.");
					break;
				}
			}
		}); 
	});
</script>
</head>
<body  style="overflow-X: hidden;overflow-Y: hidden;";>

	<div class="container">
		<div class="content">
		  <div class="row">
			<div class="login-form">
				<div style="position: relative;margin-top:30px; margin-left:">
					<img   src="http://177.70.26.45/beaverpousada/beaver-room-vertical-transparente.png"></img>
					<!--<a href="#" class="mbri-laptop mbr-iconfont mbr-iconfont-menu navbar-logo" style="font-size: 119px;color:rgb(39, 170, 224);"></a>-->
				</div>
				<br>
			  <div class="erro_login"></div>
			  <form action="viewLogar.php" name="formLogin" id="formLogin" method="POST">
				<fieldset>
				  <div class="clearfix">
					<input type="text"  name="formLogin_user" id="formLogin_user" placeholder="Login" >
				  </div>
				  <div class="clearfix">
					<input type="password"  name="formLogin_senha" id="formLogin_senha" placeholder="Senha" >
				  </div>
				  <img src="icones/LoginIcon.png"  width=50px height=25px style="z-index:1;margin-left:35px">
				  <button class="btn primary" id="formLogin_submit" type="submit">Entrar</button>
				</fieldset>
			  </form>
			</div>
		  </div>
		</div>
	</div>
</body>
</html>





