<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="button" class="btn btn-sm btn-success" onclick="$desktop.component('banners').add()">
					<i class="fa fa-plus" aria-hidden="true"></i> Добавить
				</button>
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('banners').list()">
					<i class="fa fa-refresh" aria-hidden="true"></i> Обновить
				</button>
			</div>
			<div class="btn-group pull-left" style="margin-left: 10px;">
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('banners.groups').list()">
					<i class="fa fa-folder" aria-hidden="true"></i> Группы
				</button>
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('banners.clients').list()">
					<i class="fa fa-users" aria-hidden="true"></i> Клиенты
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
					<td width="30%">
						<span class="text-muted">Основное</span>
					</td>
					<td width="30%">
						<span class="text-muted">Статистика</span>
					</td>
					<td width="20%">
						<span class="text-muted">История изменений</span>
					</td>
					<td width="10%" align="center">
						<span class="text-muted">Управление</span>
					</td>
				</tr>
			</thead>
			<tbody>
				{{repeat items.items}}
					<tr data-id="{{id}}">
						<td>
							<p><strong>ID</strong>
							<br><span>{{id}}</span></p>

							<p><strong>Название</strong>
							<br><span>{{title}}</span></p>

							<p><strong>Описание</strong>
							<br><span>{{description}}</span></p>

							{{when group is not empty}}
							<p><strong>Группа</strong>
							<br><span>{{group.title}}</span></p>
							{{endwhen group}}

							{{when client is not empty}}
							<p><strong>Клиент</strong>
							<br><span>{{client.contact_name}}</span></p>
							{{endwhen client}}
						</td>
						<td>
							{{when shows_limit is empty}}
							<p><strong>Количество показов</strong>
							<br><span>{{shows|0}}</span></p>
							{{endwhen shows_limit}}

							{{when shows_limit is not empty}}
							<p><strong>Количество показов</strong>
							<br><span>{{shows|0}} / {{shows_limit}}</span></p>
							{{endwhen shows_limit}}

							{{when clicks_limit is empty}}
							<p><strong>Количество переходов</strong>
							<br><span>{{clicks|0}}</span></p>
							{{endwhen clicks_limit}}

							{{when clicks_limit is not empty}}
							<p><strong>Количество переходов</strong>
							<br><span>{{clicks|0}} / {{clicks_limit}}</span></p>
							{{endwhen clicks_limit}}

							{{when actived is true}}
							<p><span class="label label-success">Активен</span></p>
							{{endwhen actived}}

							{{when actived is false}}
							<p><span class="label label-danger">Не активен</span></p>
							{{endwhen actived}}
						</td>
						<td>
							<p><strong>Создано</strong>
							<br><span>{{created_at:datetime(d.m.Y H:i:s P)}}</span>
							<br><a href="javascript:$desktop.component('users').card({{creator.id}})">{{creator.username}}</a></p>

							<p><strong>Последнее изменение</strong>
							<br><span>{{updated_at:datetime(d.m.Y H:i:s P)}}</span>
							<br><a href="javascript:$desktop.component('users').card({{updater.id}})">{{updater.username}}</a></p>
						</td>
						<td>
							<div class="btn-group-vertical btn-block">
								<a class="btn btn-block btn-sm btn-default" href="/upload/{{picture}}" target="_blank">
									<small>Изображение</small>
								</a>
								<button class="btn btn-block btn-sm btn-warning" type="button" onclick="$desktop.component('banners').edit({{id}})">
									<small>Редактировать</small>
								</button>
								<button class="btn btn-block btn-sm btn-danger delete" type="button" data-id="{{id}}" data-toggle="confirmation" data-placement="left" data-title="Уверены?" data-btn-ok-label="Да" data-btn-cancel-label="Отмена">
									<small>Удалить</small>
								</button>
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
				<a href="javascript:$desktop.component('banners').list({page: {{items.pagination.links.first}}})">
					<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('banners').list({page: {{items.pagination.links.previous}}})">
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
					<a href="javascript:$desktop.component('banners').list({page: {{page}}})">
						<span>{{page}}</span>
					</a>
				</li>
			{{endwhen page}}
		{{endlist pages}}

		{{when items.pagination.links.current is less than | this.items.pagination.links.last}}
			<li>
				<a href="javascript:$desktop.component('banners').list({page: {{items.pagination.links.next}}})">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('banners').list({page: {{items.pagination.links.last}}})">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
				</a>
			</li>
		{{endwhen items.pagination.links.current}}
	</ul>
{{endwhen items.pagination.have}}
