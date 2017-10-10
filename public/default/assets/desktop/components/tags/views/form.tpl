<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="submit" class="btn btn-sm btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
				</button>
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-sm btn-info" onclick="$desktop.component('tags').help()">
					<i class="fa fa-life-ring" aria-hidden="true"></i> Помощь
				</button>
			</div>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="header">
		<label>Заголовок тега</label>
		<input class="form-control" type="text" name="header" value="{{header}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="code">
		<label>Символьный код тега</label>
		<input class="form-control" type="text" name="code" value="{{code}}" />
		<p class="help-block">Оставьте это поле пустым, чтобы система сгенерировала символьный код автоматически...</p>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="content">
		<label>Содержимое тега</label>
		<textarea class="form-control ckeditor" name="content" rows="10">{{content}}</textarea>
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
</form>
