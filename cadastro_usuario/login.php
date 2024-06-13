<?php
session_start();
$title = 'Login';
include 'cabecalho.php'; ?>

<body>
	<div class="wrapper">
		<form method="post" action="autentica.php" id="formlogin" class="needs-validation" novalidate>
			<h1>Login</h1>
			<div class="container">
				<div class="input-box">
					<!-- <div class="input-group mb-3"> -->
					<input type="email" placeholder="Email " aria-label="Email" aria-describedby="basic-addon1" name="email" required>
					<i class='bx bxs-envelope'></i>
					<div class="invalid-feedback">
						Insira um email válido!
					</div>
					<!-- </div> -->
				</div>



				<div class="input-box">
					<!-- <div class="input-group mb-3"> -->
					<input type="password" placeholder="Senha " aria-label="Senha" aria-describedby="basic-addon1" name="senha" required minlength="4">
					<i class='bx bxs-lock-alt'></i>
					<div class="invalid-feedback">
						Insira uma senha de no mínimo 4 caracteres!
					</div>
					<!-- </div> -->
				</div>

			</div>
			<button type="submit" class="btn">Acessar</button>

			<div class="register-link">
				<p>Não tenho uma conta <a href="cadastro.php">Cadastre-se!</a></p>
			</div>
		</form>

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

		<?php
		if (isset($_GET["erro"])) {
			echo "<div class=\"alert alert-danger \" role=\"alert\">Acesso Negado! Verifique usuário e senha</div>";
		}
		if (isset($_GET["erro1"])) {
			echo "<div class=\"alert alert-danger \" role=\"alert\">Faça login para acessar esta pagina</div>";
		}
		if (isset($_GET["sucesso"])) {
			echo "<div class=\"alert alert-success \" role=\"alert\">Cadastro realizado com sucesso!</div>";
		}
		?>
		<!-- </div> -->
	</div>
	<script>
		//Validação do formulário com bootstrap
		(function() {
			'use strict'





			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.querySelectorAll('.needs-validation')

			// Loop over them and prevent submission
			Array.prototype.slice.call(forms)
				.forEach(function(form) {
					form.addEventListener('submit', function(event) {
						if (!form.checkValidity()) {
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