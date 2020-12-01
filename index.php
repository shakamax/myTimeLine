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
		
	<nav>
		<div class="nav-wrapper teal lighten-2">
		  <a href="#!" class="brand-logo center"><img id="logoTop" src="img/logo4.png"></a>
		  <ul class="left hide-on-med-and-down">
		    <!-- <li><a href="sass.html">Sass</a></li> -->
		    <li><a class="cadastrar">Cadastre-se</a></li>
		    <li class=""><a class="listaInteressados">Interessados</a></li>
		    <li><a class="login">Login</a></li>

		  </ul>
	    </div>
	</nav>

	<p>&nbsp;</p>
	<?php if (isset($_REQUEST['msg']) AND isset($_REQUEST['tipo'])) { ?>
	<div class="row center-align">
		
		<div class="alert <?php echo $_REQUEST['tipo']; ?>">
			<?php echo $_REQUEST['msg']; ?>
		</div>
	</div>
	
	<?php } ?>
	<div id="participantes" class="container center-align">
		<h4>Quem somos nós?</h4>
		<p>MyTimeLine é uma iniciativa para se situar e organizar seus pensamentos, quer eles sejam ficticios ou não.</p>
		<p>Escrevendo um livro? Estudando para uma prova? Criando uma estória só sua? entre na nossa lista de espera e receba as notícias de quando o projeto sofrer atualizações.</p>
		<a class="cadastrar waves-effect waves-light btn">Cadastrar</a>
		<table class="striped">
			<?php 

				$sql = "SELECT * FROM usuarios;";
				$usuarios = $con->query($sql);
				if($usuarios->num_rows == 0){
			 ?>
			 <p class="ffe082 amber lighten-3"> :( não tem ninguém esperando ainda, seja o primeiro.</p>
			<?php } else {?>
				<p class="left-align"><?php echo $usuarios->num_rows ?> interessado(s) encontrado(s)</p>
			<?php } ?>
			<thead>
				<th>Nome</th>
				<th>Estado</th>
			</thead>
			<tbody>
				<?php 
					if ($usuarios->num_rows > 0) {
				 ?>
				<?php foreach ($usuarios as $user): ?>
					<tr>
						<td>
							<?php echo $user['nome']; ?>
						</td>
						<td>
							<?php echo $user['estado']; ?>
						</td>
					</tr>
					
				<?php endforeach ?>


				<?php } ?>
			</tbody>
			
		</table>
	</div>


	<div id="cadastro" style="display: none;" class="container center-align">


		<div class="row">
			<div class="col s3">&nbsp;</div>
		    <form action="DAO/crudUsuario.php" method="POST" onsubmit="return validarSenha()"  class="col s6">
			  <h5>Cadastrar-se para receber notícias</h5>
			  <input type="hidden" name="acao" value="cadastrar">
		      <div class="row">
		        <div class="input-field col s12">
		          <input required id="nome" name="nome" type="text" class="validate">
		          <label for="nome">Nome :</label>
		        </div>
		      </div>
		      <div class="row">
		        <div class="input-field col s12">
		          <input required id="email" name="email" type="email" class="validate">
		          <label for="email">E-mail :</label>
		        </div>
		      </div>
		      <div class="row">
		        <div class="input-field col s12">
		      	  <input id="dtNasc" name="dtNasc" type="date" class="validate">
		          <label for="dtNasc">Data de nascimento :</label>
		        </div>
		      </div>

		      <div class="row">
				  <div class="input-field col s12">
				    <select required name="estado">
					    <option value="" disabled selected>Escolha seu estado</option>
					    <option value="AC">Acre</option>
					    <option value="AL">Alagoas</option>
					    <option value="AP">Amapá</option>
					    <option value="AM">Amazonas</option>
					    <option value="BA">Bahia</option>
					    <option value="CE">Ceará</option>
					    <option value="DF">Distrito Federal</option>
					    <option value="ES">Espírito Santo</option>
					    <option value="GO">Goiás</option>
					    <option value="MA">Maranhão</option>
					    <option value="MT">Mato Grosso</option>
					    <option value="MS">Mato Grosso do Sul</option>
					    <option value="MG">Minas Gerais</option>
					    <option value="PA">Pará</option>
					    <option value="PB">Paraíba</option>
					    <option value="PR">Paraná</option>
					    <option value="PE">Pernambuco</option>
					    <option value="PI">Piauí</option>
					    <option value="RJ">Rio de Janeiro</option>
					    <option value="RN">Rio Grande do Norte</option>
					    <option value="RS">Rio Grande do Sul</option>
					    <option value="RO">Rondônia</option>
					    <option value="RR">Roraima</option>
					    <option value="SC">Santa Catarina</option>
					    <option value="SP">São Paulo</option>
					    <option value="SE">Sergipe</option>
					    <option value="TO">Tocantins</option>
					    <option value="EX">Estrangeiro</option>
					    </select>
				    <label>Estado</label>
				  </div>
				</div>
				<div class="row">
			        <div class="input-field col s12">
			          <input required id="senha" name="senha" type="password" class="validate">
			          <label for="senha">Senha : <i class="red-text warningPass" style="display: none;">teste</i></label>
			        </div>
		     	</div>
		     	<div class="row">
			        <div class="input-field col s12">
			          <input id="confirmaSenha" name="confirmaSenha" type="password" class="validate">
			          <label for="confirmaSenha">Confirme sua senha :</label>
			        </div>
		     	</div>

		     	<div class="row">
		     		<div class="col s12">
		     			<p>&nbsp;</p>
		     			<button type="submit" id="btnConfirma" class="col s12 cadastrar waves-effect waves-light btn">Cadastrar</button>
		     		</div>
		     	</div>
		    </form>
			<div class="col s3">&nbsp;</div>

	    </div>
		
	</div>





		
	
	<div id="login" style="display: none;">
		<div class="row">
			<div class="col s4">&nbsp;</div>			
			<div class="col s4">
				<div class="card s12">
					<div class="row center-align">
						<span class="card-title">Login</span>
						
					</div>
					<form action="DAO/crudUsuario.php" method="POST">
						<div class="row">
							<input type="hidden" name="acao" value="login">
							<div class="input-field col s12">
							  <input required id="emailLogin" name="email" type="email" class="validate">
							  <label for="emailLogin">E-mail :</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
							  <input required id="senhaLogin" name="senha" type="password" class="validate">
							  <label for="senhaLogin">Senha :</label>
							</div>
						</div>
						<div class="row">
							<button class="col s12 waves-effect waves-light btn">Login</button>

						</div>
					</form>
				</div>
			</div>			
			<div class="col s4">&nbsp;</div>			

		</div>
	</div>	


<!-- //////////////////////////////// -->
<!-- ////////DIV DOS SEM LOGIN/////// -->
<!-- //////////////////////////////// -->
</div>
<?php endif ?>


<?php if (isset($_SESSION['id'])): ?>

<div id="comLogin">
	<nav>
		<div class="nav-wrapper teal lighten-2">
		  <a href="#!" class="brand-logo center"><img id="logoTop" src="img/logo4.png"></a>
		  <ul class="left hide-on-med-and-down">
		   	<li><a href="demo.php">Demonstativos</a></li>
		    <li><a href="DAO/crudUsuario.php?acao=logout" onclick="return confirm('Deseja realmente realizar o logout?')">Logout</a></li>

		  </ul>
	    </div>
	</nav>
	<div class="row center-align">
		<div class="col s3">&nbsp;</div>
		<div class="col s6">
			<div class="card">
				<h4>Deseja modificar suas informações?</h4>
			</div>
			<?php 
				$id = $_SESSION['id'];
				$sql = "SELECT * FROM usuarios WHERE idUser = {$id}";
				$user = $con->query($sql);
				$user = $user->FETCH_ASSOC();

			 ?>
			<form action="DAO/crudUsuario.php" class="center-align" method="POST" onsubmit="return validarSenha()"  class="col s6">
			  <h5>Cadastrar-se para receber notícias</h5>
			  <input type="hidden" name="acao" value="update">
			  <input type="hidden" name="id" value="<?php echo $user['idUser'] ?>">
		      <div class="row">
		        <div class="input-field col s12">
		          <input required id="nome" name="nome" type="text" class="validate" value="<?php echo $user['nome']; ?>">
		          <label for="nome">Nome :</label>
		        </div>
		      </div>
		      <div class="row">
		        <div class="input-field col s12">
		          <input required id="email" name="email" type="email" class="validate" value="<?php echo $user['email']; ?>">
		          <label for="email">E-mail :</label>
		        </div>
		      </div>
		      <div class="row">
		        <div class="input-field col s12">
		      	  <input id="dtNasc" name="dtNasc" type="date" class="validate"  value="<?php echo $user['dtNasc']; ?>">
		          <label for="dtNasc">Data de nascimento :</label>
		        </div>
		      </div>

		      <div class="row">
				  <div class="input-field col s12">
				    <select required name="estado">
					    <option value="" disabled selected>Escolha seu estado</option>
					    <option value="AC" <?php echo ($user['estado'] == 'AC') ? "selected='selected'" : '' ; ?>>Acre</option>
					    <option value="AL" <?php echo ($user['estado'] == 'AL') ? "selected='selected'" : '' ; ?>>Alagoas</option>
					    <option value="AP" <?php echo ($user['estado'] == 'AP') ? "selected='selected'" : '' ; ?> >Amapá</option>
					    <option value="AM" <?php echo ($user['estado'] == 'AM') ? "selected='selected'" : '' ; ?>>Amazonas</option>
					    <option value="BA" <?php echo ($user['estado'] == 'BA') ? "selected='selected'" : '' ; ?> >Bahia</option>
					    <option value="CE" <?php echo ($user['estado'] == 'CE') ? "selected='selected'" : '' ; ?> >Ceará</option>
					    <option value="DF" <?php echo ($user['estado'] == 'DF') ? "selected='selected'" : '' ; ?> >Distrito Federal</option>
					    <option value="ES" <?php echo ($user['estado'] == 'ES') ? "selected='selected'" : '' ; ?> >Espírito Santo</option>
					    <option value="GO" <?php echo ($user['estado'] == 'GO') ? "selected='selected'" : '' ; ?> >Goiás</option>
					    <option value="MA" <?php echo ($user['estado'] == 'MA') ? "selected='selected'" : '' ; ?> >Maranhão</option>
					    <option value="MT" <?php echo ($user['estado'] == 'MT') ? "selected='selected'" : '' ; ?> >Mato Grosso</option>
					    <option value="MS" <?php echo ($user['estado'] == 'MS') ? "selected='selected'" : '' ; ?> >Mato Grosso do Sul</option>
					    <option value="MG" <?php echo ($user['estado'] == 'MG') ? "selected='selected'" : '' ; ?> >Minas Gerais</option>
					    <option value="PA" <?php echo ($user['estado'] == 'PA') ? "selected='selected'" : '' ; ?> >Pará</option>
					    <option value="PB" <?php echo ($user['estado'] == 'PB') ? "selected='selected'" : '' ; ?> >Paraíba</option>
					    <option value="PR" <?php echo ($user['estado'] == 'PR') ? "selected='selected'" : '' ; ?> >Paraná</option>
					    <option value="PE" <?php echo ($user['estado'] == 'PE') ? "selected='selected'" : '' ; ?> >Pernambuco</option>
					    <option value="PI" <?php echo ($user['estado'] == 'PI') ? "selected='selected'" : '' ; ?> >Piauí</option>
					    <option value="RJ" <?php echo ($user['estado'] == 'RJ') ? "selected='selected'" : '' ; ?> >Rio de Janeiro</option>
					    <option value="RN" <?php echo ($user['estado'] == 'RN') ? "selected='selected'" : '' ; ?> >Rio Grande do Norte</option>
					    <option value="RS" <?php echo ($user['estado'] == 'RS') ? "selected='selected'" : '' ; ?> >Rio Grande do Sul</option>
					    <option value="RO" <?php echo ($user['estado'] == 'RO') ? "selected='selected'" : '' ; ?> >Rondônia</option>
					    <option value="RR" <?php echo ($user['estado'] == 'RR') ? "selected='selected'" : '' ; ?> >Roraima</option>
					    <option value="SC" <?php echo ($user['estado'] == 'SC') ? "selected='selected'" : '' ; ?> >Santa Catarina</option>
					    <option value="SP" <?php echo ($user['estado'] == 'SP') ? "selected='selected'" : '' ; ?> >São Paulo</option>
					    <option value="SE" <?php echo ($user['estado'] == 'SE') ? "selected='selected'" : '' ; ?> >Sergipe</option>
					    <option value="TO" <?php echo ($user['estado'] == 'TO') ? "selected='selected'" : '' ; ?> >Tocantins</option>
					    <option value="EX" <?php echo ($user['estado'] == 'EX') ? "selected='selected'" : '' ; ?> >Estrangeiro</option>
					    </select>
				    <label>Estado</label>
				  </div>
				</div>
				<div class="row">
			        <div class="input-field col s12">
			          <input required id="senha" name="senha" type="password" class="validate">
			          <label for="senha">Senha : <i class="red-text warningPass" style="display: none;">teste</i></label>
			        </div>
		     	</div>
		     	<div class="row">
			        <div class="input-field col s12">
			          <input id="confirmaSenha" name="confirmaSenha" type="password" class="validate">
			          <label for="confirmaSenha">Confirme sua senha :</label>
			        </div>
		     	</div>

		     	<div class="row">
		     		<div class="col s12">
		     			<p>&nbsp;</p>
		     			<button type="submit" id="btnConfirma" class="col s12 cadastrar waves-effect waves-light btn">Salvar</button>
		     		</div>
		     		<div class="col s12">&nbsp;</div>
		     		<div class="col s12">&nbsp;</div>
		     		<div class="col s12"> 
		     			<a href="DAO/crudUsuario.php?acao=deletar&id=<?php echo $user['idUser'] ?>" onclick="return confirm('Desja realmente cancelar seu registro? Essa ação não poderá ser desfeita.')" class="col s12 cadastrar waves-effect waves-light red btn">Sair da lista de espera.</a>
		     		</div>
		     	</div>
		    </form>

			
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