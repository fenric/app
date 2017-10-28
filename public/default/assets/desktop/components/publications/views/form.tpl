<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="submit" class="btn btn-sm btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
				</button>
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('publications').help()">
					<i class="fa fa-life-ring" aria-hidden="true"></i> Помощь
				</button>
			</div>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<ul class="nav nav-tabs" style="margin-bottom: 20px;">
		<li role="presentation" class="active">
			<a href="#a4316672-64bf-40b3-8a08-6748e3363979-{{id|0}}" aria-controls="a4316672-64bf-40b3-8a08-6748e3363979-{{id|0}}" role="tab" data-toggle="tab">
				<i class="fa fa-bars" aria-hidden="true"></i> Основные свойства
			</a>
		</li>
		<li role="presentation">
			<a href="#b74f1a0e-2042-478f-abc3-7a3e8a4411c9-{{id|0}}" aria-controls="b74f1a0e-2042-478f-abc3-7a3e8a4411c9-{{id|0}}" role="tab" data-toggle="tab">
				<i class="fa fa-filter" aria-hidden="true"></i> Дополнительные свойства
			</a>
		</li>
		<li role="presentation">
			<a href="#ccb02f07-8809-45df-8c35-eda0c0934070-{{id|0}}" aria-controls="ccb02f07-8809-45df-8c35-eda0c0934070-{{id|0}}" role="tab" data-toggle="tab">
				<i class="fa fa-globe" aria-hidden="true"></i> Метаданные
			</a>
		</li>
		<li role="presentation">
			<a href="#d757d733-cc6a-48e2-bfd6-4a466df5568d-{{id|0}}" aria-controls="d757d733-cc6a-48e2-bfd6-4a466df5568d-{{id|0}}" role="tab" data-toggle="tab">
				<i class="fa fa-link" aria-hidden="true"></i> Связи
			</a>
		</li>
		<li role="presentation">
			<a href="#ea19808d-079f-4230-9da5-a4ae932158bb-{{id|0}}" aria-controls="ea19808d-079f-4230-9da5-a4ae932158bb-{{id|0}}" role="tab" data-toggle="tab">
				<i class="fa fa-tags" aria-hidden="true"></i> Теги
			</a>
		</li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="a4316672-64bf-40b3-8a08-6748e3363979-{{id|0}}">
			<div class="form-group" data-name="section_id">
				<label>Раздел публикации</label>
				<select class="form-control select-picker fetch-fields" name="section_id">
					<option value=""></option>
					{{repeat sections}}
						<option value="{{id}}" {{when id is equal | this.__parent__.section_id}}selected{{endwhen id}}>{{header}}</option>
					{{endrepeat sections}}
				</select>
				<div class="help-block error"></div>
			</div>
			<hr>

			<div class="form-group" data-name="header">
				<label>Заголовок публикации</label>
				<input class="form-control" type="text" name="header" value="{{header}}" />
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="code">
				<label>Символьный код публикации</label>
				<input class="form-control" type="text" name="code" value="{{code}}" />
				<p class="help-block">Оставьте это поле пустым, чтобы система сгенерировала символьный код автоматически...</p>
				<div class="help-block error"></div>
			</div>
			<hr>

			<div class="form-group" data-name="picture">
				<label>Изображение публикации</label>
				<input class="form-control picture-upload" type="file" />
				<div class="picture-container" style="margin: 10px 0;">
					{{when picture is not empty}}
						<img class="img-thumbnail" src="/upload/150x0/{{picture}}" />
						<input type="hidden" name="picture" value="{{picture}}" />
						<input type="hidden" name="picture_source" value="{{picture_source}}" />
					{{endwhen picture}}
				</div>
				<button type="button" class="btn btn-sm btn-danger picture-reset">
					<i class="fa fa-trash-o" aria-hidden="true"></i> Удалить изображение
				</button>
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="picture_signature">
				<label>Подпись к изображению публикации</label>
				<input class="form-control" type="text" name="picture_signature" value="{{picture_signature}}" />
				<div class="help-block error"></div>
			</div>
			<hr>

			<div class="form-group" data-name="anons">
				<label>Анонс публикации</label>
				<textarea class="form-control ckeditor" name="anons" rows="5">{{anons}}</textarea>
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="content">
				<label>Содержимое публикации</label>
				<textarea class="form-control ckeditor" name="content" rows="5">{{content}}</textarea>
				<div class="help-block error"></div>
			</div>
			<hr>

			<div class="form-group" data-name="show_at">
				<label>Дата активации публикации</label>
				<input class="form-control date-time-picker" type="text" name="show_at" value="{{show_at|now:datetime(Y-m-d H:i)}}" />
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="hide_at">
				<label>Дата деактивации публикации</label>
				<input class="form-control date-time-picker" type="text" name="hide_at" value="{{hide_at:datetime(Y-m-d H:i)}}" />
				<div class="help-block error"></div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="b74f1a0e-2042-478f-abc3-7a3e8a4411c9-{{id|0}}">
			<div class="fields-container"></div>
		</div>
		<div role="tabpanel" class="tab-pane" id="ccb02f07-8809-45df-8c35-eda0c0934070-{{id|0}}">
			<div class="form-group" data-name="meta_title">
				<label>Заголовок документа</label>
				<input class="form-control" type="text" name="meta_title" value="{{meta_title}}" />
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="meta_author">
				<label>Автор документа</label>
				<input class="form-control" type="text" name="meta_author" value="{{meta_author}}" />
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="meta_keywords">
				<label>Ключевые слова документа</label>
				<input class="form-control" type="text" name="meta_keywords" value="{{meta_keywords}}" />
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="meta_description">
				<label>Описание документа</label>
				<input class="form-control" type="text" name="meta_description" value="{{meta_description}}" />
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="meta_canonical">
				<label>Канонический адрес документа</label>
				<input class="form-control" type="text" name="meta_canonical" value="{{meta_canonical}}" />
				<div class="help-block error"></div>
			</div>
			<div class="form-group" data-name="meta_robots">
				<label>Индексация документа</label>
				<select class="form-control" name="meta_robots">
					<option value="">По умолчанию</option>
					<option value="index, follow" {{when meta_robots is equal | index, follow}}selected{{endwhen meta_robots}}>Индексировать документ</option>
					<option value="index, nofollow" {{when meta_robots is equal | index, nofollow}}selected{{endwhen meta_robots}}>Индексировать только текст в документе</option>
					<option value="noindex, follow" {{when meta_robots is equal | noindex, follow}}selected{{endwhen meta_robots}}>Индексировать только ссылки в документе</option>
					<option value="noindex, nofollow" {{when meta_robots is equal | noindex, nofollow}}selected{{endwhen meta_robots}}>Не индексировать документ</option>
				</select>
				<div class="help-block error"></div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="d757d733-cc6a-48e2-bfd6-4a466df5568d-{{id|0}}">
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-search" aria-hidden="true"></i>
				</div>
				<input class="form-control search-relations" type="text" />
			</div>
			<div class="relations list-group" style="margin-top: 20px;">
				{{when relations is not empty}}
					{{repeat relations}}
						<label class="relation list-group-item" style="cursor: pointer;" data-id="{{id}}">
							<div class="row">
								<div class="col-sm-8">
									<input type="checkbox" name="relations[]" value="{{id}}" checked="true" /> &nbsp; <span class="text-muted">{{header}}</span>
								</div>
								<div class="col-sm-4 text-right">
									<span class="label label-primary">
										{{section.header}}
									</span>
								</div>
							</div>
						</label>
					{{endrepeat relations}}
				{{endwhen relations}}
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="ea19808d-079f-4230-9da5-a4ae932158bb-{{id|0}}">
			<div class="form-group" data-name="tags">
				{{when tags is not empty}}
					{{repeat tags}}
						{{when attached is true}}
							<label class="btn btn-sm btn-default" style="display: inline-block; margin: 0 5px 5px 0;">
								<input type="checkbox" name="tags[]" value="{{id}}" checked /> {{header}}
							</label>
						{{endwhen attached}}

						{{when attached is not true}}
							<label class="btn btn-sm btn-default" style="display: inline-block; margin: 0 5px 5px 0;">
								<input type="checkbox" name="tags[]" value="{{id}}" /> {{header}}
							</label>
						{{endwhen attached}}
					{{endrepeat tags}}
				{{endwhen tags}}

				<div class="help-block error"></div>
			</div>
		</div>
	</div>
</form>
