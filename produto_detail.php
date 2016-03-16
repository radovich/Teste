<?php

ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);

include_once("classes/produto.php");

$acao = (isset($_GET['acao'])) ? $_GET['acao'] : 'novo';
$confirma = (isset($_POST['confirma'])) ? $_POST['confirma'] : FALSE;

$id=0;
$nome='';
$descricao='';
$preco='';
$Produto = new Produto();
$Produto->abreConexao();

$msg = "";
$readonly = " ";

$tituloBotao = "OK";
if ($acao == 'novo') {$tituloBotao = "INSERIR";}
if ($acao == 'editar') {$tituloBotao = "GRAVAR";}
if ($acao == 'excluir') {$tituloBotao = "EXCLUIR"; $readonly = " readonly ";}

if (!$confirma){
	if(isset($_GET['id'])) {$id = $_GET['id'];}
	$Produto->id = $id;
	$rsProduto = $Produto->retrieve();
	$rsProduto->bind_result($id,$nome,$descricao,$preco);
	$rsProduto->fetch();
	$confirma = TRUE;
} else {  // confirmado
	$acao = $_POST['acao'];
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$preco = $_POST['preco'];
	
	$Produto->id = $id;
	$Produto->nome = $nome;
	$Produto->descricao = $descricao;
	$Produto->preco = $preco;

	if ($acao == 'novo') {
		$id = $Produto->create();
		$Produto->id = $id;
		if ($id > 0) {
			$msg = "<br>Produto inserido com sucesso ($id)<br>";
		}
	}
	
	if ($acao == 'editar') {
		$qtd = $Produto->update();
		if ($qtd > 0) {
			$msg = "<br>Produto atualizado com sucesso ($id)<br>";
		}
	}
	
	if ($acao == 'excluir') {
		$qtd = $Produto->delet();
		if ($qtd > 0) {
			$msg = "<br>Produto excluido com sucesso ($id)<br>";
		}
	}
	
	$confirma = FALSE;
}
$Produto->fechaConexao();
?>

<html>

<head></head>
<body>

<center>
<table border=1 cellspacing=0>
<tr><th colspan=2><h1>DETALHE DO PRODUTO</h1></th></tr>
<form method=post>
<tr><th colspan=2>&nbsp; 
	<input type=hidden name=confirma id=confirma value=<?=$confirma?>></input>
	<input type=hidden name=acao id=acao value=<?=$acao?>></input>
	<?=$msg?>
</th></tr>

<tr><td>ID</td>			<td><input type=text name=id id=id value=<?=$id?> readonly ></input></td></tr>
<tr><td>NOME</td>		<td><input type=text name=nome id=nome value=<?=$nome?> <?=$readonly?>></input></td></tr>
<tr><td>DESCRICAO</td>		<td><input type=text name=descricao id=descricao value=<?=$descricao?> <?=$readonly?>></input></td></tr>
<tr><td>PRECO</td>	<td><input type=text name=preco id=preco value=<?=$preco?> <?=$readonly?> ></input></td></tr>

<tr><td><a href='produto.php'>Retornar</a></td><td><input type=submit name=botaoOK id=botaoOK value=<?=$tituloBotao?> ></input></td></tr>
</form>
</table>
</center>

</body>
</html>