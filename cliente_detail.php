<?php

ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);

include_once("classes/cliente.php");

$acao = (isset($_GET['acao'])) ? $_GET['acao'] : 'novo';
$confirma = (isset($_POST['confirma'])) ? $_POST['confirma'] : FALSE;

$id=0;
$nome='';
$email='';
$telefone='';
$Cliente = new Cliente();
$Cliente->abreConexao();

$msg = "";
$readonly = " ";

$tituloBotao = "OK";
if ($acao == 'novo') {$tituloBotao = "INSERIR";}
if ($acao == 'editar') {$tituloBotao = "GRAVAR";}
if ($acao == 'excluir') {$tituloBotao = "EXCLUIR"; $readonly = " readonly ";}

if (!$confirma){
	if(isset($_GET['id'])) {$id = $_GET['id'];}
	$Cliente->id = $id;
	$rsCliente = $Cliente->retrieve();
	$rsCliente->bind_result($id,$nome,$email,$telefone);
	$rsCliente->fetch();
	$confirma = TRUE;
} else {  // confirmado
	$acao = $_POST['acao'];
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	
	$Cliente->id = $id;
	$Cliente->nome = $nome;
	$Cliente->email = $email;
	$Cliente->telefone = $telefone;

	if ($acao == 'novo') {
		$id = $Cliente->create();
		$Cliente->id = $id;
		if ($id > 0) {
			$msg = "<br>Cliente inserido com sucesso ($id)<br>";
		}
	}
	
	if ($acao == 'editar') {
		$qtd = $Cliente->update();
		if ($qtd > 0) {
			$msg = "<br>Cliente atualizado com sucesso ($id)<br>";
		}
	}
	
	if ($acao == 'excluir') {
		$qtd = $Cliente->delet();
		if ($qtd > 0) {
			$msg = "<br>Cliente excluido com sucesso ($id)<br>";
		}
	}
	
	$confirma = FALSE;
}
$Cliente->fechaConexao();
?>

<html>

<head></head>
<body>

<center>
<table border=1 cellspacing=0>
<tr><th colspan=2><h1>DETALHE DO CLIENTE</h1></th></tr>
<form method=post>
<tr><th colspan=2>&nbsp; 
	<input type=hidden name=confirma id=confirma value=<?=$confirma?>></input>
	<input type=hidden name=acao id=acao value=<?=$acao?>></input>
	<?=$msg?>
</th></tr>

<tr><td>ID</td>			<td><input type=text name=id id=id value=<?=$id?> readonly ></input></td></tr>
<tr><td>NOME</td>		<td><input type=text name=nome id=nome value=<?=$nome?> <?=$readonly?>></input></td></tr>
<tr><td>EMAIL</td>		<td><input type=text name=email id=email value=<?=$email?> <?=$readonly?>></input></td></tr>
<tr><td>TELEFONE</td>	<td><input type=text name=telefone id=telefone value=<?=$telefone?> <?=$readonly?> ></input></td></tr>

<tr><td><a href='cliente.php'>Retornar</a></td><td><input type=submit name=botaoOK id=botaoOK value=<?=$tituloBotao?> ></input></td></tr>
</form>
</table>
</center>

</body>
</html>