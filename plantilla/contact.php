<!DOCTYPE html>
<html lang="en">

<head>
	<title>Veterinaria | HF	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="images/huella.png">

	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/animate.css">

	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



	<link rel="stylesheet" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="css/jquery.timepicker.css">

	<link rel="stylesheet" href="css/flaticon.css">
	<link rel="stylesheet" href="css/style.css">
		<!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>


<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<!-- Logo alineado a la izquierda -->
				<a href="" class="navbar-brand d-flex align-items-center">
					<img src="images/verde.jpeg" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px;">
					<h1 class="m-0 display-5 text-dark">
                <span class="text-green font-weight-bold">Veterinaria</span> 
                <span class="text-dark font-weight-bold">HF</span>
            </h1>
				</a>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
					<li class="nav-item"><a href="services.php" class="nav-link">Servicio</a></li>
					<li class="nav-item"><a href="blog.php" class="nav-link">Nosotros</a></li>
					<li class="nav-item active"><a href="contact.php" class="nav-link">Contáctanos</a></li>
					<li class="nav-item">
            <a href="../admin/" class="nav-link font-weight-bold">
                <i class="fas fa-user"></i>
            </a>
            </li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- END nav -->
	<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text align-items-end">
				<div class="col-md-9 ftco-animate pb-5">
					<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Contacto <i class="ion-ios-arrow-forward"></i></span></p>
					<h1 class="mb-0 bread">Contacto</h1>
				</div>
			</div>
		</div>
	</section>


	<section class="ftco-section bg-light">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Comunícate con Nosotros</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="wrapper">
						<div class="row mb-5">
							<div class="col-md-4">
								<div class="dbox w-100 text-center">
									<div class="icon d-flex align-items-center justify-content-center">
										<span class="fa fa-map-marker"></span>
									</div>
									<div class="text">
										<p><span>Dirección:</span> Av. Universitaria 1234, San Martín de Porres, Lima, Perú.</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="dbox w-100 text-center">
									<div class="icon d-flex align-items-center justify-content-center">
										<span class="fa fa-phone"></span>
									</div>
									<div class="text">
										<p><span>Teléfono:</span> <a href="tel://1234567920">+51 932 3929 210</a></p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="dbox w-100 text-center">
									<div class="icon d-flex align-items-center justify-content-center">
										<span class="fa fa-paper-plane"></span>
									</div>
									<div class="text">
										<p><span>Correo Electrónico:</span> <a href="info@vetcare-smp.com">carlosegoavil2004@gmail.com</a></p>
									</div>
								</div>
							</div>
						</div>
						<div class="row no-gutters">
    <div class="col-md-7">
        <div class="contact-wrap w-100 p-md-5 p-4">
            <h3 class="mb-4">Contáctanos</h3>
            <form method="POST" action="send_email.php" id="contactForm" name="contactForm" class="contactForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label" for="name">Nombre Completo</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nombre" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label" for="email">Dirección de Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Correo Electrónico" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="label" for="subject">Asunto</label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="label" for="#">Mensaje</label>
                            <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Mensaje" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" value="Enviar Mensaje" class="btn btn-primary">
                            <input type="reset" value="Limpiar" class="btn btn-secondary">
                            <div class="submitting"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-5 d-flex align-items-stretch">
        <div class="info-wrap w-100 p-5 img" style="background-image: url(images/img.jpg);">
        </div>
    </div>
</div>

	</section>


	

	<footer class="footer" style="padding: 30px 0; background-color: #070605;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-1">
                <h2 class="footer-heading" style="font-size: 1.1rem;">Cuidado de Mascotas</h2>
                <p style="font-size: 0.8rem; margin-bottom: 5px;">Cuidado completo para una vida saludable.</p>
                <ul class="ftco-footer-social p-0" style="margin-bottom: 0;">
                    <li class="ftco-animate"><a href="#" data-toggle="tooltip" title="Twitter"><span class="fa fa-twitter"></span></a></li>
                    <li class="ftco-animate"><a href="#" data-toggle="tooltip" title="Facebook"><span class="fa fa-facebook"></span></a></li>
                    <li class="ftco-animate"><a href="#" data-toggle="tooltip" title="Instagram"><span class="fa fa-instagram"></span></a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3 mb-1">
                <h2 class="footer-heading" style="font-size: 1.1rem;">Últimas Noticias</h2>
                <div class="block-21 mb-1 d-flex">
                    <a class="img mr-2 rounded" style="background-image: url(images/image_1.jpg); width: 50px; height: 50px;"></a>
                    <div class="text" style="font-size: 0.8rem;">
                        <h3 class="heading"><a href="#">Signos tempranos de enfermedades.</a></h3>
                        <div class="meta">
                            <div><a href="#"><span class="icon-calendar"></span> 7 de octubre</a></div>
                        </div>
                    </div>
                </div>
                <div class="block-21 mb-1 d-flex">
                    <a class="img mr-2 rounded" style="background-image: url(images/image_2.jpg); width: 50px; height: 50px;"></a>
                    <div class="text" style="font-size: 0.8rem;">
                        <h3 class="heading"><a href="#">Desparasitación regular es clave.</a></h3>
                        <div class="meta">
                            <div><a href="#"><span class="icon-calendar"></span> 20 de octubre</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-1">
                <h2 class="footer-heading" style="font-size: 1.1rem;">Enlaces Rápidos</h2>
                <ul class="list-unstyled" style="font-size: 0.8rem;">
                    <li><a href="#" class="py-1 d-block">Inicio</a></li>
                    <li><a href="services.php" class="py-1 d-block">Servicios</a></li>
                    <li><a href="blog.php" class="py-1 d-block">Nosotros</a></li>
                    <li><a href="contact.php" class="py-1 d-block">Contáctanos</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3 mb-1">
                <h2 class="footer-heading" style="font-size: 1.1rem;">¿Preguntas?</h2>
                <div class="block-23 mb-1">
                    <ul style="font-size: 0.8rem;">
                        <li><span class="icon fa fa-map"></span><span class="text">Av. Universitaria 1234, Lima.</span></li>
                        <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+51 932 3929 210</span></a></li>
                        <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">carlosegoavil2004@gmail.com</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 text-center">
                <p class="copyright" style="font-size: 0.7rem; margin-bottom: 0;">
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script> Todos los derechos reservados | <i class="fa fa-heart" aria-hidden="true"></i> <a href="#"> Clínica Veterinaria SMP HF</a>
                </p>
            </div>
        </div>
    </div>
</footer>





	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
		</svg></div>


	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-migrate-3.0.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.stellar.min.js"></script>
	<script src="js/jquery.animateNumber.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/jquery.timepicker.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/scrollax.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
	<script src="js/google-map.js"></script>
	<script src="js/main.js"></script>
    <script src="js/contacto.js"></script>
	<!-- SweetAlert2 JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>