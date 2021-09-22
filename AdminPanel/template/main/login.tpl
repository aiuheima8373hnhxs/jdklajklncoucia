<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>{$title}</title>
	{$fontawesome}
	{$bootstrap}
	{$adminlte}
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="index.php">{$adminPanel_title}</a>
		</div>
		<div class="card">
			<div class="card-body login-card-body">
				{if isset($error)}
					<div class="alert alert-danger" role="alert">{$error}</div>
				{/if}
				<p class="login-box-msg">{$adminPanel_loginMessage}</p>
				<form method="post">
					<div class="input-group mb-3">
						<input type="text" name="login" class="form-control" placeholder="Login">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" name="haslo" class="form-control" placeholder="Hasło">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-8"></div>
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Zaloguj</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</body>
</html>