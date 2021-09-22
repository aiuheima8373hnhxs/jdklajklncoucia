<?php
$string = htmlspecialchars($_GET['debug']);
?>
<div class="content-header">
	<div class="container-fluid">
		<h1 class="m-0 text-dark">Analiza logu rdzenia</h1>
	</div>
</div>

<div class='content pt-3'>
	<div class="container-fluid">
		<div class="card" style='overflow: auto;'>
			<?php
			if (is_null(json_decode(base64_decode($string)))) {
				echo "Błąd odczytu danych - dane uszkodzone";
			} else
				core::$library->debug->print_r(json_decode(base64_decode($string), true));
			?>
		</div>
	</div>
</div>