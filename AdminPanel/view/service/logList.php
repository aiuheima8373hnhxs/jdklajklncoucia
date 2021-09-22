<div class="content pt-3">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Lista logów</h3>
			</div>
			<div class="card-body p-0 table-responsive">
				<table class="table table-sm text-nowrap">
					<thead>
						<tr>
							<th>Nazwa</th>
							<th style="width: 180px">Ostatni zapis</th>
							<th style="width: 40px">Rozmiar</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$scandir = scandir(core::$path['log']);
						foreach($scandir as $fname){
							if(core::$library->string->strpos($fname, '.log') == -1)
								continue;
							$path = core::$path['log'].$fname;
							$fname = str_replace('.log', '', $fname);
							echo '<tr>
								<td>
									<a href="logFile-'.$fname.'.html">'.$fname.'</a> 
									<a href="logDelete-'.$fname.'.html" class="text-danger" onclick="return confirm(\'Czy na pewno chcesz usunąć ten plik?\nTego nie da się cofnąć.\');"><i class="fas fa-trash"></i></a>
								</td>
								<td>
									'.date("Y-m-d H:i:s", filemtime($path)).'
								</td>
								<td>
									'.core::$library->memory->formatBytes(filesize($path)).'
								</td>
							</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>