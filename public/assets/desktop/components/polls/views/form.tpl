<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="submit" class="btn btn-sm btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
				</button>
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('polls').help()">
					<i class="fa fa-life-ring" aria-hidden="true"></i> Помощь
				</button>
			</div>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="title">
		<label>Название опроса</label>
		<input class="form-control" type="text" name="title" value="{{title}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="code">
		<label>Символьный код опроса</label>
		<input class="form-control" type="text" name="code" value="{{code}}" />
		<p class="help-block">Оставьте это поле пустым, чтобы система сгенерировала символьный код автоматически...</p>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="multiple">
		<label>
			<input type="checkbox" name="multiple" value="1" data-unchecked-value="0" {{when multiple is true}}checked{{endwhen multiple}} /> Разрешить выбор нескольких вариантов
		</label>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="open_at">
		<label>Дата открытия опроса</label>
		<input class="form-control date-time-picker" type="text" name="open_at" value="{{open_at|now:datetime(Y-m-d H:i)}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="close_at">
		<label>Дата закрытия опроса</label>
		<input class="form-control date-time-picker" type="text" name="close_at" value="{{close_at:datetime(Y-m-d H:i)}}" />
		<div class="help-block error"></div>
	</div>

	{{when id is empty}}
	<hr>
	<div class="form-group" data-name="variants">
		<label>Варианты ответов опроса</label>
		<textarea class="form-control" name="variants" rows="6"></textarea>
		<p class="help-block">Каждый новый вариант ответа с новой строки.</p>
		<div class="help-block error"></div>
	</div>
	{{endwhen id}}
</form>
