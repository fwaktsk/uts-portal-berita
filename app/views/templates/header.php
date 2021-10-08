<!DOCTYPE html>

<html lang="id">

<head>
	<title><?= $data['title']; ?></title>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<link rel="stylesheet" href="<?= BASE_URL; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">
</head>

<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a href="#" class="navbar-brand"><?= NAVBAR_BRAND ?></a>
				<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav ms-auto">
						<?php foreach ($data['navbar'] as $key => $val) : ?>
							<li class="nav-item">
								<a class="nav-link<?= $data['navbar'][$key]['active'] === true ? ' active' : '' ?>" href="<?= $data['navbar'][$key]['href'] ?>">
									<?= $key ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</nav>
	</header>