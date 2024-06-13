<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
	<link rel="shortcut icon" href="../img/Iconeberg-sem-fundo.ico" type="image/x-icon">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: "poppins", sans-serif;
		}

		body {
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			background-color: #788199;
		}

		/* .container{
			display: grid;
			grid-template-columns: 50% 50%;
			grid-column-gap: 10px;
			
		} */

		.wrapper {
			width: 420px;
			background-color: #8990a2;
			border: 2px solid rgba(255, 255, 255, 0.2);
			backdrop-filter: blur(20px);
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			color: #fff;
			border-radius: 10px;
			padding: 30px 40px;
		}

		.wrapper h1 {
			font-size: 36px;
			text-align: center;
		}

		.wrapper .input-box {
			position: relative;
			width: 100%;
			/* width: 378px; */
			height: 50px;
			position: relative;
			margin: 30px 0;
		}
		
		.input-box input {
			width: 100%;
			height: 100%;
			background: transparent;
			border: none;
			outline: none;
			border: 2px solid rgba(255, 255, 255, 0.2);
			border-radius: 40px;
			font-size: 16px;
			color: #fff;
			padding: 20px 45px 20px 20px;
		}

		.input-box input::placeholder {
			color: #fff;
		}

		.input-box i {
			position: absolute;
			right: 20px;
			top: 50%;
			transform: translateY(-50%);
			font-size: 20px;

		}

		.error {
			width: 100%;
			height: 100%;
			background: transparent;
			border: none;
			outline: none;
			border: 2px solid rgba(255, 0, 0, 0.74);
			border-radius: 40px;
			font-size: 16px;
			color: rgba(255, 0, 0, 0.74, );
			padding: 20px 45px 20px 20px;
		}

		.wrapper .remember-forgot {
			display: flex;
			justify-content: space-between;
			font-size: 14.5px;
			margin: -15px 0px 15px;
		}

		.remember-forgot label input {
			accent-color: #fff;
			margin-right: 3px;
		}

		.remember-forgot a {
			color: #fff;
			text-decoration: none;
		}

		.remember-forgot a:hover {
			text-decoration: underline;
		}

		.wrapper .btn {
			width: 100%;
			height: 45px;
			background-color: #fff;
			border: none;
			outline: none;
			border-radius: 40px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			font-size: 16px;
			color: #333;
			font-weight: 600;
		}

		.wrapper .register-link {
			font-size: 14.5px;
			text-align: center;
			margin: 20px 0 15px;
		}

		.register-link p a {
			color: #fff;
			text-decoration: none;
			font-weight: 600;
		}

		.register-link p a:hover {
			text-decoration: underline;

		}

		.form-select{
			background-color: transparent;
			border: 2px solid rgba(255, 255, 255, 0.2);
			border-radius: 40px;
			font-size: 16px;
			color: #fff;
			padding: 10px 10px 10px 20px;

		}
		select option {
			background-color: #8990a2;

		}

		.offcanvas-backdrop{
			background-color: transparent;
		}

	</style>
</head>