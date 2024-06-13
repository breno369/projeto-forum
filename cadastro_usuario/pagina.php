<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['nome']) == true)) {
	unset($_SESSION['email']);
	unset($_SESSION['nome']);
	session_unset();
	header('location:login.php?erro');
}

$nome = $_SESSION['nome'];

?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Página</title>

</head>

<body>

	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="#">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Dropdown
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">Action</a></li>
							<li><a class="dropdown-item" href="#">Another action</a></li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="#">Something else here</a></li>
						</ul>
					</li>
				</ul>
				<form class="d-flex" role="search">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form>
				<ul class="navbar-nav ms-3 me-5">
					<li class="nav-item dropdown me-5">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Perfil
						</a>
						<ul class="dropdown-menu">
							<li>
								<p class="dropdown-item"><?php echo "Olá $nome"; ?></p>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="#">Meus Dados</a></li>
							<li><a class="dropdown-item" href="logout.php">Sair</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<h1 class="mt-2">
			Seja bem vindo ao sistema!
		</h1>
	</div>


</body>

</html>