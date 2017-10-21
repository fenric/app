<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="button" class="btn btn-sm btn-success" onclick="$desktop.component('users').add()">
					<i class="fa fa-plus" aria-hidden="true"></i> Добавить
				</button>
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('users').list()">
					<i class="fa fa-refresh" aria-hidden="true"></i> Обновить
				</button>
			</div>
			<div class="btn-group pull-right">
				<input class="form-control input-sm modal-live-search" type="text" size="25" maxlength="255" value="{{params.items.q}}" placeholder="Live Search" />
			</div>
		</div>
	</nav>

	{{when items.items is not empty}}
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<td width="10%" style="width:10%;" align="center">
						<span class="text-muted">Фото</span>
					</td>
					<td width="16%" style="width:16%;">
						<span class="text-muted">Системное</span>
					</td>
					<td width="16%" style="width:16%;">
						<span class="text-muted">Персональное</span>
					</td>
					<td width="16%" style="width:16%;">
						<span class="text-muted">Активность</span>
					</td>
					<td width="16%" style="width:16%;">
						<span class="text-muted">IP контроль</span>
					</td>
					<td width="16%" style="width:16%;">
						<span class="text-muted">Блокировка</span>
					</td>
					<td width="10%" style="width:10%;" align="center">
						<span class="text-muted">Управление</span>
					</td>
				</tr>
			</thead>
			<tbody>
				{{repeat items.items}}
					<tr data-id="{{id}}">
						<td>
							{{when photo is empty}}
								<p class="text-center">
									<img class="img-circle img-thumbnail" src="{{desktop.components.users.root}}/res/face@128.png" />
								</p>
							{{endwhen photo}}

							{{when photo is not empty}}
								<p class="text-center">
									<img class="img-circle img-thumbnail" src="/upload/128x128/{{photo}}" />
								</p>
							{{endwhen photo}}

							{{when id is equal | this.__parent__.desktop.components.admin.account.id}}
								<p class="text-center">
									<span class="label label-primary">Это вы</span>
								</p>
							{{endwhen id}}

							{{when id is not equal | this.__parent__.desktop.components.admin.account.id}}
								{{when online is true}}
									<p class="text-center">
										<span class="label label-success">В сети</span>
									</p>
								{{endwhen online}}

								{{when blocked is true}}
									<p class="text-center">
										<span class="label label-danger">В бане</span>
									</p>
								{{endwhen blocked}}
							{{endwhen id}}
						</td>
						<td>
							<p><strong>ID</strong>
							<br><span>{{id}}</span></p>

							{{when role is equal | administrator}}
								<p><strong>Роль</strong>
								<br><span>Администратор</span></p>
							{{endwhen role}}

							{{when role is equal | redactor}}
								<p><strong>Роль</strong>
								<br><span>Редактор</span></p>
							{{endwhen role}}

							{{when role is equal | moderator}}
								<p><strong>Роль</strong>
								<br><span>Модератор</span></p>
							{{endwhen role}}

							{{when role is equal | user}}
								<p><strong>Роль</strong>
								<br><span>Пользователь</span></p>
							{{endwhen role}}

							<p><strong>Электронный адрес</strong>
							<br><span>{{email}}</span></p>

							<p><strong>Логин</strong>
							<br><span>{{username}}</span></p>
						</td>
						<td>
							{{when firstname is not empty}}
								<p><strong>Имя</strong>
								<br><span>{{firstname}}</span></p>
							{{endwhen firstname}}

							{{when lastname is not empty}}
								<p><strong>Фамилия</strong>
								<br><span>{{lastname}}</span></p>
							{{endwhen lastname}}

							{{when gender is equal | male}}
								<p><strong>Пол</strong>
								<br><span>Мужчина</span></p>
							{{endwhen gender}}

							{{when gender is equal | female}}
								<p><strong>Пол</strong>
								<br><span>Женщина</span></p>
							{{endwhen gender}}

							{{when birthday is not empty}}
								<p><strong>День рождения</strong>
								<br><span>{{birthday:datetime(d.m.Y)}}</span></p>
							{{endwhen birthday}}

							{{when age is not empty}}
								<p><strong>Возраст</strong>
								<br><span>{{age}}</span></p>
							{{endwhen age}}
						</td>
						<td>
							{{when registration_at is not empty}}
								<p><strong>Регистрация</strong>
								<br><span>{{registration_at:datetime(d.m.Y H:i:s P)}}</span></p>
							{{endwhen registration_at}}

							{{when registration_confirmed_at is not empty}}
								<p><strong>Подтверждение регистрации</strong>
								<br><span>{{registration_confirmed_at:datetime(d.m.Y H:i:s P)}}</span></p>
							{{endwhen registration_confirmed_at}}

							{{when authentication_at is not empty}}
								<p><strong>Последняя аутентификация</strong>
								<br><span>{{authentication_at:datetime(d.m.Y H:i:s P)}}</span></p>
							{{endwhen authentication_at}}

							{{when track_at is not empty}}
								<p><strong>Последняя активность</strong>
								<br><span>{{track_at:datetime(d.m.Y H:i:s P)}}</span>
								<br><small>{{track_url}}</small></p>
							{{endwhen track_at}}
						</td>
						<td>
							{{when registration_ip is not empty}}
								<p><strong>Регистрация</strong>
								<br><a href="javascript:void(0)">{{registration_ip}}</a></p>
							{{endwhen registration_ip}}

							{{when registration_confirmed_ip is not empty}}
								<p><strong>Подтверждение регистрации</strong>
								<br><a href="javascript:void(0)">{{registration_confirmed_ip}}</a></p>
							{{endwhen registration_confirmed_ip}}

							{{when authentication_ip is not empty}}
								<p><strong>Последняя аутентификация</strong>
								<br><a href="javascript:void(0)">{{authentication_ip}}</a></p>
							{{endwhen authentication_ip}}

							{{when track_ip is not empty}}
								<p><strong>Последняя активность</strong>
								<br><a href="javascript:void(0)">{{track_ip}}</a></p>
							{{endwhen track_ip}}
						</td>
						<td>
							{{when blocked is true}}
								{{when ban_from is not empty}}
									<p><strong>Начало блокировки</strong>
									<br><span>{{ban_from:datetime(d.m.Y H:i:s P)}}</span></p>
								{{endwhen ban_from}}

								{{when ban_until is not empty}}
									<p><strong>Окончание блокировки</strong>
									<br><span>{{ban_until:datetime(d.m.Y H:i:s P)}}</span></p>
								{{endwhen ban_until}}

								{{when ban_reason is not empty}}
									<p><strong>Причина блокировки</strong>
									<br><span>{{ban_reason}}</span></p>
								{{endwhen ban_reason}}
							{{endwhen blocked}}

							{{when blocked is not true}}
								<p><span class="text-muted">Учетная запись не&nbsp;заблокирована.</span></p>
							{{endwhen blocked}}
						</td>
						<td>
							<div class="btn-group-vertical btn-block">
								<a class="btn btn-block btn-sm btn-default" href="{{uri}}" target="_blank">
									<small>На сайте</small>
								</a>

								<button class="btn btn-block btn-sm btn-warning" type="button" onclick="$desktop.component('users').edit({{id}})">
									<small>Редактировать</small>
								</button>

								{{when id is not equal | this.__parent__.desktop.components.admin.account.id}}
									<button class="btn btn-block btn-sm btn-danger delete" type="button" data-id="{{id}}" data-toggle="confirmation" data-placement="left" data-title="Уверены?" data-btn-ok-label="Да" data-btn-cancel-label="Отмена">
										<small>Удалить</small>
									</button>
								{{endwhen id}}
							</div>
						</td>
					</tr>
				{{endrepeat items.items}}
			</tbody>
		</table>
	{{endwhen items.items}}
</form>

{{when items.pagination.have is true}}
	<ul class="pagination">
		{{when items.pagination.links.current is greater than | this.items.pagination.links.first}}
			<li>
				<a href="javascript:$desktop.component('users').list({page: {{items.pagination.links.first}}})">
					<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('users').list({page: {{items.pagination.links.previous}}})">
					<i class="fa fa-angle-left" aria-hidden="true"></i>
				</a>
			</li>
		{{endwhen items.pagination.links.current}}

		{{list pages start=items.pagination.links.start end=items.pagination.links.end as=page}}
			{{when page is equal | this.__parent__.items.pagination.links.current}}
				<li class="disabled">
					<span>{{page}}</span>
				</li>
			{{endwhen page}}

			{{when page is not equal | this.__parent__.items.pagination.links.current}}
				<li>
					<a href="javascript:$desktop.component('users').list({page: {{page}}})">
						<span>{{page}}</span>
					</a>
				</li>
			{{endwhen page}}
		{{endlist pages}}

		{{when items.pagination.links.current is less than | this.items.pagination.links.last}}
			<li>
				<a href="javascript:$desktop.component('users').list({page: {{items.pagination.links.next}}})">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('users').list({page: {{items.pagination.links.last}}})">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
				</a>
			</li>
		{{endwhen items.pagination.links.current}}
	</ul>
{{endwhen items.pagination.have}}
