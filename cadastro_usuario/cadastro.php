<?php
session_start();
$title = 'Cadastro de novo usuário';
include 'cabecalho.php'; ?>

<body>

	<div class="wrapper">
		<form method="post" action="processa.php" id="formlogin" class="needs-validation" novalidate>

			<h1>Cadastro</h1>
			<!-- <div class="container"> -->


			<!-- ----------CEP----------
				<div class="input-box">
					<input type="number" id="cep" class="form-control" placeholder="CEP " aria-label="CEP"
						aria-describedby="basic-addon1" name="cep" required>
					<i class='bx bxs-user'></i>
					<div class="invalid-feedback">
						Insira um CEP!
					</div>
				</div> -->

			<div class="input-box">

				<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
					Informações pessoais
				</button>
				<div class="invalid-feedback">
					Insira um nome!
				</div>
			</div>
			<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">

				<div class="offcanvas-header" style="background-color: #8990a2;">
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>

				<div class="offcanvas-body" style="background-color: #8990a2;">

					<!------------CEP------------>
					<div class="input-box">
						<input type="text" id="cep" class="form-control" placeholder="CEP " aria-label="CEP" aria-describedby="basic-addon1" name="cep" required maxlength="8">
						<div class="invalid-feedback">
							Insira um CEP!
						</div>
					</div>
					<button type="button" class="btn btn-outline-info" onclick="buscaCEP()">Buscar CEP</button>

					<!------------NUMERO RESIDENCIAL------------>
					<div class="input-box">
						<input type="number" name="num" class="form-control" placeholder="Numero Residencial" aria-label="num" aria-describedby="basic-addon1" maxlength="5" required>
						<div class="invalid-feedback">
							Insira um numero residencial!
						</div>
					</div>

					<!------------LOGRADOURO------------>
					<div class="input-box">
						<input type="text" id="logradouro" class="form-control mb-2" placeholder="Logradouro" aria-label="Logradouro" aria-describedby="basic-addon1" name="logradouro" required>
						<div class="invalid-feedback">
							Insira um logradouro!
						</div>
					</div>

					<!------------BAIRRO------------>
					<div class="input-box">
						<input type="text" id="bairro" class="form-control  mb-2" placeholder="Bairro" aria-label="Bairro" aria-describedby="basic-addon1" name="bairro" required>
						<div class="invalid-feedback">
							Insira um bairro!
						</div>
					</div>

					<!------------CIDADE------------>
					<div class="input-box">
						<input type="text" id="cidade" class="form-control  mb-2" placeholder="Cidade" aria-label="Cidade" aria-describedby="basic-addon1" name="cidade" required>
						<div class="invalid-feedback">
							Insira uma cidade!
						</div>
					</div>

					<!------------ESTADO------------>
					<div class="input-box">
						<input type="text" id="estado" class="form-control  mb-2" placeholder="Estado" aria-label="Estado" aria-describedby="basic-addon1" name="estado" required>
						<div class="invalid-feedback">
							Insira um estado!
						</div>
					</div>

					<!------------NOME COMPLETO------------>
					<div class="input-box">
						<input type="text" name="nome" placeholder="Nome Completo" aria-label="Nome" aria-describedby="basic-addon1" required>
						<div class="invalid-feedback">
							Insira um nome!
						</div>
					</div>

					<!------------DATA DE NASCIMENTO------------>
					<div class="input-box">
						<input id="datePickerId" type="date" class="form-control" placeholder="nasc" aria-label="nasc" aria-describedby="basic-addon1" name="nasc" required>
						<div class="invalid-feedback">
							Insira uma data de nascimento!
						</div>
					</div>

					<!------------RG------------>
					<div class="input-box">
						<input type="number" class="form-control" placeholder="RG" aria-label="RG" aria-describedby="basic-addon1" name="rg" maxlength="10" required>
						<div class="invalid-feedback">
							Insira um RG!
						</div>
					</div>


					<!------------ORGÃO EMISSOR------------>
					<div class="input-box">
						<input type="text" class="form-control" placeholder="Órgão Emissor" aria-label="emissor" aria-describedby="basic-addon1" name="emissor" required>
						<div class="invalid-feedback">
							Insira um orgão emissor!
						</div>
					</div>

					<!------------CPF------------>
					<div class="input-box">
						<input type="text" id="cpf" class="form-control" placeholder="CPF " aria-label="CPF" aria-describedby="basic-addon1" name="cpf" maxlength="11" required onblur="a()">
						<div class="invalid-feedback">
							Insira um CPF!
						</div>
					</div>

					<!------------SEXO------------>
					<div class="input-box">
						<select name="sexo" class="form-select">
							<option value="1" disabled selected>Sexo</option>
							<option value="2">Masculino</option>
							<option value="3">Feminino</option>
							<option value="4">Não Informado</option>
						</select>
					</div>
				</div>
			</div>

			<!------------USUARIO------------>
			<div class="input-box">
				<input type="text" name="usuario" placeholder="Usuario" aria-label="Nome" aria-describedby="basic-addon1" required>
				<i class='bx bxs-user'></i>
				<div class="invalid-feedback">
					Insira um nome de usuario!
				</div>
			</div>

			<!------------EMAIL------------>
			<div class="input-box">
				<input type="email" placeholder="Email " aria-label="Email" aria-describedby="basic-addon1" name="email" required>
				<i class='bx bxs-envelope'></i>
				<div class="invalid-feedback">
					Insira um email válido!
				</div>
			</div>

			<!------------SENHA------------>
			<div class="input-box">
				<input type="password" placeholder="Senha " aria-label="Senha" aria-describedby="basic-addon1" name="senha" required minlength="4">
				<i class='bx bxs-lock-alt'></i>
				<div class="invalid-feedback">
					Insira uma senha de no mínimo 4 caracteres!
				</div>
			</div>

			<!------------CONFIRMA SENHA------------>
			<div class="input-box">
				<input type="password" placeholder="Confirme sua senha " aria-label="Confirmar" aria-describedby="basic-addon1" name="confirm" required minlength="4">
				<i class='bx bxs-lock-alt'></i>
				<div class="invalid-feedback">
					Confirme sua senha!
				</div>
			</div>

			<button type="submit" class="btn">Cadastrar</button>

			<div class="register-link">
				<p>Tenho uma conta <a href="login.php">Logar</a></p>
			</div>

		</form>
		<?php
		if (isset($_GET["erro"])) {
			if ($_GET['erro'] === 'user') {
				echo '<div class="alert alert-danger" role="alert">Email Duplicado</div>';
			} elseif ($_GET['erro'] === 'pessoa') {
				echo '<div class="alert alert-danger" role="alert">Erro nas informações pessoais</div>';
			} else {
				echo '<div class="alert alert-danger" role="alert">Problemas ao salvar cadastro no servidor!</div>';
			}
		}
		?>

	</div>

	<!-- </div> -->
	<!--------------------LIBRAS-------------------->
	<div vw class="enabled">
		<div vw-access-button class="active"></div>
		<div vw-plugin-wrapper>
			<div class="vw-plugin-top-wrapper"></div>
		</div>
	</div>
	<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
	<script>
		new window.VLibras.Widget({
			rootPah: '/app',
			personalization: 'https://vlibras.gov.br/config/default_logo.json',
			opacity: 0.5,
			position: 'L',
			avatar: 'random',
		});
	</script>

	<script>
		function buscaCEP() {

			var cep = document.getElementById('cep').value;
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'https://viacep.com.br/ws/' + cep + '/json/', true);
			console.log(xhr);

			xhr.onload = function() {
				if (xhr.status >= 200 && xhr.status < 400) {
					var data = JSON.parse(xhr.responseText);
					if (data.erro) {
						alert('CEP não foi encontrado');
						// cep não encontrado
					} else {
						document.getElementById('logradouro').value = data.logradouro;
						document.getElementById('bairro').value = data.bairro;
						document.getElementById('cidade').value = data.localidade;
						document.getElementById('estado').value = data.uf;
					}
				} else {
					alert('erro ao buscar cep');
				}
			};
			xhr.send();
		}

		// validarCPF
		function validaCPF(cpf) {
			var Soma = 0
			var Resto

			var strCPF = String(cpf).replace(/[^\d]/g, '')

			if (strCPF.length !== 11)
				return false

			if ([
					'00000000000',
					'11111111111',
					'22222222222',
					'33333333333',
					'44444444444',
					'55555555555',
					'66666666666',
					'77777777777',
					'88888888888',
					'99999999999',
				].indexOf(strCPF) !== -1)
				return false

			for (i = 1; i <= 9; i++)
				Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);

			Resto = (Soma * 10) % 11

			if ((Resto == 10) || (Resto == 11))
				Resto = 0

			if (Resto != parseInt(strCPF.substring(9, 10)))
				return false

			Soma = 0

			for (i = 1; i <= 10; i++)
				Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i)

			Resto = (Soma * 10) % 11

			if ((Resto == 10) || (Resto == 11))
				Resto = 0

			if (Resto != parseInt(strCPF.substring(10, 11)))
				return false

			return true
		}

		function a() {
			$cpf = document.getElementById('cpf').value;
			console.log($cpf);
			$cpf = validaCPF($cpf);
			console.log($cpf);
			if ($cpf != true) {
				alert('CPF invalido')
			}
		}
		//Validação do formulário com bootstrap
		(function() {
			'use strict'
			if (!document.createElement('input').setCustomValidity) {
				return;
			}
			var pass1 = document.getElementById('password1');
			var pass2 = document.getElementById('password2');

			function validateForm() {

				var pass1 = document.getElementById('password1');

				var pass1Val = pass1.value;
				var pass2Val = pass2.value;

				if (pass1Val && pass2Val && (pass1Val != pass2Val)) {
					pass2.setCustomValidity("The password  confirmation is different to the password value");
				} else {
					pass2.setCustomValidity("");
				}
			}

			if (pass1 && pass2) {
				pass1.addEventListener('change', validateForm, false);
				pass2.addEventListener('change', validateForm, false);

				validateForm();
			}

			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.querySelectorAll('.needs-validation')

			// Loop over them and prevent submission
			Array.prototype.slice.call(forms)
				.forEach(function(form) {
					form.addEventListener('submit', function(event) {
						var senha = document.getElementsByName('senha')[0];
						var confirm = document.getElementsByName('confirm')[0];


						if (!form.checkValidity() || (senha.value != confirm.value)) {
							confirm.classList.add("is-invalid");
							event.preventDefault()
							event.stopPropagation()
						}

						form.classList.add('was-validated')
					}, false)
				})
		})()
	</script>
</body>

</html>