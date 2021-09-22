<?php
$name = htmlspecialchars($_GET['name']);
$path = core::$path['module'] . $name . '/';
if (!file_exists($path . 'config.php'))
	header('location: 404.html');
?>
<div class='content p-3'>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Dane zwrotne <b><?php echo $name ?></b></h3>
			</div>
			<div class="card-body table-responsive">
				<?php core::loadModule($name) ?>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Debug modułu <b><?php echo $name ?></b></h3>
			</div>
			<div class="card-body table-responsive">
				<?php core::$library->debug->print_r(core::$module[$name]) ?>
			</div>
		</div>
	</div>
</div>