<?php
ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);
include_once("classes/pedido.php");

$Pedido = new Pedido();
$Pedido->abreConexao();
$rsPedido = $Pedido->retrieveAll();
$qtdPedido = $rsPedido->num_rows();
$rsPedido->bind_result($id, $num_pedido, $id_produto, $id_cliente, $quantidade, $preco, $valor, $nome_cli, $nome_pro);

$tabela  = "<tr><th colspan=8>PEDIDOS</th></tr>";
$tabela .= "<tr><td colspan=6>&nbsp;</td><td colspan=2 align=center><a href='pedido_detail.php?acao=novo'>Inserir Novo</a></td></tr>";
$tabela .= "<tr><th>PEDIDO</th><th>CLIENTE</th><th>PRODUTO</th><th>QUANTIDADE</th><th>PREÇO</th><th>VALOR</th><th>EDITAR</th><th>EXCLUIR</th></tr>";
while($rsPedido->fetch()) {
	$tabela .= "<tr><td>$num_pedido</td><td>$nome_cli</td><td>$nome_pro</td><td>$quantidade</td><td>$preco</td><td>$valor</td>
	<td align=center><a href='pedido_detail.php?acao=editar&id=$id'>Editar</a></td>
	<td align=center><a href='pedido_detail.php?acao=excluir&id=$id'>Excluir</a></td></tr>";
}
$tabela .= "<tr><td colspan=6>&nbsp;</td><td colspan=2 align=center><a href='http://187.108.38.204/old/index.htm'>Retornar</a></td></tr>";

$Pedido->fechaConexao();

echo "<br><br><br>";
echo "<center><table border=1 cellspacing=0>$tabela</table></center>";

?>
