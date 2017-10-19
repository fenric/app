<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="button" class="btn btn-sm btn-success" onclick="$desktop.component('publications').add()">
					<i class="fa fa-plus" aria-hidden="true"></i> Добавить
				</button>
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('publications').list()">
					<i class="fa fa-refresh" aria-hidden="true"></i> Обновить
				</button>
			</div>
			<div class="btn-group pull-right">
				<!-- @continue -->
			</div>
		</div>
	</nav>

	{{when items.items is not empty}}
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<td width="10%" align="center">
						<span class="text-muted">Изображение</span>
					</td>
					<td width="20%">
						<span class="text-muted">Основное</span>
					</td>
					<td width="20%">
						<span class="text-muted">Метаданные</span>
					</td>
					<td width="20%">
						<span class="text-muted">Теги</span>
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
					<tr class="{{when disabled is true}}danger{{endwhen disabled}}" data-id="{{id}}">
						<td align="center">
							{{when picture is empty}}
								<p><span class="label label-default">Отсутствует</span></p>
							{{endwhen picture}}

							{{when picture is not empty}}
								<p><img class="img-thumbnail" src="/upload/320x0/{{picture}}" /></p>
							{{endwhen picture}}
						</td>
						<td>
							<p><strong>ID</strong>
							<br><span>{{id}}</span></p>

							<p><strong>Раздел</strong>
							<br><span>{{section.header}}</span></p>

							<p><strong>Заголовок</strong>
							<br><span>{{header}}</span></p>

							<p><strong>Количество фотографий</strong>
							<br><span>{{photos|0}}</span></p>

							<p><strong>Количество хитов</strong>
							<br><span>{{hits|0}}</span></p>
						</td>
						<td>
							{{when meta_title is empty}}
								<p><strong>Заголовок документа</strong>
								<br><span class="text-muted">{{header}}</span></p>
							{{endwhen meta_title}}

							{{when meta_title is not empty}}
								<p><strong>Заголовок документа</strong>
								<br><span>{{meta_title}}</span></p>
							{{endwhen meta_title}}

							{{when meta_author is not empty}}
								<p><strong>Автор документа</strong>
								<br><span>{{meta_author}}</span></p>
							{{endwhen meta_author}}

							{{when meta_keywords is not empty}}
								<p><strong>Ключевые слова документа</strong>
								<br><span>{{meta_keywords}}</span></p>
							{{endwhen meta_keywords}}

							{{when meta_description is not empty}}
								<p><strong>Описание документа</strong>
								<br><span>{{meta_description}}</span></p>
							{{endwhen meta_description}}

							{{when meta_canonical is not empty}}
								<p><strong>Канонический адрес документа</strong>
								<br><span>{{meta_canonical}}</span></p>
							{{endwhen meta_canonical}}

							{{when meta_robots is not empty}}
								<p><strong>Индексация документа</strong>
								<br><span>{{meta_robots}}</span></p>
							{{endwhen meta_robots}}
						</td>
						<td>
							{{when tags is empty}}
								<p><span class="text-muted">Публикация не&nbsp;связана с&nbsp;тегами.</span></p>
							{{endwhen tags}}

							{{when tags is not empty}}
								{{repeat tags}}
									<div class="label label-primary" style="display: inline-block; margin: 0 2px 3px 0;">{{header}}</div>
								{{endrepeat tags}}
							{{endwhen tags}}
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
								<a class="btn btn-block btn-sm btn-default" href="{{uri}}" target="_blank">
									<small>На сайте</small>
								</a>
								<button class="btn btn-block btn-sm btn-primary" type="button" onclick="$desktop.component('publications').photos({{id}})">
									<small>Фотографии</small>
								</button>
								<button class="btn btn-block btn-sm btn-warning" type="button" onclick="$desktop.component('publications').edit({{id}})">
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
				<a href="javascript:$desktop.component('publications').list({page: {{items.pagination.links.first}}})">
					<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('publications').list({page: {{items.pagination.links.previous}}})">
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
					<a href="javascript:$desktop.component('publications').list({page: {{page}}})">
						<span>{{page}}</span>
					</a>
				</li>
			{{endwhen page}}
		{{endlist pages}}

		{{when items.pagination.links.current is less than | this.items.pagination.links.last}}
			<li>
				<a href="javascript:$desktop.component('publications').list({page: {{items.pagination.links.next}}})">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</li>
			<li>
				<a href="javascript:$desktop.component('publications').list({page: {{items.pagination.links.last}}})">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
				</a>
			</li>
		{{endwhen items.pagination.links.current}}
	</ul>
{{endwhen items.pagination.have}}
