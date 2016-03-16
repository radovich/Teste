<?php

class BancoDados{


	private $host   = '127.0.0.1';
	private $user   = 'usu';
	private $pass   = 'senha';
	private $db     = 'old';
	private $mysqli = false;


	/**
	* Construtor da classe que faz conexão com MySQL via extensão MySQLi
	* @access public
	*/
	function BancoDados($host = '', $user = '', $pass = '', $db = '', $mysqli = false){
		$this->host   = $host;
		$this->user   = $user;
		$this->pass   = $pass;
		$this->db     = $db;
		$this->mysqli = $mysqli;
	}



	/**
	* Faz abertura de conexão com MySQL via MySQLi
	* @access public
	*/
	public function abreConexao(){
		$this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db, false, 65536);
	}


	/**
	* Devolve um link de conexão com MySQL via MySQLi
	* @access public
	* @return Conn Link de conexão MySQLi se conexão estiver ativa ou encerra o processamento do programa caso a conexão não esteja ativa
	*/
	public function getConexao(){
		if(!$this->mysqli){
			die('A conexão com o banco de dados não está aberta!');
		}
		return $this->mysqli;
	}


	/**
	* Fecha a conexão que está ativa com MySQL
	* @access public
	* @return void
	*/
	public function fechaConexao(){
		$this->mysqli->close();
	}



}
?>