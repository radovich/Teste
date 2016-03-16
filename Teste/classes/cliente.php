<?php
ini_set('php_value error_reporting', E_ALL); ini_set('display_errors', TRUE);

include_once("classes/db.php");
include_once("classes/pedido.php");

class Cliente extends BancoDados {

	public $id = 0;
	public $nome = '';
	public $email = '';
	public $telefone = '';


	function Cliente($id = NULL, $nome = '', $email = '', $telefone = ''){
		$this->id = $id;
		$this->nome = $nome;
		$this->email = $email;
		$this->telefone = $telefone;
	}



	public function create(){
		$sql = "insert into cliente(nome,email,telefone) values (?, ?, ?)";
		$inserir = $this->getConexao()->prepare($sql);
		$inserir->bind_param('sss', $this->nome, $this->email, $this->telefone);
		$inserir->execute();
		return $inserir->insert_id;
	}
	
	public function retrieve(){
		$sql = "select id,nome,email,telefone from cliente where id = ?";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->bind_param('i', $this->id);
		$recuperar->execute();
		return $recuperar;
	}

	public function retrieveByNome(){
		$sql = "select id,nome,email,telefone from cliente where nome like '%$this->nome%' order by nome";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->execute();
		return $recuperar;
	}

	public function retrieveByEmail(){
		$sql = "select id,nome,email,telefone from cliente where email like '%$this->email%' order by email";
		$recuperar = $this->getConexao()->prepare($sql);
		$recuperar->execute();
		return $recuperar;
	}

	public function update(){
		$sql = "update cliente set nome = ?, email = ?, telefone = ? where id = ?";
		$alterar = $this->getConexao()->prepare($sql);
		$alterar->bind_param('sssi', $this->nome, $this->email, $this->telefone, $this->id);
		$alterar->execute();
		return $alterar->affected_rows;
	}
	
	public function delet(){
		$pedido = new Pedido();
		$pedido->abreConexao();
		$pedido->id_cliente = $this->id;
		$pedido->retrieveByCliente();
		if ($pedido->id > 0) { return FALSE; }

		$sql = "delete from cliente where id = ?";
		$deletar = $this->getConexao()->prepare($sql);
		$deletar->bind_param('i', $this->id);
		$deletar->execute();
		return $deletar->affected_rows;
	}



}
?>