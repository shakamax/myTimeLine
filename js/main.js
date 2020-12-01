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