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
	<div class="form-group" data-name="contact_name">
		<label>Имя контактного лица клиента баннера</label>
		<input class="form-control" type="text" name="contact_name" value="{{contact_name}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="contact_email">
		<label>Электронный адрес контактного лица клиента баннера</label>
		<input class="form-control" type="text" name="contact_email" value="{{contact_email}}" />
		<div class="help-block error"></div>
	</div>
	<hr>
	<div class="form-group" data-name="description">
		<label>Дополнительная информацию по клиенту баннера</label>
		<textarea class="form-control" name="description" rows="8">{{description}}</textarea>
		<div class="help-block error"></div>
	</div>
</form>
