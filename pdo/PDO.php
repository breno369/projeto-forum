<?php

class usePDO
{

	//Algumas variáveis com dados sobre o Banco. 
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "testetabela";
	private $instance; // instância de conexão, usada no Singleton

	// método que retorna a instância de conexão
	function getInstance()
	{
		if (empty($instance)) {
			$instance = $this->connection();
		}
		return $instance;
	}

	//método que cria a instância de conexão. 
	private function connection()
	{
		try {
			$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password); //Criando um objeto PDO
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //atribuindo modo de erro do PDO.
			return $conn;
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage() . "<br>";
			if (strpos($e->getMessage(), "Unknown database 'testetabela'")) {
				echo "Conexão nula, criando o banco pela primeira vez" . "<br>";
				$conn = $this->createDB();
				return $conn;
			} else
				die("Connection failed: " . $e->getMessage() . "<br>");
		}
	}

	// -------------------------CRIA BANCO DE DADOS------------------------
	//Métodos do CRUD
	function createDB()
	{
		try {
			$cnx = new PDO("mysql:host=$this->servername", $this->username, $this->password);
			$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "CREATE DATABASE IF NOT EXISTS $this->dbname";
			$cnx->exec($sql);
			return $cnx;
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	// ------------------------------------------------------------------
	// ------------------------------CREATE------------------------------
	// ------------------------------------------------------------------
	function createTable()
	{
		try {
			$cnx = $this->getInstance();
			$sql = "CREATE TABLE IF NOT EXISTS usuarios (
					id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
					nick VARCHAR(150) NOT NULL,
					email VARCHAR(150) UNIQUE NOT NULL,
					senha TEXT NOT NULL,
					permissao TINYINT UNSIGNED  
				);
				CREATE TABLE IF NOT EXISTS pessoas (
					id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					nome_completo VARCHAR(150) NOT NULL,
					data_nasc DATE NOT NULL,
					rg INT UNIQUE NOT NULL,
					orgao_emissor VARCHAR(10) NOT NULL,
					cpf VARCHAR(14) UNIQUE NOT NULL,
					img LONGBLOB,
					sexo VARCHAR(1),
					id_usuario INT UNSIGNED NOT NULL,
					CONSTRAINT fk_table1_id_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
					ON DELETE CASCADE 
					ON UPDATE CASCADE
				); 
				CREATE TABLE IF NOT EXISTS perguntas (
					id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					id_usuario INT UNSIGNED NOT NULL,
					pergunta TEXT NOT NULL,
					CONSTRAINT fk_table2_id_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
					ON DELETE CASCADE
					ON UPDATE CASCADE
				);	
				CREATE TABLE IF NOT EXISTS respostas (
					id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					resposta TEXT NOT NULL,
					id_usuario INT UNSIGNED NOT NULL,
					id_pergunta INT UNSIGNED NOT NULL,
					CONSTRAINT fk_table3_id_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
					 ON DELETE CASCADE
					 ON UPDATE CASCADE,
					 CONSTRAINT fk_table1_id_pergunta FOREIGN KEY (id_pergunta) REFERENCES perguntas(id)
					 ON DELETE CASCADE
					 ON UPDATE CASCADE
				);
				CREATE TABLE IF NOT EXISTS estado (
					id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				 	estado VARCHAR(100) NOT NULL
				);
				CREATE TABLE IF NOT EXISTS cidade (
						id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						cidade VARCHAR(100) NOT NULL,
						id_estado INT UNSIGNED NOT NULL,
						CONSTRAINT fk_id_estado FOREIGN KEY (id_estado) REFERENCES estado(id)
						ON DELETE CASCADE
						ON UPDATE CASCADE
				);
				CREATE TABLE IF NOT EXISTS endereco (
						id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						cep INT NOT NULL,
						numero INT NOT NULL,
						logradouro VARCHAR(100) NOT NULL,
						bairro VARCHAR(100) NOT NULL,
						id_pessoa INT UNSIGNED NOT NULL,
						id_cidade INT UNSIGNED NOT NULL,
						CONSTRAINT fk_table2_id_pessoa FOREIGN KEY (id_pessoa) REFERENCES pessoas(id)
						ON DELETE CASCADE,
						CONSTRAINT fk_id_cidade FOREIGN KEY (id_cidade) REFERENCES cidade(id)
						ON DELETE CASCADE
				);
				CREATE TABLE IF NOT EXISTS avaliacao (
 						id_usuario INT UNSIGNED NOT NULL,
 						id_pergunta INT UNSIGNED NOT NULL,
  					avaliacao VARCHAR(10) NOT NULL,
						CONSTRAINT fk_table4_id_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
						ON DELETE CASCADE,
						CONSTRAINT fk_table2_id_pergunta FOREIGN KEY (id_pergunta) REFERENCES perguntas(id)
						ON DELETE CASCADE,
						CONSTRAINT UC_user_rating UNIQUE (id_usuario,id_pergunta)
				);";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();

			return "ErroCreateTables";
		}
	}

	// ------------------------------------------------------------------
	// ------------------------------INSERT------------------------------
	// ------------------------------------------------------------------
	function insert_vote($userid, $postid, $avaliacao)
	{
		$sql = "INSERT INTO avaliacao(
			id_usuario, 
			id_pergunta, 
			avaliacao
			) 
						 VALUES (
				$userid, 
				$postid, 
				\"$avaliacao\"
				) 
						 ON DUPLICATE KEY UPDATE 
			 avaliacao=\"$avaliacao\"";

		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function insertResposta($resposta, $id_usuario, $id_pergunta)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "INSERT INTO `respostas`(
				`resposta`,
				`id_usuario`,
				`id_pergunta`
			) 
			VALUES (
				\"$resposta\",
				\"$id_usuario\",
				\"$id_pergunta\"
			)";

			$cnx->exec($sql);
		} catch (Exception $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function insertPerguntas($pergunta, $id_usuario)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "INSERT INTO `perguntas`(
				`pergunta`,
				`id_usuario`
			) 
			VALUES (
				\"$pergunta\",
				\"$id_usuario\"
			)";

			$cnx->exec($sql);
		} catch (Exception $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function insertPessoas($nome_completo, $rg, $orgao_emissor, $cpf, $data_nasc, $sexo, $id_usuario)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "INSERT INTO `pessoas`(
			`nome_completo`, 
			`rg`, 
			`orgao_emissor`, 
			`cpf`, 
			`data_nasc`, 
			`sexo`,
			`id_usuario`
		) 
		VALUES (
			\"$nome_completo\",
			$rg,
			\"$orgao_emissor\",
			\"$cpf\",
			\"$data_nasc\",
			\"$sexo\",
			$id_usuario
		)";

			$cnx->exec($sql);
			$result = $cnx->lastInsertId();

			return $result;
		} catch (Exception $e) {
			echo $sql . "<br>" . $e->getMessage();
			return 'ErroInsertPessoas';
		}
	}


	function insertUsuarios($nome_completo, $email, $senha)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "INSERT INTO `usuarios`(
				`nick`, 
				`email`, 
				`senha`
			) 
			VALUES (
				\"$nome_completo\",
				\"$email\",
				\"$senha\"
			)";

			$cnx->exec($sql);
			$result = $cnx->lastInsertId(); //PEGA O ULTIMO ID INSERIDO

			return $result;
		} catch (Exception $e) {
			echo $sql . "<br>" . $e->getMessage();
			return 'ErroInsertUser';
		}
	}

	function insert($tabela, $valor, $id)
	{
		if ($tabela == 'cidade') {
			try {
				$cnx = $this->getInstance();
				$sql = "INSERT INTO `cidade`(
						`cidade`,
						`id_estado`
					) 
					VALUES (
						\"$valor\",
						\"$id\"
					)";

				$cnx->exec($sql);
				$result = $cnx->lastInsertId(); //PEGA O ULTIMO ID INSERIDO

				return $result;
			} catch (Exception $e) {
				echo $sql . "<br>" . $e->getMessage();
				return 'ErroInsertCidade';
			}
		} else {
			try {
				$cnx = $this->getInstance();
				$sql = "INSERT INTO `estado`(
						`estado`
					) 
					VALUES (
						\"$valor\"
					)";

				$cnx->exec($sql);
				$result = $cnx->lastInsertId(); //PEGA O ULTIMO ID INSERIDO

				return $result;
			} catch (Exception $e) {
				echo $sql . "<br>" . $e->getMessage();
				return 'ErroInsertEstado';
			}
		}
	}

	function insertEndereco($cep, $numero, $logradouro, $bairro, $id_pessoa, $id_cidade)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "INSERT INTO `endereco`(
				`cep`,
				`numero`,
				`logradouro`,
				`bairro`,
				`id_pessoa`, 
				`id_cidade`
			) 
			VALUES (
				\"$cep\",
				\"$numero\",
				\"$logradouro\",
				\"$bairro\",
				\"$id_pessoa\",
				\"$id_cidade\"
			)";

			$cnx->exec($sql);
			$result = $cnx->lastInsertId(); //PEGA O ULTIMO ID INSERIDO

			return $result;
		} catch (Exception $e) {
			echo $sql . "<br>" . $e->getMessage();
			return 'ErroInsertEndereco';
		}
	}

	// ------------------------------------------------------------------
	// ------------------------------SELECT------------------------------
	// ------------------------------------------------------------------
	function selectPessoas($cpf)
	{

		$sql = "SELECT `id` FROM `pessoas` WHERE `cpf`=\"$cpf\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectPermissao($id)
	{

		$sql = "SELECT `permissao` FROM `usuarios` WHERE `id`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectNickUsuario($id)
	{

		$sql = "SELECT `nick` FROM `usuarios` WHERE `id`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectResposta($id)
	{

		$sql = "SELECT `resposta`, `id_usuario` FROM `respostas` WHERE `id_pergunta`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectPergunta($id)
	{

		$sql = "SELECT `pergunta`,`id_usuario` FROM `perguntas` WHERE `id`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectIdUsuarios($email)
	{

		$sql = "SELECT `id` FROM `usuarios` WHERE `email`=\"$email\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectImagemPessoa($id)
	{

		$sql = "SELECT `img` FROM `pessoas` WHERE `id_usuario`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAsteriscoPergunta()
	{

		$sql = "SELECT * FROM `perguntas`";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAsteriscoPerguntaUser($id)
	{

		$sql = "SELECT * FROM `perguntas` WHERE id_usuario=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectIdRespostaPergunta($id)
	{

		$sql = "SELECT * FROM `respostas` WHERE id_pergunta=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAsteriscoRespostaUser($id)
	{

		$sql = "SELECT * FROM `respostas` WHERE id_usuario=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectIdPergunta($id)
	{

		$sql = "SELECT id_pergunta FROM `respostas` WHERE id=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAsteriscoPerguntaId($id)
	{

		$sql = "SELECT * FROM `perguntas` WHERE id=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAsteriscoResposta()
	{

		$sql = "SELECT * FROM `respostas`";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAsteriscoPessoas()
	{

		$sql = "SELECT * FROM `pessoas`";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAstericoUser($email)
	{

		$sql = "SELECT * FROM `usuarios` WHERE `email`=\"$email\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectAstericoUserId($id)
	{

		$sql = "SELECT * FROM `usuarios` WHERE `id`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectPessoaId($id)
	{

		$sql = "SELECT * FROM `pessoas` WHERE `id`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectPessoaIduser($id)
	{

		$sql = "SELECT * FROM `pessoas` WHERE `id_usuario`=\"$id\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectUser()
	{

		$sql = "SELECT * FROM `usuarios`";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectTabela($tabela, $valor)
	{
		$sql = "SELECT `id` FROM `$tabela` WHERE `$tabela`=\"$valor\"";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectCep()
	{

		$sql = "SELECT * FROM `endereco`";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectCepPessoas($id)
	{

		$sql = "SELECT * FROM `endereco` WHERE id_pessoa=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectCidade()
	{

		$sql = "SELECT * FROM `cidade`";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectCidadeCep($id)
	{

		$sql = "SELECT * FROM `cidade` WHERE id=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectEstado()
	{

		$sql = "SELECT * FROM `estado`";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function buscaEstado($estado)
	{

		$sql = "SELECT * FROM `estado` WHERE estado=$estado";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			// echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectEstadoCidade($id)
	{

		$sql = "SELECT * FROM `estado` WHERE id=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function selectIdEstado($id)
	{

		$sql = "SELECT * FROM `cidade` WHERE id_estado=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function userLikeDislike($postid, $userid, $avaliacao)
	{
		$sql = "SELECT COUNT(*) FROM avaliacao WHERE id_usuario=$userid AND id_pergunta=$postid AND avaliacao=\"$avaliacao\"";

		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0]['COUNT(*)'];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}
	function getLikeDislike($postid, $avaliacao)
	{
		$sql = "SELECT COUNT(*) FROM avaliacao WHERE id_pergunta = $postid AND avaliacao=\"$avaliacao\"";

		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			// var_dump($result->fetchAll()[0]['COUNT(*)']);
			return $result->fetchAll()[0]['COUNT(*)'];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function getRating($postid)
	{
		$rating = array();
		$likes = $this->getLikeDislike($postid, 'like');
		$dislikes = $this->getLikeDislike($postid, 'dislike');
		$rating = [
			'likes' => $likes,
			'dislikes' => $dislikes
		];
		return json_encode($rating);
	}

	function selectID($id, $tabela)
	{

		$sql = "SELECT * FROM $tabela WHERE id=$id";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll()[0];
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	// ------------------------------------------------------------------
	// ------------------------------UPDATE------------------------------
	// ------------------------------------------------------------------
	function updatePessoas($id, $nome_completo, $rg, $orgao_emissor, $cpf, $data_nasc, $sexo, $iduser)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "UPDATE `pessoas` 
			SET 
				`id`= $id,	
				`nome_completo`= \"$nome_completo\",
				`rg`= \"$rg\",
				`orgao_emissor`= \"$orgao_emissor\",
				`cpf`= \"$cpf\",
				`data_nasc`= \"$data_nasc\",
				`sexo`= \"$sexo\",
				`id_usuario`= $iduser
			WHERE id=$id";

$cnx->exec($sql);
} catch (PDOException $e) {
	echo $sql . "<br>" . $e->getMessage();
}
}

function updateUserNSenha($nick, $email, $permissao, $id)
{
	try {
		$cnx = $this->getInstance();
		$sql = "UPDATE `usuarios` 
		SET 
			`nick`= \"$nick\",
			`email`= \"$email\",
			`permissao`= $permissao
		WHERE id=$id";

		$cnx->exec($sql);
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

function updateUser($nick, $email, $senha, $permissao, $id)
{
	try {
		$cnx = $this->getInstance();
		$sql = "UPDATE `usuarios` 
		SET 
			`nick`= \"$nick\",
			`email`= \"$email\",
			`senha`= \"$senha\",
			`permissao`= $permissao
		WHERE id=$id";

		$cnx->exec($sql);
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

function updatePergunta($pergunta, $id, $id_user)
{
	try {
		$cnx = $this->getInstance();
		$sql = "UPDATE `perguntas` 
		SET 
			`pergunta`= \"$pergunta\"
		WHERE id=$id and id_usuario=$id_user";

		$cnx->exec($sql);
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

	function updateImg($img, $id)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "UPDATE `pessoas` 
			SET 
				`img`= \"$img\"
			WHERE id_usuario=$id";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function updateResposta($resposta, $id, $id_user, $id_pergunta)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "UPDATE `respostas` 
			SET 
				`resposta`= \"$resposta\"
			WHERE id=$id and id_usuario=$id_user and id_pergunta=$id_pergunta";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function update($tabela, $valor, $id, $idestado)
	{
		if ($tabela == 'cidade') {
			try {
				$cnx = $this->getInstance();
				$sql = "UPDATE `cidade` SET `cidade`= \"$valor\", `id_estado`= $idestado WHERE id=$id";
						// UPDATE `cidade` SET `cidade`= "Cruzeiro do Este", `id_estado`= 3 WHERE id=3;

				$result = $cnx->exec($sql);

				return $result;
			} catch (Exception $e) {
				echo $sql . "<br>" . $e->getMessage();
				return 'ErroUpdateCidade';
			}
		} else {
			try {
				$cnx = $this->getInstance();
				$sql = "UPDATE `estado`
				SET 
					`estado`= \"$valor\"
					
				WHERE id=$id";

				$result = $cnx->exec($sql);

				return $result;
			} catch (Exception $e) {
				echo $sql . "<br>" . $e->getMessage();
				return 'ErroUpdateEstado';
			}
		}
	}

	function updateEndereco($id, $cep, $numero, $logradouro, $bairro, $id_pessoa, $id_cidade)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "UPDATE `endereco`
			SET
				`cep` = $cep,
				`numero` = $numero,
				`logradouro` = \"$logradouro\",
				`bairro` = \"$bairro\",
				`id_pessoa` = $id_pessoa, 
				`id_cidade` = $id_cidade
			WHERE id=$id";

			$result = $cnx->exec($sql);
			
			return $result;
		} catch (Exception $e) {
			echo $sql . "<br>" . $e->getMessage();
			return 'ErroUpdateEndereco';
		}
	}

	// ------------------------------------------------------------------
	// ------------------------------DELETE------------------------------
	// ------------------------------------------------------------------
	function delete($id, $tabela)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "DELETE FROM $tabela WHERE id = $id";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function deletePessoas($id)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "DELETE FROM `pessoas` WHERE id = $id";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function deleteUser($id)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "DELETE FROM `usuarios` WHERE id = $id";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}
	function deleteCidade($id)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "DELETE FROM `cidade` WHERE id = $id";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function deleteEstado($id)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "DELETE FROM `estado` WHERE id = $id";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function deleteEndereco($id)
	{
		try {
			$cnx = $this->getInstance();
			$sql = "DELETE FROM `endereco` WHERE id = $id";

			$cnx->exec($sql);
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function delete_vote($userid, $postid)
	{
		$sql = "DELETE FROM avaliacao WHERE id_usuario=$userid AND id_pergunta=$postid";
		try {
			$cnx = $this->getInstance();
			$this->createTable();
			$result = $cnx->query($sql);

			return $result->fetchAll();
		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}