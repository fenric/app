<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="button" class="btn btn-sm btn-success" onclick="$desktop.component('snippets').add()">
					<i class="fa fa-plus" aria-hidden="true"></i> Добавить
				</button>
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('snippets').list()">
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
					<td width="35%">
						<span class="text-muted">Основное</span>
					</td>
					<td width="35%">
						<span class="text-muted">Интегрирование</span>
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
						</td>
						<td>
							<p><strong>Код для вставки в контент</strong>
							<br><span>{#snippet:{{code}}#}</span></p>

							<p><strong>PHP код для вставки в шаблон</strong>
							<br><span>&lt;?= fenric('snippet::{{code}}') ?&gt;</span></p>
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
								<button class="btn btn-block btn-sm btn-default" type="button" onclick="$desktop.component('snippets').demo({{id}})">
									<small>Демонстрация</small>
								</button>
								<button class="btn btn-block btn-sm btn-warning" type="button" onclick="$desktop.component('snippets').edit({{id}})">
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
				<a href="javascript:$desktop.component('snippets').list({page: {{items.pagination.links.first}}})">
					<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('snippets').list({page: {{items.pagination.links.previous}}})">
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
					<a href="javascript:$desktop.component('snippets').list({page: {{page}}})">
						<span>{{page}}</span>
					</a>
				</li>
			{{endwhen page}}
		{{endlist pages}}

		{{when items.pagination.links.current is less than | this.items.pagination.links.last}}
			<li>
				<a href="javascript:$desktop.component('snippets').list({page: {{items.pagination.links.next}}})">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('snippets').list({page: {{items.pagination.links.last}}})">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
				</a>
			</li>
		{{endwhen items.pagination.links.current}}
	</ul>
{{endwhen items.pagination.have}}
