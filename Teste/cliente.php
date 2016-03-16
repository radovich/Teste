<?php
ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);
include_once("classes/cliente.php");

$Cliente = new Cliente();
$Cliente->abreConexao();
$rsCliente = $Cliente->retrieveByNome();
$qtdCliente = $rsCliente->num_rows();
$rsCliente->bind_result($id,$nome,$email,$telefone);

$tabela  = "<tr><th colspan=6>CLIENTES</th></tr>";
$tabela .= "<tr><td colspan=4>&nbsp;</td><td colspan=2 align=center><a href='cliente_detail.php?acao=novo'>Inserir Novo</a></td></tr>";
$tabela .= "<tr><th>ID</th><th>NOME</th><th>EMAIL</th><th>TELEFONE</th><th>EDITAR</th><th>EXCLUIR</th></tr>";
while($rsCliente->fetch()) {
	$tabela .= "<tr><td>$id</td><td>$nome</td><td>$email</td><td>$telefone</td>
	<td align=center><a href='cliente_detail.php?acao=editar&id=$id'>Editar</a></td>
	<td align=center><a href='cliente_detail.php?acao=excluir&id=$id'>Excluir</a></td></tr>";
}
$tabela .= "<tr><td colspan=4>&nbsp;</td><td colspan=2 align=center><a href='http://187.108.38.204/old/index.htm'>Retornar</a></td></tr>";

$Cliente->fechaConexao();

echo "<br><br><br>";
echo "<center><table border=1 cellspacing=0>$tabela</table></center>";

?>
	