<?php
if (isset($_COOKIE['lang'])) {
	switch ($_COOKIE['lang']) {
		case 'bn':
			include("lang/bn.php");
			break;
		case 'cn':
			include("lang/cn.php");
			break;
		case 'de':
			include("lang/de.php");
			break;
		case 'en':
			include("lang/en.php");
			break;
		case 'esp':
			include("lang/esp.php");
			break;
		case 'fr':
			include("lang/fr.php");
			break;
		case 'in':
			include("lang/in.php");
			break;
		case 'jp':
			include("lang/jp.php");
			break;
		case 'ko':
			include("lang/ko.php");
			break;
		case 'pt':
			include("lang/pt.php");
			break;
		case 'ru':
			include("lang/ru.php");
			break;
		default:
			include("lang/sa.php");
			break;
	}
} else {
	include("lang/en.php");
}
include("query/fonction.php");
include("dico.php");
?>





<!doctype html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $title; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="login/css/style.css">

</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h3 class="box-title m-b-20"><?php echo $login ?> admin</h3>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap py-5">
						<div class="img d-flex align-items-center justify-content-center" style="background-image: url(login/images/logot.png);"></div>
						<h3 class="text-center mb-0">taxi App</h3>

						<form class="login-form" id="loginform" action="query/action.php" method="post">
							<div class="form-group">
								<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user" ></span></div>
								<input type="email" class="form-control" placeholder="correo" value="admin@admin.com" required name="email_sc">
							</div>
							<div class="form-group">
								<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock" ></span></div>
								<input type="password" class="form-control" placeholder="Password" value="admin" required name="mdp_sc">
							</div>

							<div class="form-group">
								<button type="submit" class="btn form-control btn-primary rounded submit px-3"><?php echo $login ?></button>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/main.js"></script>


	<script src="assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap tether Core JavaScript -->
	<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!-- slimscrollbar scrollbar JavaScript -->
	<script src="js/jquery.slimscroll.js"></script>
	<!--Wave Effects -->
	<script src="js/waves.js"></script>
	<!--Menu sidebar -->
	<script src="js/sidebarmenu.js"></script>
	<!--stickey kit -->
	<script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
	<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
	<!--Custom JavaScript -->
	<script src="js/custom.min.js"></script>
	<!-- ============================================================== -->
	<!-- Style switcher -->
	<!-- ============================================================== -->
	<script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>


	<!--Custom JavaScript -->
	<!-- <script src="js/custom.min.js"></script> -->
	<script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
	<script src="js/toastr.js"></script>

	<?php if (isset($_SESSION['status']) &&  $_SESSION['status'] == 1) { ?>
		<script>
			showSuccess();
		</script>
	<?php } else if (isset($_SESSION['status']) &&  $_SESSION['status'] == 2) { ?>
		<script>
			showFailed();
		</script>
	<?php } else if (isset($_SESSION['status']) &&  $_SESSION['status'] == 3) { ?>
		<script>
			showWarningIncorrect();
		</script>
	<?php }
	unset($_SESSION['status']); ?>

</body>

</html>