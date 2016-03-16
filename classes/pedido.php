<?php
ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);

include_once("classes/cliente.php");
include_once("classes/produto.php");

class Pedido extends BancoDados {

	public $id = 0;
	public $num_pedido = 0;
	public $id_produto = 0;
	public $id_cliente = 0;
	public $quantidade = 0;
	public $preco = 0;
	public $valor = 0;


	function Pedido($id = NULL, $num_pedido = 0, $id_produto = 0, $id_cliente = 0, $quantidade = 0, $preco = 0, $valor = 0){
		$this->id = $id;
		$this->num_pedido = $num_pedido;
		$this->id_produto = $id_produto;
		$this->id_cliente = $id_cliente;
		$this->quantidade = $quantidade;
		$this->preco = $preco;
		$this->valor = $valor;
	}



	public function create(){
		$sql = "insert into pedido(num_pedido,id_produto,id_cliente,quantidade,preco,valor) values (?, ?, ?, ?, ?, ?)";
		$inserir = $this->getConexao()->prepare($sql);
		$inserir->bind_param('iiiddd', $this->num_pedido, $this->id_produto, $this->id_cliente, $this->quantidade, $this->preco, $this->valor);
		$inserir->execute();
		return $inserir->insert_id;
	}
	
	public function retrieveAll(){
		$sql = "select pd.id, pd.num_pedido, pd.id_produto, pd.id_cliente, pd.quantidade, 
		pd.preco, pd.valor,	cl.nome nome_cli, pr.nome nome_pro 
		from pedido pd, cliente cl, produto pr 
		where pd.id_cliente = cl.id and pd.id_produto = pr.id
		order by cl.nome, pd.num_pedido, pr.nome";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->execute();
		return $recuperar;
	}

	public function retrieve(){
		$sql = "select pd.id, pd.num_pedido, pd.id_produto, pd.id_cliente, pd.quantidade, 
		pd.preco, pd.valor,	cl.nome nome_cli, pr.nome nome_pro 
		from pedido pd, cliente cl, produto pr 
		where pd.id_cliente = cl.id and pd.id_produto = pr.id
		and pd.id = ?";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->bind_param('i', $this->id);
		$recuperar->execute();
		return $recuperar;
	}

	public function retrieveByCliente(){
		$sql = "select id,id_produto,id_cliente from pedido where id_cliente = ? ";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->bind_param('i', $this->id_cliente);
		$recuperar->execute();
		return $recuperar;
	}

	public function retrieveByProduto(){
		$sql = "select id,id_produto,id_cliente from pedido where id_produto = ? ";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->bind_param('i', $this->id_produto);
		$recuperar->execute();
		return $recuperar;
	}

	public function update(){
		$sql = "update pedido set num_pedido = ?, id_cliente = ?, id_produto = ?, quantidade = ?, preco = ?, valor = ? where id = ?";
		$alterar = $this->getConexao()->prepare($sql);
		$alterar->bind_param('iiidddi', $this->num_pedido, $this->id_cliente, $this->id_produto, $this->quantidade, $this->preco, $this->valor, $this->id);
		$alterar->execute();
		return $alterar->affected_rows;
	}
	
	public function delet(){
		$sql = "delete from pedido where id = ?";
		$deletar = $this->getConexao()->prepare($sql);
		$deletar->bind_param('i', $this->id);
		$deletar->execute();
		return $deletar->affected_rows;
	}



}
?>