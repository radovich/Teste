<?php
ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);

include_once("classes/db.php");
include_once("classes/pedido.php");

class Produto extends BancoDados {
	
	public $id = 0;
	public $nome = '';
	public $descricao = '';
	public $preco = '';


	function Produto($id = NULL, $nome = '', $descricao = '', $preco = 0){
		$this->id = $id;
		$this->nome = $nome;
		$this->descricao = $descricao;
		$this->preco = $preco;
	}


	public function create(){
		$sql = "insert into produto(nome,descricao,preco) values (?, ?, ?)";
		$inserir = $this->getConexao()->prepare($sql);
		$inserir->bind_param('ssd', $this->nome, $this->descricao, $this->preco);
		$inserir->execute();
		return $inserir->insert_id;
	}
	
	public function retrieve(){
		$sql = "select id,nome,descricao,preco from produto where id = ?";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->bind_param('i', $this->id);
		$recuperar->execute();
		return $recuperar;
	}

	public function retrieveByNome(){
		$sql = "select id,nome,descricao,preco from produto where nome like '%$this->nome%' order by nome";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->execute();
		return $recuperar;
	}

	public function retrieveByDescricao(){
		$sql = "select id,nome,descricao,preco from produto where descricao like '%$this->descricao%' order by descricao";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->bind_param('s', $this->email);
		$recuperar->execute();
		return $recuperar;
	}

	public function update(){
		$sql = "update produto set nome = ?, descricao = ?, preco = ? where id = ?";
		$alterar = $this->getConexao()->prepare($sql);
		$alterar->bind_param('ssdi', $this->nome, $this->descricao, $this->preco, $this->id);
		$alterar->execute();
		return $alterar->affected_rows;
	}
	
	public function delet(){
		$pedido = new Pedido();
		$pedido->abreConexao();
		$pedido->id_produto = $this->id;
		$pedido->retrieveByProduto();
		if ($pedido->id > 0) { return FALSE; }
		
		$sql = "delete from produto where id = ?";
		$deletar = $this->getConexao()->prepare($sql);
		$deletar->bind_param('i', $this->id);
		$deletar->execute();
		return $deletar->affected_rows;
	}



}
?>