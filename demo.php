<?php 
	session_start();
	include("DAO/conexao.php");

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
	<div class="row center-align listaLinhas">
		<div class="col s3">&nbsp;</div>
		<div class="col s6">
			<div class="card">
				<div class="row center-align">
					<div class="col s12">
						<button class="btn-floating btn-large waves-effect waves-light red modal-trigger" data-target="modalLinha" title="Adicionar" ><i class="material-icons">+</i></button>

					</div>	
				</div>

				<!-- Modal Structure -->
				  <div id="modalLinha" class="modal">
				    <div class="modal-content">
				      <h4>Nova linha de tempo</h4>
				      <div class="row center-align">
				      	<form method="POST" action="DAO/linhasCrud.php">
				      		<div class="row">
						        <div class="input-field col s12">
						          <input required id="titulo" name="titulo" type="text" class="validate">
						          <label for="titulo">Título :</label>
						          <input type="hidden" name="acao" value="criarLinha">
						        </div>
						    </div>

						    <div class="row">
						        <div class="input-field col s12">
						          <textarea id="descricao" name="descricao" class="materialize-textarea"></textarea>
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


				<?php
					$id = $_SESSION['id']; 
					$query = "SELECT * FROM linhas where fkUser = {$id} order by idLinha desc;";

					$linhas = $con->query($query);


					if ($linhas->num_rows == 0) {
				 ?>
				 <div class="row">
					<div class="col s12">
						 <div class="card darken-1">
					        Ainda não há nenhum registro aqui. clique no <strong>+ ACIMA</strong> para criar sua primeira linha. :)
					     </div>
					</div>
				</div>

				<?php } else {
					?>

				<?php foreach ($linhas as $linha): ?>
					<div class="row">
						<div class="col s12">
							 <div class="card blue-grey darken-1">
						        <div class="card-content white-text">
						          <span class="card-title"><?php echo $linha['titulo'] ?></span>
						          <p><?php echo $linha['descricao'] ?></p>
						        </div>
						        <div class="card-action">
						          <a href="linha.php?id=<?php echo $linha['idLinha'] ?>&idu=<?php echo $id ?>">Ver linha do tempo</a>
						        </div>
						     </div>
						</div>
					</div>
				<?php endforeach ?>
				<?php } ?>



			</div>
			<div class="col s3">&nbsp;</div>
		</div>

	</div>






<?php endif ?>



<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/materialize.js"></script>

<script type="text/javascript">

	setTimeout(function(){
	$('.alert').fadeOut(2500);
	}, 5000);

	$(document).ready(function(){
    	$('.sidenav').sidenav();
		$(".dropdown-trigger").dropdown();
		$('.datepicker').datepicker();
		$('select').formSelect();
		$('.modal').modal();


		$('.cadastrar').click(function() {
			$('#participantes').hide('slow');
			$('#login').hide('slow');
			$('#cadastro').show('slow');
		});


		$('.listaInteressados').click(function (){
			$('#cadastro').hide('slow');
			$('#login').hide('slow');
			$('#participantes').show('slow');
		});

		$('.login').click(function() {
			$('#cadastro').hide('slow');
			$('#participantes').hide('slow');
			$('#login').show('slow');
		});


  	});


	function validarSenha() {
        var senha = $('#senha').val();;
        var senha2 = $('#confirmaSenha').val();;
        
        if(senha == "" || senha.length < 5){
            alert('Senha deve conter pelo menos 5 caracteres.');
            $('#senha').focus();
            return false;
        }
        if(senha2 == "" || senha2.length < 5){
            alert('Senha deve conter pelo menos 5 caracteres.');
            $('#confirmaSenha').focus();
            return false;
        }
        if(senha != senha2){
            alert('Senhas estão diferentes, por favor verifique sua senha.');
            $('#confirmaSenha').focus();
            return false;
        }
     }


</script>
</body>
</html>