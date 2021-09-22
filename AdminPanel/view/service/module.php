<div class="content pt-3">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Moduły</h3>
			</div>
			<div class="card-body table-responsive p-0" style="overflow: auto">
				<table class="table table-sm text-nowrap">
					<thead>
						<tr>
							<th style="width: 50px">Opcje</th>
							<th>Nazwa</th>
							<th style="width: 300px">UniqueID</th>
							<th style="width: 40px">Wersja</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$scandir = scandir('../module/');
						$scandir = array_diff($scandir, ['.', '..', '.htaccess']);
						foreach ($scandir as $fname) {
							$config = include('../module/' . $fname . '/config.php');
							echo '<tr>
								<td>
								' . (isset($config['adminPanel']) ? '<a href="FrameworkModuleAP-' . $fname . '.html"><i class="fas fa-window-maximize" data-toggle="tooltip" data-placement="left" title="Panel administracyjny"></i></a>' : '') . '
								</td>
								<td><a href="FrameworkModuleInfo-' . $fname . '.html">' . $fname . '</a></td>
								<td>' . (isset($config['uniqueID']) ? $config['uniqueID'] : '') . '</td>
								<td>' . (isset($config['version']) ? $config['version'] : '') . '</td>
							</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>