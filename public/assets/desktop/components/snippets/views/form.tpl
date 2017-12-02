<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="submit" class="btn btn-sm btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
				</button>
			</div>
			<div class="btn-group pull-right">
				{{when id is not empty}}
					<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('snippets').demo({{id}})">
						<i class="fa fa-television" aria-hidden="true"></i> Демо
					</button>
				{{endwhen id}}

				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('snippets').help()">
					<i class="fa fa-life-ring" aria-hidden="true"></i> Помощь
				</button>
			</div>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="title">
		<label>Название сниппета</label>
		<input class="form-control" type="text" name="title" value="{{title}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="code">
		<label>Символьный код сниппета</label>
		<input class="form-control" type="text" name="code" value="{{code}}" />
		<p class="help-block">Оставьте это поле пустым, чтобы система сгенерировала символьный код автоматически...</p>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="value">
		<label>Значение сниппета</label>
		<textarea class="form-control codemirror" name="value" rows="10">{{value}}</textarea>
		<div class="help-block error"></div>
	</div>
</form>
