<?php 
	session_start();
	include('conexao.php');

	$acao = $_REQUEST['acao'];

	switch ($acao) {
		case 'cadastrar':
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$dtNasc = $_POST['dtNasc'];
			$estado = $_POST['estado'];
			$senha = $_POST['senha'];
			$senha = md5($senha);

			$sql1 = "SELECT * FROM usuarios WHERE email = '{$email}';";

			$res = $con->query($sql1);

			if ($res->num_rows !=0) {
				$msg = "E-mail já cadastrado, manderemos notícias assim que tudo estiver certo.";
				$tipo = "ffe082 amber lighten-3";
			}else {
				$sql = "INSERT INTO `usuarios` (`nome`, `email`, `senha`, `dtNasc`, `estado`) VALUES ('{$nome}', '{$email}', '{$senha}', '{$dtNasc}', '{$estado}');";
				echo $sql;

				if ($con->query($sql)){
					$msg = "Cadastro realizado com sucesso, agora é só esperar :).";
					$tipo = "43a047 green darken-1";
				} else {
					$msg = "Um erro inesperado aconteceu :( tente novamente mais tarde";
					$tipo = "ffb300 amber darken-1";
				}
			}
			
			break;
		
		case 'login':
			$email = $_POST['email'];
			$senha = $_POST['senha'];
			$senha = md5($senha);

			$sql = "SELECT * FROM usuarios WHERE email = '{$email}';";

			$res = $con->query($sql);

			if ($res->num_rows > 0) {
				$res = $res->FETCH_ASSOC();
				if ($res['senha'] == $senha) {
					$_SESSION['nome'] = $res['nome'];
					#deu certo
					$_SESSION['id'] = $res['idUser'];
					$msg = "Seja bem vindo {$res['nome']}";
					$tipo = "43a047 green darken-1";
				}else {
					$msg = "Senha ou e-mail incorreto.";
					$tipo = "ffb300 amber darken-1";
				}
			} else {
				$msg = "Senha ou e-mail incorreto.";
				$tipo = "ffb300 amber darken-1";
			}

			break;

		case 'update':
			$id = $_POST['id'];
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$dtNasc = $_POST['dtNasc'];
			$estado = $_POST['estado'];
			$senha = $_POST['senha'];
			$senha = md5($senha);

			$sql = "UPDATE `usuarios` SET `nome` = '{$nome}', `email` = '{$email}', `senha` = '{$senha}', `dtNasc` = '{$dtNasc}', `estado` = '{$estado}' WHERE (`idUser` = {$id});";

			if ($con->query($sql)) {
				$msg = "Informações atualizadas com sucesso!";
				$tipo = "43a047 green darken-1";
			}else {
				$msg = "Que coisa ruim, algo deu errado :(";
				$tipo = "ffb300 amber darken-1";
			}


			break;

		case 'logout':
			session_destroy();
			$msg = "Logout realizado com sucesso!";
			$tipo = "43a047 green darken-1";

			break;

		case 'deletar':
			$id = $_REQUEST['id'];

			$sql = "DELETE FROM `usuarios` WHERE (`idUser` = {$id});";

			if ($con->query($sql)) {
				$msg = "Que pena, você saiu da lista de espera :( , mas esperamos que você mude de ideia...até logo!";
				$tipo = "ffb300 amber darken-1";
			}else {
				$msg = "Deu algo errado ao sair da lista, tente novamente.";
				$tipo = "d84315 deep-orange darken-3";
			}

			session_destroy();
			break;

		default:
			# code...
			break;
	}

	header("Location: ../index.php?msg={$msg}&tipo={$tipo}");
 ?>