<?php
$add = !isset($_GET['id']);
if (!$add) {
	$id = core::$model['protect']->protectID($_GET['id']);
	$getMenu = core::$model['menu']->topMenu_read($id);
}
$menuName = $add ? '' : $getMenu['name'];
$menuLink = $add ? '' : $getMenu['link'];
?>
<div class="container-fluid p-3">
	<div class='card'>
		<div class='card-header'>
			<?php echo $add ? 'Dodanie menu' : 'Edycja menu' ?>
		</div>
		<div class="card-body">
			<form method="POST">
				<div class="form-group was-validated">
					<label>Nazwa</label>
					<input type="text" minlength="3" class="form-control" name="name" placeholder="Nazwa linka" value="<?php echo $menuName ?>" required>
					<div class="invalid-feedback">Tytuł musi posiadać przynajmniej 3 znaki</div>
				</div>
				<div class="form-group">
					<label>Link</label>
					<?php core::$model['link']->bootstrapLinkGenerator($menuLink); ?>
				</div>
				<button class="btn btn-primary"><?php echo $add ? 'Dodaj' : 'Zapisz' ?></button>
				<?php
				if (!$add) {
					echo '<a href="menuDelete-'.$_GET['id'].'.html" class="btn btn-danger" onclick="return confirm(\'Czy na pewno chcesz usunąć ten element?\nTego nie da się cofnąć.\');">Usuń</a>';
				}
				?>
			</form>
		</div>
	</div>
</div>