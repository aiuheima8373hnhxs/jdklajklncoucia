<div class='content pt-3'>
    <div class="container-fluid">
		<div class='card'>
			<div class='card-header'>
				<div class="card-title">Posty</div>
				<div class="card-tools">
					<a href="postAdd.html"><button type="button" class="btn btn-tool" data-toggle="tooltip" data-placement="left" title="Dodaj posta"><i class="fas fa-plus"></i></button></a>
				</div>
			</div>
			<div class="card-body p-0 table-responsive">
				<table class="dataTable table table-hover table-sm text-nowrap">
					<thead>
						<tr>
							<th style="min-width: 300px;">Tytuł</th>
							<th style="width: 300px">Data utworzenia</th>
							<th style="width: 200px">Utworzone przez</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach(core::$model['post']->list() as $item) {
							if (strlen($item['title']) < 1)
								$item['title'] = '- Brak tytułu -';
							echo '<tr>
								<td>
									<a href="postEdit-' . $item['id'] . '.html">' . $item['title'] . '</a>
									' . (boolval($item['hidden']) ? '<i class="far fa-eye-slash" data-toggle="tooltip" data-original-title="Post posiada status ukryty"></i>' : '') . ' 
									' . ($item['type'] <> 'post' ? '<i class="fas fa-cubes" data-toggle="tooltip" data-original-title="Post posiada inny typ"></i>' : '') . '
								</td>
								<td>
									' . $item['date'] . '
								</td>
								<td>
									<a href="user-' . $item['user'] . '.html">' . core::$module['account']->getData($item['user'])['name'] . '</a>
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