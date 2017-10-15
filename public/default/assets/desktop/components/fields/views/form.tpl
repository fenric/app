<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="submit" class="btn btn-sm btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
				</button>
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('fields').help()">
					<i class="fa fa-life-ring" aria-hidden="true"></i> Помощь
				</button>
			</div>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="type">
		<label>Тип поля</label>
		<select class="form-control" name="type">
			<option value=""></option>

			<option value="flag" {{when type is equal | flag}}selected{{endwhen type}}>Флаг</option>
			<option disabled></option>

			<option value="number" {{when type is equal | number}}selected{{endwhen type}}>Число</option>
			<option value="string" {{when type is equal | string}}selected{{endwhen type}}>Строка</option>
			<option disabled></option>

			<option value="text" {{when type is equal | text}}selected{{endwhen type}}>Тест</option>
			<option value="html" {{when type is equal | html}}selected{{endwhen type}}>HTML</option>
			<option disabled></option>

			<option value="year" {{when type is equal | year}}selected{{endwhen type}}>Год</option>
			<option value="date" {{when type is equal | date}}selected{{endwhen type}}>Дата</option>
			<option value="datetime" {{when type is equal | datetime}}selected{{endwhen type}}>Дата и время</option>
			<option value="time" {{when type is equal | time}}selected{{endwhen type}}>Время</option>
			<option disabled></option>

			<option value="ip" {{when type is equal | ip}}selected{{endwhen type}}>IP адрес</option>
			<option value="url" {{when type is equal | url}}selected{{endwhen type}}>URL адрес</option>
			<option value="email" {{when type is equal | email}}selected{{endwhen type}}>Электронный адрес</option>
			<option disabled></option>

			<option value="image" {{when type is equal | image}}selected{{endwhen type}}>Изображение</option>
		</select>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="name">
		<label>Имя поля</label>
		<input class="form-control" type="text" name="name" value="{{name}}" />
		<p class="help-block">Оставьте это поле пустым, чтобы система сгенерировала символьный код автоматически...</p>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="label">
		<label>Заголовок поля</label>
		<input class="form-control" type="text" name="label" value="{{label}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="tooltip">
		<label>Подсказка для поля</label>
		<input class="form-control" type="text" name="tooltip" value="{{tooltip}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="default_value">
		<label>Значение по умолчанию</label>
		<textarea class="form-control" name="default_value" rows="5">{{default_value}}</textarea>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="validation_regex">
		<label>Регулярное выражение для валидации значения поля</label>
		<input class="form-control" type="text" name="validation_regex" value="{{validation_regex}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="error_message">
		<label>Сообщение на случай если значение поля невалидное</label>
		<input class="form-control" type="text" name="error_message" value="{{error_message}}" />
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="is_unique">
		<label>
			<input type="checkbox" name="is_unique" value="1" data-unchecked-value="0" {{when is_unique is true}}checked{{endwhen is_unique}} /> Уникальное значение поля
		</label>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="is_required">
		<label>
			<input type="checkbox" name="is_required" value="1" data-unchecked-value="0" {{when is_required is true}}checked{{endwhen is_required}} /> Обязательное к заполнению поле
		</label>
		<div class="help-block error"></div>
	</div>
</form>
