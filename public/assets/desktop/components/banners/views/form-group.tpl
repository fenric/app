<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="submit" class="btn btn-sm btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
				</button>
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-sm btn-default" onclick="$desktop.component('banners').help()">
					<i class="fa fa-life-ring" aria-hidden="true"></i> Помощь
				</button>
			</div>
		</div>
	</nav>
	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="title">
		<label>Название группы баннеров</label>
		<input class="form-control" type="text" name="title" value="{{title}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="code">
		<label>Символьный код группы баннеров</label>
		<input class="form-control" type="text" name="code" value="{{code}}" />
		<p class="help-block">Оставьте это поле пустым, чтобы система сгенерировала символьный код автоматически...</p>
		<div class="help-block error"></div>
	</div>
</form>
