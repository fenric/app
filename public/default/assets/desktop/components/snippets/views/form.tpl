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

	<div class="form-group" data-name="title">
		<label>Название</label>
		<input class="form-control" type="text" name="title" value="{{title}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="code">
		<label>Символьный код</label>
		<input class="form-control" type="text" name="code" value="{{code}}" />
		<p class="help-block">Оставьте это поле пустым, чтобы система сгенерировала символьный код автоматически...</p>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="value">
		<label>Значение</label>
		<textarea class="form-control" name="value" rows="10">{{value}}</textarea>
		<div class="help-block error"></div>
	</div>
</form>
