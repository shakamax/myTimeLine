<?php 
	session_start();
	include("DAO/conexao.php");

	$idUser = $_REQUEST['idu'];
	$idLinha = $_REQUEST['id'];

	//$sql = "SELECT * FROM linhas LEFT JOIN acontecimentos on linhas.idLinha = acontecimentos.fkLinha WHERE idLinha = {$idLinha} AND fkUser = {$idUser} ORDER BY acontecimentos.ordem;";
	$sql = "SELECT * FROM linhas WHERE idLinha = {$idLinha} AND fkUser = {$idUser};";

	$sqlord = "SELECT * FROM acontecimentos WHERE fkLinha = {$idLinha};";
	$order = $con->query($sqlord)->num_rows;
	$linha = $con->query($sql);
	$linha = $linha->fetch_object();
	$order++;

 ?>

<!DOCTYPE html>
<html lang="PT-br">
<head>
	<meta charset="utf-8">
	<title>Faça sua própria Linha do Tempo</title>

	<link rel="stylesheet" type="text/css" href="css/materialize.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>


	<!-- //////////////////////////////// -->
	<!-- ////////DIV DOS SEM LOGIN/////// -->
	<!-- //////////////////////////////// -->

<?php if (!isset($_SESSION['id'])): ?>
	
<div id="semLogin">
		
	<div class="row center-align">
		<div class="ffb300 amber darken-1?>">
			Acesso negado, realize primeiro o login.
		</div>
	</div>
	
<?php endif ?>


<?php if (isset($_SESSION['id'])): ?>

	<nav>
		<div class="nav-wrapper teal lighten-2">
		  <a href="#!" class="brand-logo center"><img id="logoTop" src="img/logo4.png"></a>
		  <ul class="left hide-on-med-and-down">
		   	<li><a href="index.php">Modificar cadastro</a></li>
		    <li><a href="DAO/crudUsuario.php?acao=logout" onclick="return confirm('Deseja realmente realizar o logout?')">Logout</a></li>

		  </ul>
	    </div>
	</nav>


	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<?php if (isset($_REQUEST['msg']) AND isset($_REQUEST['tipo'])) { ?>
	<div class="row center-align">
		
		<div class="alert <?php echo $_REQUEST['tipo']; ?>">
			<?php echo $_REQUEST['msg']; ?>
		</div>
	</div>
	
	<?php } ?>
	<div class="row center-align minhaLinha">
		<div class="col s3"></div>
		<div class="col s6">
			<div class="card">
				<div class="row">
					<a href="demo.php" class="btn-floating btn-large waves-effect waves-light orange modal-trigger left" title="voltar"><i class="material-icons"><</i></a>
					<div class="card-title center-align">
						<?php echo($linha->titulo); ?>
					</div>
				</div>
				&nbsp;
				<hr>
				<div class="row">
					<!-- <form> -->

					<?php 
						$sqlA = "SELECT * FROM acontecimentos where fkLinha = {$idLinha} order by ordem ASC;";

						$aconts = $con->query($sqlA);
						$i =1;
						if ($aconts->num_rows == 0) {

					 ?>

					 <p>Ainda não há nenhum acontecimento, clique no + para adicionar um acontecimento a essa linha do tempo.</p>

					<?php }else { ?>
						<div class="row">
							
						<?php foreach ($aconts as $acon): ?>

						<div class="col s4">
							<div class="card">
						        <div class="card-content center-align">
						          <a href="DAO/linhasCrud.php?acao=deletarAcont&idAcon=<?php echo $acon['idAcontecimento']; ?>&linha=<?php echo $acon['fkLinha']; ?>" class="btn-floating btn-small waves-effect waves-light red right">x</a>
						          <span class="card-title"><?php echo $acon['titulo']; ?></span>
						          <p><?php echo $acon['acontecimento']; ?></p>
						        </div>
						        <div class="card-action">
						        	<div class="row">
						        		<form method="post" action="DAO/linhasCrud.php">
						        		<div class="col s8">
								          <label for="order">Ordem :</label>
								          <input required id="order" name="order" type="number" class="validate" value="<?php echo $acon['ordem']; ?>">
								          <input type="hidden" name="acao" value="mudarOrdem">
								          <input type="hidden" name="idLinha" value="<?php echo $acon['fkLinha']; ?>">
								          <input type="hidden" name="idAc" value="<?php echo $acon['idAcontecimento']; ?>">
								          <input type="hidden" name="antigaPosicao" value="<?php echo $acon['ordem']; ?>">
						        		</div>
						        		<div class="col s4">
						        			<button type="submit" class="waves-effect waves-light btn-small">Salvar</button>
						        		</div>
						        			
						        		</form>
						        	</div>
						        </div>

	      					</div>
						</div>

						<?php 
							if ($i == 3) {
								
								echo "</div>";
								echo "<div class='row'>";
								$i = 1;

							}else {
								$i++;
							}

						 ?>
						<?php endforeach ?>

						</div>


					<?php } ?>

						<div class="col s4 center-align">
								
							<div class="card-content center-align">
								<button data-target="adicionarA" class="btn-floating btn-large waves-effect waves-light blue modal-trigger center" title="Adicionar acontecimento"><i class="material-icons">+</i></button>
						          
					        </div>
						</div>
						



					<!-- </form> -->
				</div>
				<hr>
				<div class="col s12">&nbsp;</div>
				<div class="row">
					<div class="col s3">
						<button class="waves-effect waves-light btn-small orange modal-trigger" data-target="modificar">Alterar</button>
					</div>
					<div class="col s4">
						<a class="waves-effect waves-light btn-small red" href="DAO/linhasCrud.php?acao=deletar&id=<?php echo $linha->idLinha ?>" onclick="return confirm('Deseja realmente excluir essa linha do tempo?')">Excluir Linha</a>
					</div>
					<div class="col s5">
						<!-- <button class="waves-effect waves-light btn-small modal-trigger" data-target="modificar">Salvar</button> -->
						
					</div>

				</div>
			</div>
		</div>
		<div class="col s3"></div>

	</div>



	<!-- MODAL  -->
	 <!-- Modal Structure -->
	  <div id="modificar" class="modal">
	    <div class="modal-content">
	      <h4>Alterar linha de tempo</h4>
	      <div class="row center-align">
	      	<form method="POST" action="DAO/linhasCrud.php">
	      		<div class="row">
			        <div class="input-field col s12">
			          <input required id="titulo" name="titulo" value="<?php echo $linha->titulo ?>" type="text" class="validate">
			          <label for="titulo">Título :</label>
			          <input type="hidden" name="idLinha" value="<?php echo $linha->idLinha ?>">
			          <input type="hidden" name="acao" value="editar">
			        </div>
			    </div>

			    <div class="row">
			        <div class="input-field col s12">
			          <textarea id="descricao" name="descricao" class="materialize-textarea"><?php echo $linha->descricao ?></textarea>
			          <label for="descricao">Descrição</label>
			        </div>
			    </div>

	      </div>
	    </div>
	    <div class="modal-footer">
	      <button type="submit" class="modal-close waves-effect waves-green btn-flat">Salvar</button>
	    </div>
	      	</form>
	  </div>


	  <!-- MODAL  -->
		 <!-- Modal Structure -->
	  <div id="adicionarA" class="modal">
	    <div class="modal-content">
	      <h4>Alterar linha de tempo</h4>
	      <div class="row center-align">
	      	<form method="POST" action="DAO/linhasCrud.php">
	      		<div class="row">
			        <div class="input-field col s12">
			          <input required id="titulo" name="titulo" type="text" class="validate">
			          <label for="titulo">Título :</label>
			          <input type="hidden" name="idLinha" value="<?php echo $idLinha ?>">
			          <input type="hidden" name="acao" value="criarAcontecimento">
			        </div>
			    </div>

			    <div class="row">
			        <div class="input-field col s12">
			          <textarea id="acontecimentos" name="acontecimentos" class="materialize-textarea"></textarea>
			          <label for="acontecimentos">Acontecimento</label>
			        </div>
			    </div>

	      </div>
	    </div>
	    <div class="modal-footer">
	      <button type="submit" class="modal-close waves-effect waves-green btn-flat">Salvar</button>
	    </div>
	      	</form>
	  </div>





<?php endif ?>



<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/main.js"></script>


</body>
</html>