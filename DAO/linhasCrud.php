<?php 
	session_start();
	include('conexao.php');

	$acao = $_REQUEST['acao'];
	$id = $_SESSION['id'];

	switch ($acao) {
		case 'criarLinha':
			$titulo = $_POST['titulo'];
			$desc = $_POST['descricao'];


			$sql = "INSERT INTO `linhas` (`fkUser`, `titulo`, `descricao`) VALUES ({$id}, '{$titulo}', '{$desc}');";

			if ($con->query($sql)) {
				$msg = "Linha do tempo criada com sucesso! :)";
				$tipo = "43a047 green darken-1";
			}else {
				$msg = "Acho que deu algo errado, tente de novo  :(";
				$tipo = "ffb300 amber darken-1";
			}
			

			break;
		case 'editar':
			$idLinha = $_REQUEST['idLinha'];
			$titulo = $_REQUEST['titulo'];
			$desc = $_REQUEST['descricao'];

			$sql = "UPDATE `linhas` SET `titulo` = '{$titulo}', `descricao` = '{$desc}' WHERE (`idLinha` = {$idLinha} AND `fkUser` = {$id});";
			

			if ($con->query($sql)) {
				$msg = "Linha do tempo alterada com sucesso! :)";
				$tipo = "43a047 green darken-1";
			}else {
				$msg = "Acho que deu algo errado, tente de novo  :(";
				$tipo = "ffb300 amber darken-1";
			}


			header("Location: ../linha.php?id={$idLinha}&idu={$id}&msg={$msg}&tipo={$tipo}");
			exit();
			break;
		case 'criarAcontecimento':
			$idLinha = $_REQUEST['idLinha'];
			$titulo = $_REQUEST['titulo'];
			$acont = $_REQUEST['acontecimentos'];

			$sqlord = "SELECT * FROM acontecimentos WHERE fkLinha = {$idLinha};";
			$order = $con->query($sqlord);
			$order = $order->num_rows;
			$order++;

			$sql = "INSERT INTO `acontecimentos` (`fkLinha`, `acontecimento`, `titulo`, `ordem`) VALUES ({$idLinha}, '{$acont}', '{$titulo}', {$order});";


			if ($con->query($sql)) {
				$msg = "Acontecimento criado com sucesso! :)";
				//$msg = $sqlord;
				$tipo = "43a047 green darken-1";
			}else {
				$msg = "Acho que deu algo errado, tente de novo  :(";
				$tipo = "ffb300 amber darken-1";
			}


			header("Location: ../linha.php?id={$idLinha}&idu={$id}&msg={$msg}&tipo={$tipo}");
			exit();

			break;

		case 'mudarOrdem':
			$order = $_REQUEST['order'];
			$antiga = $_REQUEST['antigaPosicao'];
			$fklinha = $_REQUEST['idLinha'];
			$idAc = $_REQUEST['idAc'];
			$idLinha = $_REQUEST['idLinha'];

			if ($order > $antiga) {

				$ids = array();

				for ($i = $order;$i > $antiga; $i--) { 
					$sqlpega = "SELECT * FROM acontecimentos WHERE fkLinha= {$fklinha} AND ordem = {$i};";
					$res = $con->query($sqlpega);
					$res = $res->FETCH_OBJECT();
					array_push($ids, $res);

				}

				foreach ($ids as $idA) {
					$ordFut = $idA->ordem - 1;
					echo("O id {$idA->idAcontecimento} é da ordem {$idA->ordem} que vai pra ordem {$ordFut}<br>");
					$sql = "UPDATE `acontecimentos` SET `ordem` = {$ordFut} WHERE (`idAcontecimento` = {$idA->idAcontecimento} AND `fkLinha` = {$fklinha});";
					
					$con->query($sql);

				}

				/*for ($i= $order-1; $i >= $antiga; $i--) { 
					$p = $i+1;
					$sql = "UPDATE `acontecimentos` SET `ordem` = {$i} WHERE (`ordem` = {$p} AND `fkLinha` = {$fkLinha});";
					//$con->query($sql);
					echo $sql;
					echo "<br>";
				}
				*/
				$sqlF = "UPDATE `acontecimentos` SET `ordem` = {$order} WHERE (`idAcontecimento` = {$idAc} AND `fkLinha` = {$fklinha});";
				echo $sqlF;
				if ($con->query($sqlF)) {
					$msg = "Ordem alterada! :)";
					$tipo = "43a047 green darken-1";
				}else {
					$msg = "Acho que deu algo errado, tente de novo  :(";
					$tipo = "ffb300 amber darken-1";
				}



			}else if($order < $antiga){

				$ids = array();
				for ($i = $order; $i < $antiga; $i++) { 
					$p = $i+1;
					$sqlpega = "SELECT * FROM acontecimentos WHERE fkLinha= {$fklinha} AND ordem = {$i};";
					$res = $con->query($sqlpega);
					$res = $res->FETCH_OBJECT();
					array_push($ids, $res);

				}

				foreach ($ids as $idA) {
					$ordFut = $idA->ordem + 1;
					echo("O id {$idA->idAcontecimento} é da ordem {$idA->ordem} que vai pra ordem {$ordFut}<br>");
					$sql = "UPDATE `acontecimentos` SET `ordem` = {$ordFut} WHERE (`idAcontecimento` = {$idA->idAcontecimento} AND `fkLinha` = {$fklinha});";
					echo $sql;
					$con->query($sql);


				}


				/*for ($i = $order; $i < $antiga; $i++) { 
					$p = $i+1;
					$sql = "UPDATE `acontecimentos` SET `ordem` = {$p} WHERE (`ordem` = {$i} AND `fkLinha` = {$fklinha});";
					//$con->query($sql);
					echo $sql;
					echo "<br>";
				}
				*/
				$sqlF = "UPDATE `acontecimentos` SET `ordem` = {$order} WHERE (`idAcontecimento` = {$idAc} AND `fkLinha` = {$fklinha});";
				echo $sqlF;
				if ($con->query($sqlF)) {
					$msg = "Ordem alterada! :)";
					$tipo = "43a047 green darken-1";
				}else {
					$msg = "Acho que deu algo errado, tente de novo  :(";
					$tipo = "ffb300 amber darken-1";
				}

			}else {
				$msg = "Nenhuma mudança detectada.";
				$tipo = "ffb300 amber darken-1";
			}


			
			header("Location: ../linha.php?id={$idLinha}&idu={$id}&msg={$msg}&tipo={$tipo}");
			exit();
			break;	

		case 'deletarAcont':
			
			$idA = $_REQUEST['idAcon'];
			$idLinha = $_REQUEST['linha'];
			$conf = "SELECT * FROM acontecimentos LEFT JOIN linhas ON linhas.idLinha = fkLinha WHERE idAcontecimento = {$idA};";
			$ver = $con->query($conf);
			$ver = $ver->FETCH_ARRAY();
			if ($ver['fkUser'] == $id) {
				

				$sql = "DELETE FROM `acontecimentos` WHERE (`idAcontecimento` = {$idA});";

				if ($con->query($sql)) {

					$msg = "Acontecimento excluído com sucesso! :)";
					$tipo = "43a047 green darken-1";

				}else {
					$msg = "Não foi possível excluir este acontecimento.";
					$tipo = "ffb300 amber darken-1";
				}


			}else {
				$msg = "Não é possível deletar um acontecimento de outra pessoa.  :(";
				$tipo = "ffb300 amber darken-1";
			}

			header("Location: ../linha.php?id={$idLinha}&idu={$id}&msg={$msg}&tipo={$tipo}");
			exit();
			break;

		case 'deletar':
			$idLinha = $_REQUEST['id'];

			$sql = "SELECT * FROM linhas WHERE idLinha = {$idLinha};";

			$res = $con->query($sql);

			$res = $res->FETCH_ARRAY();
			if ($res['fkUser'] == $id) {
				
				$sql = "DELETE FROM `acontecimentos` WHERE (`fkLinha` = {$idLinha});";

				$con->query($sql);

				$sql = "DELETE FROM `linhas` WHERE (`idLinha` = {$idLinha});";

				if ($con->query($sql)) {

					$msg = "Linha do tempo excluída com sucesso! :)";
					$tipo = "43a047 green darken-1";

				}else {
					$msg = "Não foi possível excluir esta linha do tempo.";
					$tipo = "ffb300 amber darken-1";
				}


			}else {
				$msg = "Não é possível deletar um acontecimento de outra pessoa.  :(";
				$tipo = "ffb300 amber darken-1";
			}

			
			break;

		default:
			# code...
			break;
	}


	header("Location: ../demo.php?msg={$msg}&tipo={$tipo}");
 ?>