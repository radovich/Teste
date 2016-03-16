<?php
ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);
include_once("classes/produto.php");

$Produto = new Produto();
$Produto->abreConexao();
$rsProduto = $Produto->retrieveByNome();
$qtdProduto = $rsProduto->num_rows();
$rsProduto->bind_result($id,$nome,$descricao,$preco);

$tabela  = "<tr><th colspan=6>PRODUTOS</th></tr>";
$tabela .= "<tr><td colspan=4>&nbsp;</td><td colspan=2 align=center><a href='produto_detail.php?acao=novo'>Inserir Novo</a></td></tr>";
$tabela .= "<tr><th>ID</th><th>NOME</th><th>DESCRIÇÃO</th><th>PREÇO</th><th>EDITAR</th><th>EXCLUIR</th></tr>";
while($rsProduto->fetch()) {
	$tabela .= "<tr><td>$id</td><td>$nome</td><td>$descricao</td><td>$preco</td>
	<td align=center><a href='produto_detail.php?acao=editar&id=$id'>Editar</a></td>
	<td align=center><a href='produto_detail.php?acao=excluir&id=$id'>Excluir</a></td></tr>";
}
$tabela .= "<tr><td colspan=4>&nbsp;</td><td colspan=2 align=center><a href='http://187.108.38.204/old/index.htm'>Retornar</a></td></tr>";

$Produto->fechaConexao();

echo "<br><br><br>";
echo "<center><table border=1 cellspacing=0>$tabela</table></center>";

?>
