<?php
$jumbotronData = core::$model['jumbotron']->read(true);
?>
<div class='content pt-3'>
	<div class="container-fluid">
		<div class='card'>
			<div class='card-header'>
				Edycja telebimu na stronie
			</div>
			<div class="card-body">
				<form method="POST">
					<div class="custom-control custom-switch">
						<input type="checkbox" name="show" class="custom-control-input" name="type_default" id="jumbotronShow" <?php echo (boolval($jumbotronData['show']) == true ? 'checked' : '') ?>>
						<label class="custom-control-label" for="jumbotronShow">Wyświetlenie telebimu na stronie</label>
					</div>
					<div class="form-group">
						<label>Nagłówek</label>
						<input type="text" class="form-control" name="header" placeholder="Nagłówek" value="<?php echo $jumbotronData['header']; ?>">
					</div>
					<div class="form-group">
						<label>Treść</label>
						<textarea name="text" class="form-control" placeholder="Treść"><?php echo $jumbotronData['text']; ?></textarea>
					</div>
					<div class="form-group">
						<label>Link do którego prowadzi telebim</label>
						<?php
						echo core::$model['link']->bootstrapLinkGenerator(!isset($jumbotronData['url']) ? '' : $jumbotronData['url'], ['module', 'post', 'link'], 'url', 'post')
						?>
					</div>
					<button class="btn btn-primary" name="jumbotronSave">Zapisz</button>
				</form>
			</div>
		</div>
	</div>
</div>