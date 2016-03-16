<?php

ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);

include_once("classes/pedido.php");
include_once("classes/produto.php");
include_once("classes/cliente.php");

$acao = (isset($_GET['acao'])) ? $_GET['acao'] : 'novo';
$confirma = (isset($_POST['confirma'])) ? $_POST['confirma'] : FALSE;
$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
$id_cliente = (isset($_POST['id_cliente'])) ? $_POST['id_cliente'] : 0;
$produto = (isset($_POST['id_produto'])) ? $_POST['id_produto'] : '0|0';
$produto = explode('|', $produto);
$id_produto = $produto[0];
$sel_preco = $produto[1];
$num_pedido = (isset($_POST['num_pedido'])) ? $_POST['num_pedido'] : 0;
$quantidade = (isset($_POST['quantidade'])) ? $_POST['quantidade'] : 0;


$cliente = new Cliente();
$produto = new Produto();
$Pedido  = new Pedido();

/*
$id=0;
$num_pedido='';
$quantidade='';
$valor='';
$quantidade='';
*/
$msg = "";
$readonly = " ";


$tituloBotao = "OK";
if ($acao == 'novo') {$tituloBotao = "INSERIR";}
if ($acao == 'editar') {$tituloBotao = "GRAVAR";}
if ($acao == 'excluir') {$tituloBotao = "EXCLUIR"; $readonly = " readonly ";}


$Pedido->abreConexao();
if (!$confirma){
	if(isset($_GET['id'])) {$id = $_GET['id'];}
	$Pedido->id = $id;
	$rsPedido = $Pedido->retrieve();
	$rsPedido->bind_result($id, $num_pedido, $id_produto, $id_cliente, $quantidade, $preco, $valor, $nome_cli, $nome_pro);
	$rsPedido->fetch();
	$confirma = TRUE;
} else {  // confirmado
	$acao = $_POST['acao'];
	$id = $_POST['id'];
	$num_pedido = $_POST['num_pedido'];
	$quantidade = $_POST['quantidade'];
	$preco = $sel_preco;
	$valor = $preco * $quantidade;
	
	$Pedido->id = $id;
	$Pedido->num_pedido = $num_pedido;
	$Pedido->id_cliente = $id_cliente;
	$Pedido->id_produto = $id_produto;
	$Pedido->preco = $preco;
	$Pedido->quantidade = $quantidade;
	$Pedido->valor = $valor;

	if ($acao == 'novo') {
		$id = $Pedido->create();
		$Pedido->id = $id;
		if ($id > 0) {
			$msg = "<br>Item do pedido inserido com sucesso ($id)<br>";
		}
	}
	
	if ($acao == 'editar') {
		$qtd = $Pedido->update();
		if ($qtd > 0) {
			$msg = "<br>Item do pedido atualizado com sucesso ($id)<br>";
		}
	}
	
	if ($acao == 'excluir') {
		$qtd = $Pedido->delet();
		if ($qtd > 0) {
			$msg = "<br>Item do pedido excluido com sucesso ($id)<br>";
		}
	}
	
	$confirma = FALSE;
}

$cliente->abreConexao();
$rsCliente = $cliente->retrieveByNome();
$rsCliente->bind_result($id,$nome,$email,$telefone);
$sel_cli = "<select name=id_cliente>\n";
while ($rsCliente->fetch()){
	$sel = ($id_cliente == $id) ? "selected" : "";
	$sel_cli .= "	<option $sel value=$id>$nome ($id)</option>\n";
}
$sel_cli .= "</select>\n";   //echo $sel_cli;


$produto->abreConexao();
$rsProduto = $produto->retrieveByNome();
$rsProduto->bind_result($id,$nome,$descricao,$preco);
$sel_pro = "<select name=id_produto>\n";
while ($rsProduto->fetch()){
	$sel = ($id_produto == $id) ? "selected" : "";
	$sel_pro .= "	<option $sel value='$id|$preco'>$nome ($id)</option>\n";
}
$sel_pro .= "</select>\n";   //echo $sel_pro;


$Pedido->fechaConexao();
?>

<html>

<head></head>
<body>

<center>
<table border=1 cellspacing=0>
<tr><th colspan=2><h1>DETALHE DO PEDIDO</h1></th></tr>
<form method=post>
<tr><th colspan=2>&nbsp; 
	<input type=hidden name=confirma id=confirma value=<?=$confirma?>></input>
	<input type=hidden name=acao id=acao value=<?=$acao?>></input>
	<?=$msg?>
</th></tr>

<tr><td>ID</td>				<td><input type=text name=id id=id value=<?=$id?> readonly ></input></td></tr>
<tr><td>NUMERO</td>			<td><input type=text name=num_pedido id=num_pedido value=<?=$num_pedido?> <?=$readonly?> ></input></td></tr>
<tr><td>CLIENTE</td>		<td><?=$sel_cli?></td></tr>
<tr><td>PRODUTO</td>		<td><?=$sel_pro?></td></tr>
<tr><td>QUANTIDADE</td>		<td><input type=text name=quantidade id=quantidade value=<?=$quantidade?> <?=$readonly?> ></input></td></tr>
<tr><td>PRECO</td>			<td><input type=text name=preco id=preco value=<?=$preco?> readonly ></input></td></tr>
<tr><td>VALOR</td>			<td><input type=text name=valor id=valor value=<?=$valor?> readonly ></input></td></tr>

<tr><td><a href='pedido.php'>Retornar</a></td><td><input type=submit name=botaoOK id=botaoOK value=<?=$tituloBotao?> ></input></td></tr>
</form>
</table>
</center>

</body>
</html>