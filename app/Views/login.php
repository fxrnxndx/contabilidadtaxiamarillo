<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Taxi</title>
	<!-- loader-->
	<link href=<?php echo (base_url("assets/css/pace.min.css")); ?> rel="stylesheet" />
	<script src=<?php echo (base_url("assets/js/pace.min.js")); ?>></script>
	<!--favicon-->
	<link rel="icon" href=<?php echo (base_url("assets/images/favicon.png")); ?> type="image/x-icon">
	<!-- Bootstrap core CSS-->
	<link href=<?php echo (base_url("assets/css/bootstrap.min.css")); ?> rel="stylesheet" />
	<!-- animate CSS-->
	<link href=<?php echo (base_url("assets/css/animate.css")); ?>rel="stylesheet" type="text/css" />
	<!-- Icons CSS-->
	<link href=<?php echo (base_url("assets/css/icons.css")); ?>rel="stylesheet" type="text/css" />
	<!-- Custom Style-->
	<link href=<?php echo (base_url("assets/css/app-style.css")); ?> rel="stylesheet" />
	<!-- notificaciones-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css">

</head>

<body class="bg-theme bg-theme3">

	<!-- start loader -->
	<div id="pageloader-overlay" class="visible incoming">
		<div class="loader-wrapper-outer">
			<div class="loader-wrapper-inner">
				<div class="loader"></div>
			</div>
		</div>
	</div>
	<!-- end loader -->

	<!-- Start wrapper-->
	<div id="wrapper">
		<input type="hidden" value=<?= esc($notificacion) ?> id="notificacion">
		<form action="<?php echo (base_url("Home/validacionlogin")); ?>" method="post" accept-charset="utf-8">
			<div class="loader-wrapper">
				<div class="lds-ring">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
			<div class="card card-authentication1 mx-auto my-5">
				<div class="card-body">
					<div class="card-content p-2">
						<div class="text-center">
							<img src=<?php echo (base_url("assets/images/logo.jpg")); ?> width="100%" alt="logo icon">
						</div>
						<div class="card-title text-uppercase text-center py-3">BIENVENIDO</div>

						<div class="form-group">
							<label for="exampleInputUsername" class="sr-only">Usuario</label>
							<div class="position-relative has-icon-right">
								<input type="text" id="exampleInputUsername" name="usuario"
									class="form-control input-shadow" placeholder="Ingresar usuario">
								<div class="form-control-position">
									<i class="icon-user"></i>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword" class="sr-only">Contraseña</label>
							<div class="position-relative has-icon-right">
								<input type="password" id="exampleInputPassword" name="contra"
									class="form-control input-shadow" placeholder="Ingresar contraseña">
								<div class="form-control-position">
									<i class="icon-lock"></i>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-6">

							</div>
							<div class="form-group col-6 text-right">
								<!--<a href="reset-password.html">Olvide contraseña</a>-->
							</div>
						</div>
						<button type="submit" class="btn btn-light btn-block">Entrar</button>


					</div>

				</div>


			</div>
		</form>



		<!--Start Back To Top Button-->
		<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
		<!--End Back To Top Button-->



	</div><!--wrapper-->

	<!-- Bootstrap core JavaScript-->
	<script src=<?php echo (base_url("assets/js/jquery.min.js")); ?>></script>
	<script src=<?php echo (base_url("assets/js/popper.min.js")); ?>></script>
	<script src=<?php echo (base_url("assets/js/bootstrap.min.js")); ?>></script>

	<!-- sidebar-menu js -->
	<script src=<?php echo (base_url("assets/js/sidebar-menu.js")); ?>></script>

	<!-- Custom scripts -->
	<script src=<?php echo (base_url("assets/js/app-script.js")); ?>></script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			if (document.getElementById("notificacion").value == "true") {
				toastr.warning("USUARIO O CONTRASEÑA INCORRECTA");
			}
		});

		/*function notificacion(activo){
			if(activo==true)
			{
				toastr.success("Hoola mundo");
			}
		}*/

		/*$(function(){
			toastr.success("Hoola mundo")
			toastr.info("Hoola mundo")
			toastr.warning("Hoola mundo")
			toastr.error("Hoola mundo")
		});*/
	</script>
</body>

</html>