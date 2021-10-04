<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a href="#" class="navbar-brand">Company</a>
			<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item"><a class="nav-link" href="login.php">Masuk</a></li>
					<li class="nav-item"><a class="nav-link active" href="#">Daftar</a></li>
				</ul>
			</div>
		</div>
	</nav>
</header>

<div class="container col-12 col-sm-11 col-md-8 col-lg-6">
	<form id="registerForm" action="<?= BASE_URL ?>/register/register" method="post" autocomplete="off">
		<?php
			if(!empty($_SESSION['register_error_message'])) {
				echo '<div class="alert alert-danger">' . $_SESSION['register_error_message'] . '</div>';
			}

			unset($_SESSION['register_error_message']);
		?>
		
		<div class="row mb-3">
			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating">
					<input type="text" class="form-control" id="firstName" placeholder="First Name" name="first_name">
					<label for="firstName">First Name</label>
				</div>
			</div>
			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating">
					<input type="text" class="form-control" id="lastName" placeholder="Last Name" name="last_name">
					<label for="lastName">Last Name</label>
				</div>
			</div>
		</div>

		<div class="form-floating mb-2">
			<input type="text" class="form-control" id="email" placeholder="Email" name="email">
			<label for="email">Email</label>
		</div>

		<div class="form-floating mb-2">
			<input type="text" class="form-control" id="username" placeholder="Username" name="username">
			<label for="username">Username</label>
		</div>

		<div class="row mb-3">
			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating">
					<input type="password" class="form-control" id="password" placeholder="Password" name="password">
					<label for="password">Password</label>
				</div>
			</div>
			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating">
					<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirm_password">
					<label for="confirmPassword">Confirm Password</label>
				</div>
			</div>
		</div>

		<div class="form-floating mb-3">
			<input type="date" class="form-control" id="birthDate" placeholder="Birth Date" name="birth_date">
			<label for="birthDate">Birth Date</label>
		</div>

		<div class="form-group mb-3">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="gender" id="genderMale" checked>
				<label class="form-check-label" for="genderMale">Laki-laki</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="gender" id="genderFemale">
				<label class="form-check-label" for="genderFemale">Perempuan</label>
			</div>
		</div>

		<div class="form-group mb-3">
			<div class="g-recaptcha" data-sitekey="<?= RECAPTCHA_SITE; ?>" data-callback="recaptchaCallback">
			</div>
			<input type="hidden" class="hiddenRecaptcha required" name="hidden_recaptcha" id="hiddenRecaptcha">
		</div>

		<div class="d-grid">
			<button type="submit" class="btn btn-primary">DAFTAR</button>
		</div>
	</form>
</div>

<script src="<?= BASE_URL; ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/vendor/validation/jquery.validate.min.js"></script>
<script src="<?= BASE_URL; ?>/assets/vendor/validation/localization/messages_id.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>

<script type="text/javascript">
	function recaptchaCallback() {
		$('#hiddenRecaptcha').valid();
	};

	$(document).ready(function() {
		$.validator.addMethod('lettersOnly', function(value, element) {
			return this.optional(element) || /^[A-Za-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
		}, 'Hanya boleh huruf dan spasi'); 

		$.validator.addMethod('emailEx', function(value, element) {
			return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
		}, 'Email tidak valid');

		$.validator.addMethod('noSpaceSymbol', function(value, element) {
			return this.optional(element) || /^[a-zA-Z0-9_]+$/i.test(value);
		}, 'Tidak boleh spasi dan simbol selain underscore');

		$.validator.addMethod('lessThanToday', function(value, element) {
			return new Date(value) < new Date();
		}, 'Tanggal lahir tidak valid');

		$('#registerForm').validate({
			ignore: '.ignore',

			rules: {
				first_name: {
					required: true,
					lettersOnly: true,
					minlength: 2
				},
				last_name: {
					required: true,
					lettersOnly: true,
					minlength: 2
				},
				email: {
					required: true,
					emailEx: true,
					/* remote: {
						url: 'email_check.php',
						type: 'post'
					} */
				},
				username: {
					required: true,
					noSpaceSymbol: true,
					minlength: 5,
					maxlength: 36,
					/* remote: {
						url: 'username_check.php',
						type: 'post'
					} */
				},
				password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: '#password'
				},
				birth_date: {
					required: true,
					dateISO: true,
					lessThanToday: true
				},
				gender: {
					required: true,
				},
				hidden_recaptcha: {
					required: function() {
						return grecaptcha.getResponse() == '';
					}
				}
			},
			/* messages: {
				first_name: {
					required: 'Harap masukkan nama pertama',
					minlength: 'Nama pertama minimal {0} karakter'
				}
			}, */
			errorElement: 'em',
			errorPlacement: function(error, element) {
				error.addClass('invalid-feedback');

				if(element.prop('type') === 'radio') {
					error.insertAfter(element.next('label'));
				}
				else {
					error.insertAfter(element);
				}
			},
			highlight: function(element, errorClass, validClass) {
				$(element).addClass('is-invalid').removeClass('is-valid');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).addClass('is-valid').removeClass('is-invalid');
			},
			submitHandler: function(form) {
				if($("#form").valid()) {
					form.submit();
				}
			}
		});
	});
</script>