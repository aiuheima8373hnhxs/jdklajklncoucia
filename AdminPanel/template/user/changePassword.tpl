<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Zmiana hasła użytkownika</h1>
			</div>
		</div>
	</div>
</div>
{block name=test}
    123
{/block}
<div class="content">
	<div class="container-fluid">
		<form method="post">
			<div class="card">
				<div class="card-body">
					<div class="form-group was-validated">
						<label for="haslo">Aktualne hasło</label>
						<input type="password" minlength="6" class="form-control" id="haslo" name="haslo" placeholder="Aktualne hasło" required>
					</div>
					<div class="form-group was-validated">
						<label for="haslo2">Nowe hasło</label>
						<input type="password" minlength="6" class="form-control" id="haslo2" name="haslo2" placeholder="Nowe hasło" required>
					</div>
					<div class="form-group was-validated">
						<label for="haslo2_re">Powtórz nowe hasło</label>
						<input type="password" minlength="6" class="form-control" id="haslo2_re" name="haslo2_re" placeholder="Powtórz nowe hasło" required>
					</div>
					<button type="submit" class="btn btn-primary">Zmień hasło</button>
				</div>
			</div>
		</form>
	</div>
</div>