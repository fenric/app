<form class="form">
	<nav class="top">
		<div class="btn-group">
			<button type="submit" class="btn btn-sm btn-success">
				<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
			</button>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="section_id">
		<label>Раздел публикации</label>
		<select class="form-control select-picker" name="section_id">
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
		<input class="form-control picture-upload" type="file" accept="image/*" />
		<div class="picture-container" style="margin: 10px 0;">
			{{when picture is not empty}}
				<img class="img-thumbnail" src="/upload/150x150/{{picture}}" />
				<input type="hidden" name="picture" value="{{picture}}" />
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
	<hr>

	<div class="form-group" data-name="tags">
		<label>Теги публикации</label>

		{{when tags is empty}}
			<div class="alert alert-info">
				<span>Обратите внимание, в системе не создано ни одного тега.</span>
			</div>
		{{endwhen tags}}

		{{when tags is not empty}}
			<div>
				{{repeat tags}}
					{{when id in array | this.__parent__.publication_tags}}
						<label class="btn btn-sm btn-default">
							<input type="checkbox" name="tags[]" value="{{id}}" checked /> {{header}}
						</label>
					{{endwhen id}}

					{{when id not in array | this.__parent__.publication_tags}}
						<label class="btn btn-sm btn-default">
							<input type="checkbox" name="tags[]" value="{{id}}" /> {{header}}
						</label>
					{{endwhen id}}
				{{endrepeat tags}}
			</div>
		{{endwhen tags}}

		<div class="help-block error"></div>
	</div>
</form>
