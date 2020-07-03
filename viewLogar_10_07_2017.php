<?php session_start(); ?>
<?php include('CONFIG/config.php'); ?>
<?php include(DIR_DAO); ?>
<?php include(DIR_EMAIL.'class.phpmailer.php'); ?>
<?php include(DIR_ACTIONS.'genericFunction.php'); ?>
<?php include(DIR_CLASSES.'controllerUSUARIO.php');?>
<?php include(DIR_CLASSES.'controllerRESERVA.php');?>
<?php include(DIR_CLASSES.'controllerHOSPCONF.php');?>
<?php include(DIR_CLASSES.'controllerQUARTO.php');?>
<?php


function comparaData($data1,$data2,$idreserva)
{
	$data1 = explode("/",$data1);
	$datac = $data1[2]."-".$data1[1]."-".$data1[0];

	$str = "";
	//Comparando as Datas
	if(strtotime($datac) == strtotime($data2))
	{
		$str = "<div id='divCheckOut$idreserva'> <input type='checkbox' name='opcaoCheckOut[]' value='$idreserva' id='opcaoCheckOut[]' onmouseover=\"tooltip.pop(this, 'Seleciona checkout do hóspede!')\"></div><span id='mensagem$idreserva'></span>";
	}
	if(strtotime($datac) < strtotime($data2))
	{
		$str = "<div id='divCheckOut$idreserva'> <input type='checkbox' name='opcaoCheckOut[]' value='$idreserva' id='opcaoCheckOut[]' onmouseover=\"tooltip.pop(this, 'Seleciona checkout do hóspede!')\"></div><span id='mensagem$idreserva'></span>";
	}
	return $str;
}



switch($_POST['controller'])
{
	case 'logarUsuario':
		$retorno = array();
		$strSh = sha1($_POST["formLogin_senha"]);
		$strSenha = md5($strSh);

		$arr = array("usuario"=>$_POST['formLogin_user'],"senha"=>$strSenha);
		$controllerUSUARIO = new controllerUSUARIO('selectUsuario',$arr);

		if(empty($controllerUSUARIO->arrResposta))
		{
			session_destroy();
			$retorno["login"] = 0;
		}
		else
		{
			foreach($controllerUSUARIO->arrResposta as $dados)
			{
				if(trim($dados['usuario']) == trim($_POST['formLogin_user']) && trim($dados['senha']) == trim($strSenha))
				{
					$_SESSION['idusuario']   = $dados['idusuario'];
					$_SESSION['usuario'] 	 = $dados['usuario'];
					$_SESSION['idgrupo']     = $dados['idgrupo'];
					$_SESSION['nome']   	 = $dados['nome'];
					$retorno["login"]		 = 1;

					$url = split ("/", $REQUEST_URI);
					$_SESSION['URL'] = $url[1];

					//@Implementado Rotina de Log 24/09/2013
					$link	= mssql_connect(SERVER_SQL_SERVER,USUARIO_SQL_SERVER,SENHA_SQL_SERVER);
					$db 	= mssql_select_db(BASE_SQL_SERVER, $link); //Selecao do Banco de Dados
					$data	= date("Y-m-d H:i:s");
					$strSQL = "INSERT INTO LOGACESSO (usuario,idgrupo,idusuario,data,tipoacesso) values ('$dados[usuario]','$dados[idgrupo]','$dados[idusuario]','$data','E')";
					$objRS	= mssql_query($strSQL,$link);

					$msg  ="<strong>Mensagem automática do sistema</strong><br>";
					$msg .="<strong>Acesso do usuário:</strong> $dados[usuario]";
					$msg .='<img  height="200px"  width="200px;" src="http://177.70.26.45/beaverteste/hospedaaki_logo.png"></img>';

					$email = 'mjuppes@gmail.com';
					smtpmailer($email, 'mjuppes@gmail.com', 'Sistema Hospedaaki', 'Acesso de usuário',$msg);

					/*
						if($_POST['formLogin_user'] == "paulo")
						{
							session_destroy();
							$retorno["login"] = 9;
							echo json_encode($retorno);
							return;
						}
					*/
				}
				else
				{
					session_destroy();
					$retorno["login"] = 0;
				}
			}
		}
		echo json_encode($retorno);
	break;
	case 'montarLink':
		$_SESSION['link'] = array();
		$arr = array("idgrupo"=>$_SESSION['idgrupo']);
		$controllerUSUARIO = new controllerUSUARIO('selectPermissao',$arr);

		$arrTitle = array();
		$arrMenu  = array();

		foreach($controllerUSUARIO->arrResposta as $dados)
		{
				if(!in_array($dados['TITLE'],$arrTitle))
					array_push($arrTitle,($dados['TITLE'].'|'.$dados['ICONE'].'|'.$dados['IDMODULO']));

				$arrMenu[$dados['TITLE']][] = $dados['LABELMENU']."|".$dados['LINK'];
		}
		$templet = '<div class="navbar" style="min-width: 768px">';
		$templet .= '<div class="navbar-inner" style="height:20px" >';
		$templet .= '<a class="brand" title="Ir para a tela inicial" href="http://177.70.26.45/beaverpousada/inicial.php">
		<img  width=140 height=20 style="position:absolute;margin-top:-20px" src="http://177.70.26.45/beaverpousada/hospedaaki_logo.png"></img></a>';
		$templet .= '<div style="position: relative;margin-top:10px;margin-left:200px">';

		$templet .= '<div class=".btn-group pull-left"  style="padding-left:30px;padding-right:10px;padding-buttom:50px">';
			$templet .= '<button onclick="window.location=\'http://177.70.26.45/beaverpousada/inicial.php\'" type="button" style="padding: 5x 10px;" class="btn btn-menu" title="Inicial"><img src="http://177.70.26.45/beaverpousada/icones/voltar_inicial.png" width="40px" height="50px"><br>Inicial</button>';
		$templet .=	'</div>';
		foreach($arrTitle as $key => $value)
		{
				$arr = explode("|",$value);

				$label = $arr[0];
				$icone = $arr[1];
				$idmodulo  = $arr[2];

				$onclick = 'window.location=\'http://177.70.26.45/beaverpousada/pousada/painel_configuracoes.php?acao='.$idmodulo.'\'"';
				//$onclick = 'window.location=\'http://177.70.26.45/beaverpousada/pousada/painel_configuracoes.php\'"';
				$templet .= '<div class=".btn-group pull-left"  style="padding-left:30px;padding-right:10px;padding-buttom:50px">';
				$templet .= '<button onclick="'.$onclick.'" type="button" style="padding: 5x 10px;" class="btn btn-menu" title="'.$label.'"><img src="http://177.70.26.45/beaverpousada/icones/'.$icone.'" width="40px" height="50px"><br>'.$label.'</button>';
				$templet .=	'</div>';
		}

		$templet .= '</div>';
		
		
		$templet .= '<div class="btn-group pull-right" sty="">';
		$templet .= '<button onclick="exit();" type="button" style="padding: 5x 10px;" class="btn btn-menu" title="Sair"><img src="http://177.70.26.45/beaverpousada/icones/sair_.png" width="40px" height="50px"><br>Sair</button>';
		$templet .= '</div>';

		$templet .= '</div>';
		$templet .= '</div>';
		$templet .= '</div>';

		echo utf8_encode($templet);
	break;
	case 'tableCalendario':

		$Bd = new Bd(CONEXAO);

		$dadosConf = array();

		$strSQL = "select  (select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) 
						from DESCONTO WHERE idreserva = t.idreserva),
			(pq.valor*t.qtddias) as val,
		replace((pq.valor*t.qtddias)+	
  (select (case when SUM(p.valor) IS null then 0 else SUM(p.valor * v.quantidade) end) from VENDA v
				join PRODUTOS p on v.idproduto = p.idproduto
				 where v.idhospede = t.idhospede
				  and v.datavenda 
				 BETWEEN t.dtaI and t.dtaF
				 
				 )
				 
				  , '.', ',') as total,

			replace((pq.valor*t.qtddias) - (t.pago) , '.', ',') as restante,
			(case when t.pago is null then '0,00' else
			replace((t.pago) , '.', ',') end) as pago2,
			* from (
			  select (select SUM(valor) from pagamento where idreserva =  r.idreserva) as pago,
			  r.idpreco, DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias,q.idquarto,
			   hc.idhospconf,h.idhospede,q.nomequarto,
						CONVERT(VARCHAR(10),hc.datainicial,103) as datainicial,
						CONVERT(VARCHAR(10),r.datafinal,103) as datafinal
						,h.nome as nomehospede,r.observacao,
						(case when a.nomeagencia is null then 'Sem agência' else a.nomeagencia end) as nomeagencia ,
						(case when (CONVERT (date, GETUTCDATE()))  BETWEEN hc.datainicial and r.datafinal  then 'Confirmar hóspede hoje'
						  when hc.datainicial  < (CONVERT (date, GETUTCDATE())) then 'Hóspede não confirmado' 
						  when hc.datainicial  > (CONVERT (date, GETUTCDATE())) then 'Hóspede a ser confirmado' end) as mensagem,
						  (case when (CONVERT (date, GETUTCDATE()))  BETWEEN hc.datainicial and r.datafinal  then '#F6ACB6'
			  when hc.datainicial  < (CONVERT (date, GETUTCDATE())) then '#A9F5A9' 
			  when hc.datainicial  > (CONVERT (date, GETUTCDATE())) then '#F3E2A9' end) as cor,
			  (case when (CONVERT (date, GETUTCDATE()))  BETWEEN hc.datainicial and r.datafinal  then 'first'
			  when hc.datainicial  < (CONVERT (date, GETUTCDATE())) then 'first' 
			  when hc.datainicial  > (CONVERT (date, GETUTCDATE())) then 'third'
			   end) as posicao,r.idreserva,hc.confirmado,hc.datainicial as dtaI,r.datafinal as dtaF
						 from HOSPCONF hc
						  join HOSPEDE h on h.idhospede = hc.idhospede
						  join RESERVA r on r.idreserva = hc.idreserva
						  join QUARTO q on q.idquarto = r.idquarto
						  left join AGENCIA a on a.idagencia = h.idagencia
				)t 
				join PRECOQUARTO pq on pq.idpreco = t.idpreco
				where t.idreserva not in (select idreserva from cancelamento) ";
				
				if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
					$strSQL.=" and t.idquarto = ".$_POST['formSelectQuarto'];

				if(isset($_POST['formNome']) && !empty($_POST['formNome']))
					$strSQL.=" and t.nomehospede like '%".$_POST['formNome']."%'";

				
				$strSQL.=" order by t.datainicial,t.datafinal desc";
// echo $strSQL;
// return;
		$dadosConf = $Bd->execQuery($strSQL,true);
 		$Bd->closeConnect();

		$strTable1="";
		$strTable2="";
		$strTable3="";

		if(!empty($dadosConf))
		{
			foreach($dadosConf as $dados)
			{
				if($dados['posicao'] == "first")
				{
					$strTable1 .="<tr>";
					$strTable1 .="<td aling='center'><a href='pousada/historico_hospedes.php?idhospede=$dados[idhospede]'>$dados[nomehospede]</a></td>";
					$strTable1 .="<td aling='center'>$dados[datainicial]</td>";
					$strTable1 .="<td aling='center'>$dados[datafinal]</td>";

					if($dados['confirmado'] == "S")
						$strTable1 .="<td aling='center' style='background-color:#FA3E3E'>". comparaData($dados['datafinal'],date("Y-m-d"),$dados['idreserva']) ."</td>";

					if($dados['confirmado'] != "S")
						$strTable1 .="<td aling='center'>". comparaData($dados['datafinal'],date("Y-m-d"),$dados['idreserva'])."</td>";

					$strTable1 .="<td aling='center'>$dados[nomequarto]</td>";
					$strTable1 .="<td aling='center'>$dados[observacao]</td>";
					$strTable1 .="<td aling='center'>$dados[nomeagencia]</td>";

					if(!empty($dados['total']))
						$strTable1 .="<td aling='center'>$dados[total]</td>";
					else
						$strTable1 .="<td aling='center'>$dados[val]</td>";

					$strTable1 .="<td aling='center'>$dados[pago2]</td>";

					if($dados['confirmado'] == "S")
					{
						$strTable1 .="<td align='center'><strong><font color='green'>Confirmado  $teste</font></strong></td>";
					}
					else
					{
						$strTable1 .="<td align='center' >
						<div id='divCheckin$dados[idhospconf]'>
							<input type='checkbox' name='opcaoCheckIn[]' id='opcaoCheckIn[]' value='$dados[idhospconf]'>
								<a alt='Editar' title='Editar' href='pousada/cadastro_reserva.php?idreserva=$dados[idreserva]&editar=true' style='cursor:pointer'>
									<img width='25px' height='20px' title='Editar' src='http://177.70.26.45/beaverpousada/icones/editar.png'>
							</a>
						</div>
						<span id='mensagemCheckIn$dados[idhospconf]'></span>
						</td>";
					}
					
					$strTable1 .="<td align='center'>
						<a alt='Editar' title='Cancelar' href='pousada/cancelar_reserva.php?idreserva=$dados[idreserva]&editar=true' style='cursor:pointer'>
							Cancelar
						</a>
						</td>";
					$strTable1 .="</tr>";
				}

				if($dados['posicao'] == "third")
				{
					$strTable3 .="<tr>";
					$strTable3 .="<td aling='center'><a href='pousada/historico_hospedes.php?idhospede=$dados[idhospede]'>$dados[nomehospede]</a></td>";
					$strTable3 .="<td aling='center'>$dados[datainicial]</td>";
					$strTable3 .="<td aling='center'>$dados[datafinal]</td>";
					$strTable3 .="<td aling='center'>$dados[nomequarto]</td>";	
					$strTable3 .="<td aling='center'>$dados[observacao]</td>";
					$strTable3 .="<td aling='center'>$dados[nomeagencia]</td>";
					//$strTable3 .="<td aling='center'>$dados[total]</td>";
					
					if(!empty($dados['total']))
						$strTable3 .="<td aling='center'>$dados[total]</td>";
					else
						$strTable3 .="<td aling='center'>$dados[val]</td>";

					$strTable3 .="<td aling='center'>$dados[pago2]</td>";

					if($dados['confirmado'] == "S")
					{
						$strTable3 .="<td align='center'><font color='green' style='text-transform: lowercase;'>Confirmado</font></td>";
					}
					else
					{
						$strTable3 .="<td align='center'>
						<a alt='Editar' title='Editar' href='pousada/cadastro_reserva.php?idreserva=$dados[idreserva]&editar=true' style='cursor:pointer'>
							<img width='25px' height='20px' title='Editar' src='http://177.70.26.45/beaverpousada/icones/editar.png'>
						</a>
						</td>";

					}
					$strTable3 .="<td align='center'>
						<a alt='Editar' title='Cancelar' href='pousada/cancelar_reserva.php?idreserva=$dados[idreserva]&editar=true' style='cursor:pointer'>
							Cancelar
						</a>
					</td>";
					$strTable3 .="</tr>";
				}
			}
		}

		
	$testeString = '<p>
		<div class="wrapper fade-in" id="div1">
			<div>
				<div id="divteste">
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px" onclick="desabilitarLembrete(\'div1\')"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				</div>
			</div>
		</div>
		<div class="wrapper fade-in">
			<div class="ribbon-wrapper-green">
				<div class="ribbon-green">
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				 </div>
			</div>
		</div>
		<div class="wrapper fade-in">
			<div class="ribbon-wrapper-green">
				<div class="ribbon-green">
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				</div>
			</div>
		</div>
		<div class="wrapper fade-in">
			<div class="ribbon-wrapper-green">
				<div class="ribbon-green">
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				</div>
			</div>
		</div>
	</p>
	<p>
		<div class="wrapper fade-in" >
			<div>
				<div>
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				</div>
			</div>
		</div>
		<div class="wrapper fade-in">
			<div class="ribbon-wrapper-green">
				<div class="ribbon-green">
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				</div>
			</div>
		</div>
		<div class="wrapper fade-in">
			<div class="ribbon-wrapper-green">
				<div class="ribbon-green">
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				</div>
			</div>
		</div>
		<div class="wrapper fade-in">
			<div class="ribbon-wrapper-green">
				<div class="ribbon-green">
				<p style="text-align:right"><img src="http://177.70.26.45/beaverpousada/icones/excluir.png" width="20px" height="20px"></p>
				<p></p>
				<p>
				O objetivo da 
				transmitir ao leitor uma imagem daquilo que observamos.
				 como compor um retrato por meio de palavras.
				 </p>
				</div>
			</div>
		</div>
	</p>';
		$testeString = "";
		
		$strTable .="<ul class='nav nav-tabs'>";
		/*
			$strTable .="<li class='active'>";
			$strTable .="<a href='#lembrete' data-toggle='tab' style='border-radius: 8px;'>Lembretes</a>";
			$strTable .="</li>";
		*/
		
		//$strTable .="<li class='active'>";
		$strTable .="<li class='active'>";
		$strTable .="<a href='#first' data-toggle='tab' style='border-radius: 8px;'>Chegadas Hoje</a>";
		$strTable .="</li>";
		
		$strTable .="<li><a href='#second' data-toggle='tab' style='border-radius: 8px;'>Mapa de Reservas</a></li>";
		$strTable .="<li><a href='#third' data-toggle='tab' style='border-radius: 8px;'>Próximas Reservas</a></li>";
		$strTable .="</ul>";
		$strTable .="<div class='tab-content'>";
		
		//$strTable .="<div id='lembrete' class='tab-pane active'><p>";
		//$strTable .="$testeString";
		//$strTable .="</div>";
			$strTable .="<div id='first' class='tab-pane active'><p>";
			
			
			$strTable .= "
		<form action='' class='form-horizontal'>
			<fieldset class='moldura' style='width: 40%'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisar hóspede</strong></center></legend>
				<div class='control-group'>
					<label class='control-label' for='formNome'><strong>Nome:</strong></label>
					<div class='controls'>  
						<input type='text' class='input-xlarge' name='formNome' id='formNome'>
					</div>
				</div>

				<div class='control-group'>
					<label class='control-label' for='formSelectQuarto1'><strong>Quarto:<strong></label>
						<div class='controls'>
							<select id='formSelectQuarto1'  style='width:80%;' name='formSelectQuarto1' >
								<option value=''>- Selecione -</option>
								";
								
		$dadosQ = array();
		$strSQL = "select * from QUARTO where status is null order by nomequarto asc";
		$dadosQ = $Bd->execQuery($strSQL,true);

		
							foreach($dadosQ as $dados)
							{

								$strTable .= "<option value='$dados[idquarto]'>$dados[nomequarto]</option>";
							}
		$strTable .= "
							</select>
						</div>
				</div>";
				
				
				$strTable .= "
				
				<div class='form-actions form-background'>
					<button type='button' class='btn ' onclick='buscarInicial();' id='form_submit' name='form_submit'>
					<img width='25px' height='20px' src='icones/busca.png'>
					<strong>Pesquisar<strong>
					</button> 
				</div>
				
				
		</fieldset>
		</form>
		<br><br><br>";
			
			
			if($strTable1 == "")
			{
				

				$strTable .="<div class='alert' aling='center'>";
				$strTable .="<div align='center'>";
				$strTable .="<strong>Aviso!</strong> não existem registros!";
				$strTable .="</div></div>";
			}
			else
			{
				
				
				$strTable .= "<table id='aba' class='table table-striped   table-bordered table-condensed' width='100%'>";
				$strTable .="<thead><tr>";
				$strTable .="<th aling='center' width='20%'>Hóspede</th>";
				$strTable .= "<th width='10%'>Data inicial</th>";
				$strTable .= "<th width='10%'>Data final</th>";
				
				$strTable .= "<th width='10%'>Checkout</th>";
				$strTable .= "<th width='15%'>Quarto</th>";
				$strTable .="<th aling='center' width='10%'>Observação</th>";
				$strTable .="<th aling='center' width='10%'>Agência</th>";
				$strTable .="<th aling='center' width='5%'>Total</th>";
				$strTable .="<th aling='center' width='5%'>Pago</th>";
				$strTable .="<th aling='center' width='8%'>Check-In</th>";
				$strTable .="<th aling='center' width='8%'>Cancelar</th>";
				$strTable .="</tr></thead><tbody>";
				$strTable .="$strTable1";
				$strTable .="</tbody>";
				$strTable .="</table>";

				$strTable .='<form action="viewPousada.php" name="formInserirReserva" id="formInserirReserva" method="POST" class="form-horizontal" enctype="multipart/form-data">';
				$strTable .='<fieldset>';
				$strTable .='<div class="form-actions form-background">';
				$strTable .='<button type="button" onclick="getOpcoes()" class="btn btn-primary" id="formReserva_submit" name="formReserva_submit">Confirmar</button>  ';
				$strTable .='</div>';
				$strTable .='</fieldset> ';
				$strTable .='</form>';
			}
			$strTable .="</div></p>";


			$strTable .="<div id='third' class='tab-pane'><p>";
			
			if($strTable3 == "")
			{
				$strTable .="<div class='alert' aling='center'>";
				$strTable .="<div align='center'>";
				$strTable .="<strong>Aviso!</strong> não existem registros!";
				$strTable .="</div></div>";
				
				
				
			}
			else
			{
				
				
				
				
				$strTable .= "<table id='aba' class='table table-striped   table-bordered table-condensed' width='100%'>";
				$strTable .="<thead><tr>";
				$strTable .="<th aling='center' width='20%'>Hóspede</th>";
				$strTable .= "<th width='10%'>Data inicial</th>";
				$strTable .= "<th width='10%'>Data final</th>";
				$strTable .= "<th width='15%'>Quarto</th>";
				$strTable .="<th aling='center' width='20%'>Observação</th>";
				$strTable .="<th aling='center' width='10%'>Agência</th>";
				$strTable .="<th aling='center' width='5%'>Total</th>";
				$strTable .="<th aling='center' width='5%'>Pago</th>";
				$strTable .="<th aling='center' width='8%'>Editar</th>";
				$strTable .="<th aling='center' width='8%'>Cancelar</th>";
				$strTable .="</tr></thead><tbody>";

				$strTable .="$strTable3";
				$strTable .="</tbody>";
				$strTable .="</table>";
			}

			$strTable .="</div></p>";
		$strTable .="<div id='second' class='tab-pane'><p>";

		$Bd = new Bd(CONEXAO);

		
		$arrMes = array('01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março',
					'04'=>'Abril','05'=>'Maio','06'=>'Junho','07'=>'Julho','08'=>'Agosto', 
					'09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro');

		$strTable .= "
		<form action='' class='form-horizontal'>
			<fieldset class='moldura' style='width: 50%'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de calendário</strong></center></legend>
				<div class='control-group'>
					<label class='control-label' for='formSelectAno'><strong>Ano:<strong></label>
						<div class='controls'>
							<select id='formSelectAno' style='width:80%;' name='formSelectAno'>
								<option value=''>- Selecione -</option>
								<option value='2015'>2015</option>
								<option value='2016'>2016</option>
								<option value='2017'>2017</option>
								<option value='2018'>2018</option>
								<option value='2019'>2019</option>
								<option value='2020'>2020</option>

			
							</select>
						</div>
				</div>
				<div class='control-group'>
					<label class='control-label' for='formSelectMes'><strong>Mês:<strong></label>
						<div class='controls'>
							<select id='formSelectMes' style='width:80%;' name='formSelectMes'>
								<option value=''>- Selecione -</option>
								";
								
							foreach($arrMes as $key => $value)
							{
								$strTable .= "<option value='$key '>$value</option>";
							}
		$strTable .= "
							</select>
						</div>
				</div>
				
				
				
				
				<div class='control-group'>
					<label class='control-label' for='formSelectQuarto'><strong>Quarto:<strong></label>
						<div class='controls'>
							<select id='formSelectQuarto' style='width:80%;' name='formSelectQuarto'>
								<option value=''>- Selecione -</option>
								";

		$dadosQ = array();
		$strSQL = "select * from QUARTO where status is null order by nomequarto asc";
		$dadosQ = $Bd->execQuery($strSQL,true);

		foreach($dadosQ as $dados)
		{
				$strTable .= "<option value='$dados[idquarto] '>$dados[nomequarto]</option>";
		}

		$strTable .= "
							</select>
						</div>
				</div>";

				$strTable .= "
				<div class='form-actions form-background'>
					<button type='button' class='btn ' onclick='gerarCalendarioReserva();' id='form_submit' name='form_submit'>
					<img width='25px' height='20px' src='icones/busca.png'>
					<strong>Pesquisar<strong>
					</button> 
				</div>
		</fieldset>
		</form>
		<br>";
		
	$strTable .= " <fieldset class='moldura fieldAlerta' style='width: 60%'>";
	$strTable .= "<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Status do Mapa</strong></center></legend>";

		 	$strTable .= "<table id='curso' class='table table-striped   table-bordered table-condensed' >";
			$strTable .="<tbody>";
			$strTable .="<tr>
							<td><div class='panel-liberado'>&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
							<td>Liberado</td>
						</tr>
						<tr>
							<td><div class='panel-aguardandoconfirmacao'>&nbsp;&nbsp;&nbsp;&nbsp;  </div></td>
							<td>Reservado / Aguardando confirmação</td>
						</tr>
						<tr>
							<td><div class='panel-confirmado'>&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
							<td>Ocupado</td>
						</tr>
						<!--
						<tr>
							<td><div class='panel-saiuquarto'>&nbsp;&nbsp;&nbsp;&nbsp;  </div></td>
							<td>Saiu do quarto</td>
						</tr>
						-->
						<tr>
							<td><div class='panel-manutencaoquarto'>&nbsp;&nbsp;&nbsp;&nbsp;  </div></td>
							<td>Quarto em manutenção</td>
						</tr>
						
						
					</tbody>
			</table>";
			$strTable .= "</fieldset><br>";
	

		
		$strTable .="<div id='tabela' style='width:99%;margin:0px 0.5%;'></div>";

		//Grid dois 
		$dadosQuarto = array();

		$strSQL = "select idquarto, nomequarto, qtdvaga,localizacao,itens from QUARTO";
		$dadosQuarto = $Bd->execQuery($strSQL,true);
		
		if(empty($dadosQuarto))
		{
			return false;
		}
		/*
		@Verificar a função da tabela dois, retirada pois as informações estão na lupa
		02/08/2016 09:19
		
		
		$strTable .= "<table  id='quarto'  class='table table-striped  table-bordered  table-condensed'>";
		$strTable .="<thead><tr>	<th aling='center'  width='32%'>Quarto</th>";
		$strTable .="<th aling='center' width='20%'>Quantidade geral de vagas</th>";
		$strTable .="<th aling='center'  width='30%'>Observação</th>";
		$strTable .="<th aling='center'  width='30%'>Itens</th>";
		$strTable .="</tr></thead><tbody>";

		foreach($dadosQuarto as $dados)
		{
				$strTable .="<td  align='center'><a style='cursor:pointer' ondblclick=changeNumQuarto($dados[idquarto])>".utf8_decode($dados['nomequarto'])."</a></td>";
				$strTable .="<td  align='center'><input type='text' disabled style='width:5%;' onblur='sendNewValue($dados[idquarto])'  name='formQtd$dados[idquarto]' id='formQtd$dados[idquarto]' value='$dados[qtdvaga]'></td>";
				
				$strTable .="<td  align='center'>$dados[localizacao]</strong></td>";
				
				$arrItens =  explode("|",$dados['itens']);
				$strItens = "";

				foreach($arrItens as $key => $value)
				{
					switch($value)
					{
						case '1': $item = "TV";
							break;
						case '2': $item = "Ventilador";
							break;
						case '3': $item = "Frigobar";
							break;
						case '4': $item = "Spliter";
							break;
						case '5': $item = "Aquecedor";
							break;
						case '6': $item = "Fogão";
							break;
						default: $item = "";
					}

					if(empty($strItens))
						$strItens .= $item;
					else
						$strItens .= ",".$item;
				}

				$strTable .="<td  align='center'>$strItens</td>";
				$strTable .="</tr>";
		}

		$strTable .="</tbody>";
		$strTable .="</table>";
		*/
		$strTable .="</div>";
		
		echo utf8_encode($strTable);
		return;

		$dadosQuarto = array();

		$strSQL = " select r.idreserva, (select count(*) from reserva where idquarto = r.idquarto) as qtd,q.idquarto,r.idquarto,nomequarto,	CONVERT(VARCHAR(10),r.datafinal,111) as datafinal1,
						CONVERT(VARCHAR(10),r.datainicial,103) as datainicial,CONVERT(VARCHAR(10),r.datafinal,103) as datafinal2
						from reserva r inner join quarto q on r.idquarto = q.idquarto order by  r.datainicial,r.datafinal desc";

		$dadosQuarto = $Bd->execQuery($strSQL,true);
 		$Bd->closeConnect();

		if(empty($dadosQuarto))
		{
			$strTable .="<div class='alert' aling='center'>";
			$strTable .="<div align='center'>";
			$strTable .="<strong>Aviso!</strong> não existem registros de reserva cadastrados!";
			$strTable .="</div></div>";
			echo utf8_encode($strTable);
			return false;
			$strTable = "<table class='table'>";
			$strTable .="<thead><tr><th>Quarto</th>";
			$strTable .="<tr>";
			$strTable .="<td><strong>Nenhum quarto encontrado!</strong></td>";
			$strTable .="</tr>";
			$strTable .="</tbody>";
			$strTable .="</table>";	
			echo $strTable;
			return false;
		}

		$strTable .= "<table class='table   table-bordered table-condensed' >";
		$strTable .="<thead>";
		$strTable .= "<tr><th width='32.5%'>Quarto</th>";
		$strTable .="<th aling='center' width='32.5%'>Data inicial</th>";
		$strTable .="<th aling='center' width='13%'>Data de liberação do quarto</th>";
		$strTable .="<th aling='center' width='20%'>Dia da semana</th>";
		$strTable .="<th aling='center' width='5%'></th>";
		$strTable .="</tr></thead><tbody>";

		
		$dataAtual = date("d/m/Y");
		foreach($dadosQuarto as $dados)
		{
		
				if($dataAtual == $dados['datafinal2'])
				{
					$strTable .="<tr class='trlabel' title='Data de liberção é hoje' >";
					$strTable .="<td aling='center' bgcolor='#F6ACB6'><a href='pousada/consulta_reservas.php?idquarto=$dados[idquarto]'>$dados[nomequarto]</a></td>";
					$strTable .="<td aling='center' bgcolor='#F6ACB6'>$dados[datainicial]</td>";
					$strTable .="<td aling='center' bgcolor='#F6ACB6'><span >$dados[datafinal2]</span></td>";
					$strTable .="<td aling='center' bgcolor='#F6ACB6'>".getDiaSemana($dados['datafinal1'])."</td>";
					$strTable .="<td align='center' bgcolor='#F6ACB6'>
						<a href='#myModal'  role='button'  onclick='visualizarReserva($dados[idreserva])' title='Visualizar'  data-toggle='modal'>
						<img src='http://177.70.26.45/beaverpousada/icones/visualizar.png' width='20px' height='20px' title='Visualizar'>
						</a>";
					$strTable .="</td>";
					$strTable .="</tr>";
				}
				else
				{
					$strTable .="<tr>";
					$strTable .="<td aling='center'><strong><a href='pousada/consulta_reservas.php?idquarto=$dados[idquarto]'>$dados[nomequarto]</a></strong></td>";
					$strTable .="<td aling='center'>$dados[datainicial]</td>";
					$strTable .="<td aling='center'><span >$dados[datafinal2]</span></td>";
					$strTable .="<td aling='center'>".getDiaSemana($dados['datafinal1'])."</td>";
					$strTable .="<td align='center'>
						<a href='#myModal'  role='button'  onclick='visualizarReserva($dados[idreserva])' title='Visualizar'  data-toggle='modal'>
						<img src='http://177.70.26.45/beaverpousada/icones/visualizar.png' width='20px' height='20px' title='Visualizar'>
						</a>";
					$strTable .="</td>";
					$strTable .="</tr>";
				}
		}
		$strTable .="</tbody>";
		$strTable .="</table>";	
		echo utf8_encode($strTable);
		return;

		$Bd = new Bd(CONEXAO);
		$dadosQuarto = array();

		$strSQL = " select r.idquarto,nomequarto,CONVERT(VARCHAR(10),r.datainicial,103) as datainicial, 
			CONVERT(VARCHAR(10),r.datafinal,103) as datafinal,r.opcao
				from reserva r inner join quarto q on r.idquarto = q.idquarto ";

		$dadosQuarto = $Bd->execQuery($strSQL,true);



		$dadosRecordSet = array();

		$strSQL = " select nomequarto,CONVERT(VARCHAR(10),GETDATE(),111) as data1,
							CONVERT(VARCHAR(10),DATEADD(DAY ,1,GETDATE()),111) as data2,
							 CONVERT(VARCHAR(10),DATEADD(DAY ,2,GETDATE()),111) as data3,
							 CONVERT(VARCHAR(10),DATEADD(DAY ,3,GETDATE()),111) as data4,
							 CONVERT(VARCHAR(10),DATEADD(DAY ,4,GETDATE()),111) as data5,
							 CONVERT(VARCHAR(10),DATEADD(DAY ,5,GETDATE()),111) as data6,
							 CONVERT(VARCHAR(10),DATEADD(DAY ,6,GETDATE()),111) as data7 from quarto ";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$strTable = "<table class='table'>";
		$strTable .="<thead><tr><th>Quarto</th>";
		$strTable .="<th>".getDiaSemana($dadosRecordSet[0]['data1'])."</th>";
		$strTable .="<th>".getDiaSemana($dadosRecordSet[0]['data2'])."</th>";
		$strTable .="<th>".getDiaSemana($dadosRecordSet[0]['data3'])."</th>";
		$strTable .="<th>".getDiaSemana($dadosRecordSet[0]['data4'])."</th>";
		$strTable .="<th>".getDiaSemana($dadosRecordSet[0]['data5'])."</th>";
		$strTable .="<th>".getDiaSemana($dadosRecordSet[0]['data6'])."</th>";
		$strTable .="<th>".getDiaSemana($dadosRecordSet[0]['data7'])."</th>";
		$strTable .="</tr></thead><tbody>";

		$dadosRecordSet = array();
		$strSQL = " select idquarto,nomequarto, CONVERT(VARCHAR(10),GETDATE(),103) as data1,
							CONVERT(VARCHAR(10),DATEADD (DAY ,1,GETDATE()),103) as data2,
							CONVERT(VARCHAR(10),DATEADD (DAY ,2,GETDATE()),103) as data3,
							CONVERT(VARCHAR(10),DATEADD (DAY ,3,GETDATE()),103) as data4,
							CONVERT(VARCHAR(10),DATEADD (DAY ,4,GETDATE()),103) as data5,
							CONVERT(VARCHAR(10),DATEADD (DAY ,5,GETDATE()),103) as data6,
							CONVERT(VARCHAR(10),DATEADD (DAY ,6,GETDATE()),103) as data7 from quarto";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();

		$arrValores = array();
		foreach($dadosQuarto as $d)
		{
			$arrValores[$d["idquarto"]][$d["nomequarto"]][$d["datainicial"]] =  $d["opcao"];
			$arrValores[$d["idquarto"]][$d["nomequarto"]][$d["datafinal"]] =  $d["opcao"];
		}

		foreach($dadosRecordSet as $dados)
		{
			$strTable .="<tr>";
			$strTable .="<td><strong>$dados[nomequarto]</strong></td>";

			if(!empty($arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data1']]))
			{
				$opcao = $arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data1']];
				if($opcao == "C")
					$strTable .="<td bgcolor='FF3300'>$dados[data1]</td>";
				if($opcao == "S")
					$strTable .="<td bgcolor='6699FF'>$dados[data1]</td>";
			}
			else
				$strTable .="<td>$dados[data1]</td>";

			if(!empty($arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data2']]))
			{
				$opcao = $arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data2']];
				if($opcao == "C")
					$strTable .="<td bgcolor='FF3300'>$dados[data2]</td>";
				if($opcao == "S")
					$strTable .="<td bgcolor='6699FF'>$dados[data2]</td>";
			}
			else
				$strTable .="<td>$dados[data2]</td>";

			if(!empty($arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data3']]))
			{
				$opcao = $arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data3']];
				if($opcao == "C")
					$strTable .="<td bgcolor='FF3300'>$dados[data3]</td>";
				if($opcao == "S")
					$strTable .="<td bgcolor='6699FF'>$dados[data3]</td>";
			}
			else
				$strTable .="<td>$dados[data3]</td>";

			if(!empty($arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data4']]))
			{
				$opcao = $arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data4']];
				if($opcao == "C")
					$strTable .="<td bgcolor='FF3300'>$dados[data4]</td>";
				if($opcao == "S")
					$strTable .="<td bgcolor='6699FF'>$dados[data4]</td>";
			}
			else
				$strTable .="<td>$dados[data4]</td>";

			if(!empty($arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data5']]))
			{
				$opcao = $arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data5']];
				if($opcao == "C")
					$strTable .="<td bgcolor='FF3300'>$dados[data5]</td>";
				if($opcao == "S")
					$strTable .="<td bgcolor='6699FF'>$dados[data5]</td>";
			}
			else
				$strTable .="<td>$dados[data5]</td>";

			if(!empty($arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data6']]))
			{
				$opcao = $arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data6']];
				if($opcao == "C")
					$strTable .="<td bgcolor='FF3300'>$dados[data6]</td>";
				if($opcao == "S")
					$strTable .="<td bgcolor='6699FF'>$dados[data6]</td>";
			}
			else
				$strTable .="<td>$dados[data6]</td>";

			if(!empty($arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data7']]))
			{
				$opcao = $arrValores[$dados['idquarto']][$dados['nomequarto']][$dados['data7']];
				if($opcao == "C")
					$strTable .="<td bgcolor='FF3300'>$dados[data7]</td>";
				if($opcao == "S")
					$strTable .="<td bgcolor='6699FF'>$dados[data7]</td>";
			}
			else
				$strTable .="<td>$dados[data7]</td>";
			$strTable .="</tr>";
		}
		$strTable .="</tbody>";
		$strTable .="</table>";
		echo utf8_encode($strTable);
	break;
	case 'selectReservaAndamento':
		$controllerRESERVA = new controllerRESERVA('selectReservaAndamento');
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'checkIn':
		$arr = array("idhospconf"=>$_POST['idhospconf'],"confirmado"=>"S");
		$controllerHOSPCONF = new controllerHOSPCONF('update',$arr);
		echo $controllerHOSPCONF->resposta;
	break;
	case 'novoQtdQuarto':
		$arr = array("qtdvaga"=>$_POST["qdt"],
				"idquarto"=>$_POST["idquarto"]);

		$controllerQUARTO = new controllerQUARTO('update',$arr);
		echo $controllerQUARTO->resposta;
	break;
	case'montarCalendario':
		
		foreach($controllerRESERVA->arrResposta as $dados)
		{
			echo $dados['dataInicial']." ".$dados['dataFinal'];
		}
		
		
		$ultimoDia = date('t', mktime(0, 0, 0, 5, 5, 2014));

		
		$tabela.="<style>
					table
					{
			
					}
					table,td,tr
					{
						border:1px solid black;
					}
					.teste
					{
						bgcolor= red
					}
					.fundo
					{
						background-color:#DCDCDC
					}
				   </style>";


		$tabela .="<table id='curso' width='100%'>";
			$tabela .="<thead >";
				$tabela.="<tr class='fundo'>";
					$tabela.= utf8_encode("<th style='text-align: center;' colspan='7'>Relatório de hóspedes</th>");
				$tabela.="</tr>";
			$tabela.="</thead>";
			$tabela.="<tbody>";

			for($i=0;$i<$ultimoDia;$i++)
			{
				$dia = $i+1;
				if($i< 7)
					$semana1.="<td align='center'>".$dia."/05/2014</td>";
				if($i< 14 && $i >=7)
					$semana2.="<td align='center'>".$dia."/05/2014</td>";
				if($i< 21 && $i  >=14)
					$semana3.="<td bgcolor='red' align='center'>".$dia."/05/2014</td>";
				if($i<= 27 && $i  >=21)
					$semana4.="<td align='center'>".$dia."/05/2014</td>";
				if($i<= 31 && $i  >=28)
					$semana5.="<td align='center'>".$dia."/05/2014</td>";
			}
			$tabela.="<tr>";
				$tabela.=$semana1;
			$tabela.="</tr>";
			$tabela.="<tr>";
				$tabela.=$semana2;
			$tabela.="</tr>";
			$tabela.="<tr>";
				$tabela.=$semana3;
			$tabela.="</tr>";
			$tabela.="<tr>";
				$tabela.=$semana4;
			$tabela.="</tr>";
			$tabela.="<tr>";
				$tabela.=$semana5;
			$tabela.="</tr>";

			$tabela.="</tbody>";
		$tabela.="</table>";
		echo $tabela;
	break;
	default:
}
?>
