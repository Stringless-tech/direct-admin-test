<?php
use Omines\DirectAdmin\DirectAdmin;


class User
{
	private $server_ip;
	private $server_login;
	private $server_pass;
	private $server_port;
	private $adminContext;
	private $validator;
	
	public function __construct($validator)
	{
		$this->validator = $validator;
		$a = require '../.env';
		$this->server_ip = $a['server_ip'];
		$this->server_login = $a['server_login'];
		$this->server_pass = $a['server_pass'];
		$this->server_port = $a['server_port'];
		$this->adminContext = DirectAdmin::connectAdmin('http://'.$this->server_ip.':'.$this->server_port, $this->server_login, $this->server_pass);
	}
	
	// Show all users
	public function index()
	{
		return $this->adminContext->getAllAccounts();
	}
	
	// Add user
	public function create($username, $password, $email, $domain)
	{
		$package = [
			'bandwidth' => 'unlimited',
			'ftp' => '2',
			'mysql' => '3',
		];
	
		$data = [
			'username' => $username,
			'password' => $password,
			'email' => $email,
			'domain' => $domain,
			'package' => $package,
		];
		if($this->validator->validateData($data))
			return $this->adminContext->createUser($username, $password, $email, $domain, $this->server_ip, $package);
		else
			return $this->validator->getErrors();
	}
	
	// Edit user
	public function edit($username, $ftpQuantity,$mysqlQuantity)
	{
		$data = 
		[
			'action' => 'customize',
			'user' => $username,
			'ftp' => $ftpQuantity,
			'mysql' => $mysqlQuantity,

		];
		
		return $this->adminContext->invokeApiPost('MODIFY_USER',$data);
	}
	
	// Remove user
	public function remove($username)
	{
		return $this->adminContext->deleteAccount($username);
	}
	
}

