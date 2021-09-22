<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<h1>Użytkownik</h1>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						{block name=profileBox}
							<!-- avatar -->
							<div class="text-center">
								{block name=avatar}
									<img class="img-fluid img-circle" src="{$userData_avatar}" alt="Avatar użytkownika">
								{/block}
							</div>
							<!-- name -->
							<h3 class="profile-username text-center">
								{($userData_data['blocked'])?'<s>':''}
									{$userData_data['name']}
								{($userData_data['blocked'])?'</s>':''}
							</h3>
							<p class="text-center">
								{if $userData_userAcc}
									<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangeName" href="#collapseChangeName">
										Zmień nazwę użytkownika
									</a>
									<div class="collapse mt-1" id="collapseChangeName">
										<div class="card card-body">
											<form method="POST">
												<div class="form-group">
													<label>Nowa nazwa</label>
													<input type="text" name="name" class="form-control" placeholder="Nazwa" value="{$userData_data['name']}">
												</div>
												<button type="submit" name="save_name" class="btn btn-primary btn-block">Zmień nazwę</button>
											</form>
										</div>
									</div>
								{/if}
							</p>
							<!-- login -->
							<p class="text-muted text-center">
								{($userData_data['blocked'])?'<s>':''}
									{$userData_data['login']}
								{($userData_data['blocked'])?'</s>':''}
							</p>
							<ul class="list-group list-group-unbordered mb-3">
								<!-- permission -->
								<li class="list-group-item">
									<b>Uprawnienia
										{if $userPermission['permissionUserEdit']}
											<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangePermission" href="#collapseChangePermission">Zmień</a>
										{/if}
									</b>
									<a class="float-right">
										{core::$module['account']->getPermissionName((int)$userData_data['permission'])}
									</a>
									<div class="clearfix"></div>
									{if $userPermission['permissionUserEdit']}
										<div class="collapse mt-2" id="collapseChangePermission">
											<div class="card card-body">
												<form method="POST">
													<div class="form-group">
														<label>Zmiana uprawnień użytkownika</label>
														<select name="permission" class="custom-select">
															{foreach from=core::$module['account']->getPermissionList() item=item}
																<option value="{$item['id']}" {((int)$userData_data['permission']==(int)$item['id'])?'selected':''}>{$item['name']}</option>
															{/foreach}
														</select>
													</div>
													<button type="submit" name="save_permission"
														class="btn btn-primary btn-block">Zmień uprawnienia</button>
												</form>
											</div>
										</div>
									{/if}
								</li>
								<!-- email -->
								<li class="list-group-item">
									<b>Adres E-Mail
										{if $userData_userAcc}
											<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangeEmail" href="#collapseChangeEmail">Zmień</a>
										{/if}
									</b> <a class="float-right" href="mailto:{$userData_data['email']}">
										{$userData_data['email']}
									</a>
									<div class="clearfix"></div>
									{if $userData_userAcc}
										<div class="collapse mt-2" id="collapseChangeEmail">
											<div class="card card-body">
												<form method="POST">
													<div class="form-group">
														<label>Nowy adres E-Mail</label>
														<input type="text" name="email" class="form-control" placeholder="Nazwa" value="{$userData_data['email']}">
													</div>
													<button type="submit" name="save_email" class="btn btn-primary btn-block">Zmień nazwę</button>
												</form>
											</div>
										</div>
									{/if}
								</li>
								<!-- posts -->
								<li class="list-group-item"><b>Postów</b> <a class="float-right">?</a></li>
							</ul>
						{/block}
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							{block name=userMenu}
								<li class="nav-item"><a class="nav-link active" href="#posts" data-toggle="tab" style="">Posty</a></li>
								{if $userData_userAcc}
									<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab" style="">Ustawienia</a></li>
								{/if}
							{/block}
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">
							{block name=userTab}
								<!-- posts -->
								<div class="tab-pane active" id="posts">
									<div class="alert alert-warning">Opcja będzie udostępniona w późniejszych wersjach</div>
								</div>
								<!-- setting -->
								{if $userData_userAcc}
									<div class="tab-pane" id="settings">
										<a href="userChangePassword.html" class="btn btn-secondary"><i class="nav-icon fas fa-key"></i> Zmiana hasła</a>
									</div>
								{/if}
							{/block}
						</div>
					</div>
				</div>
			</div>
		</div>
</section>