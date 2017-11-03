<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="button" class="btn btn-sm btn-success" onclick="$desktop.component('polls').add()">
					<i class="fa fa-plus" aria-hidden="true"></i> Добавить
				</button>
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('polls').list()">
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
					<td width="25%">
						<span class="text-muted">Основное</span>
					</td>
					<td width="20%">
						<span class="text-muted">Свойства</span>
					</td>
					<td width="25%">
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

							<p><strong>Количество вариантов ответов</strong>
							<br><span>{{variants|0}}</span></p>

							<p><strong>Общее количество голосов</strong>
							<br><span>{{votes|0}}</span></p>
						</td>
						<td>
							{{when open_at is not empty}}
								<p><strong>Открытие</strong>
								<br><span>{{open_at:datetime(d.m.Y H:i P)}}</span></p>
							{{endwhen open_at}}

							{{when close_at is not empty}}
								<p><strong>Закрытие</strong>
								<br><span>{{close_at:datetime(d.m.Y H:i P)}}</span></p>
							{{endwhen close_at}}

							{{when opened is true}}
								<span class="label label-success">Открыт</span>
							{{endwhen opened}}

							{{when opened is not true}}
								<span class="label label-danger">Закрыт</span>
							{{endwhen opened}}

							{{when multiple is true}}
								<span class="label label-primary">Мультивыбор</span>
							{{endwhen multiple}}
						</td>
						<td>
							<p><strong>Код для вставки в контент</strong>
							<br><span>{#poll:{{code}}#}</span></p>

							<p><strong>PHP код для вставки в шаблон</strong>
							<br><span>&lt;?= fenric('poll::{{code}}') ?&gt;</span></p>
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
								<button class="btn btn-block btn-sm btn-primary" type="button" onclick="$desktop.component('polls').variants({{id}})">
									<small>Варианты</small>
								</button>
								<button class="btn btn-block btn-sm btn-warning" type="button" onclick="$desktop.component('polls').edit({{id}})">
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
				<a href="javascript:$desktop.component('polls').list({page: {{items.pagination.links.first}}})">
					<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('polls').list({page: {{items.pagination.links.previous}}})">
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
					<a href="javascript:$desktop.component('polls').list({page: {{page}}})">
						<span>{{page}}</span>
					</a>
				</li>
			{{endwhen page}}
		{{endlist pages}}

		{{when items.pagination.links.current is less than | this.items.pagination.links.last}}
			<li>
				<a href="javascript:$desktop.component('polls').list({page: {{items.pagination.links.next}}})">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('polls').list({page: {{items.pagination.links.last}}})">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
				</a>
			</li>
		{{endwhen items.pagination.links.current}}
	</ul>
{{endwhen items.pagination.have}}
