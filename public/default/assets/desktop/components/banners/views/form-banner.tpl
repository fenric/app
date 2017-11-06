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

	<div class="form-group" data-name="banner_group_id">
		<label>Группа баннера</label>
		<select class="form-control select-picker" name="banner_group_id">
			<option value=""></option>
			{{repeat groups}}
				<option value="{{id}}" {{when id is equal | this.__parent__.banner_group_id}}selected{{endwhen id}}>{{title}}</option>
			{{endrepeat groups}}
		</select>
		<div class="help-block error"></div>
	</div>
	<!-- <div class="form-group" data-name="banner_client_id">
		<label>Клиент баннера</label>
		<select class="form-control select-picker" name="banner_client_id">
			<option value=""></option>
			{{repeat clients}}
				<option value="{{id}}" {{when id is equal | this.__parent__.banner_client_id}}selected{{endwhen id}}>{{title}}</option>
			{{endrepeat clients}}
		</select>
		<div class="help-block error"></div>
	</div> -->
	<hr>

	<div class="form-group" data-name="title">
		<label>Название баннера</label>
		<input class="form-control" type="text" name="title" value="{{title}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="description">
		<label>Описание баннера</label>
		<textarea class="form-control" name="description" rows="3">{{description}}</textarea>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="picture">
		<label>Изображение баннера</label>
		<div class="picture-container">
			{{when picture is not empty}}
				<img
					class="img-thumbnail form-element"
					style="margin-bottom: 10px;"
					src="/upload/{{picture}}"
					data-name="picture"
					data-value="{{picture}}"
				/>
			{{endwhen picture}}
		</div>
		<div class="btn-group">
			<label class="btn btn-sm btn-default" title="Загрузить изображение">
				<i class="fa fa-upload" aria-hidden="true"></i>
				<input class="picture-upload hidden" type="file" />
			</label>
			<button type="button" class="btn btn-sm btn-default picture-edit" title="Редактировать изображение">
				<i class="fa fa-magic" aria-hidden="true"></i>
			</button>
			<button type="button" class="btn btn-sm btn-danger picture-delete" title="Удалить изображение">
				<i class="fa fa-trash-o" aria-hidden="true"></i>
			</button>
		</div>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="picture_alt">
		<label>Альтернативный текст изображения баннера</label>
		<input class="form-control" type="text" name="picture_alt" value="{{picture_alt}}" />
		<div class="help-block">Содержимое будет отражено в атрибуте <b>alt</b> тега <b>&lt;img&gt;</b>.</div>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="picture_title">
		<label>Описание изображения баннера</label>
		<input class="form-control" type="text" name="picture_title" value="{{picture_title}}" />
		<div class="help-block">Содержимое будет отражено в атрибуте <b>title</b> тега <b>&lt;img&gt;</b>.</div>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="hyperlink_url">
		<label>Адрес гиперссылки баннера</label>
		<input class="form-control" type="text" name="hyperlink_url" value="{{hyperlink_url}}" placeholder="https://www.example.com/" />
		<div class="help-block">Содержимое будет отражено в атрибуте <b>href</b> тега <b>&lt;a&gt;</b>.</div>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="hyperlink_title">
		<label>Описание гиперссылки баннера</label>
		<input class="form-control" type="text" name="hyperlink_title" value="{{hyperlink_title}}" />
		<div class="help-block">Содержимое будет отражено в атрибуте <b>title</b> тега <b>&lt;a&gt;</b>.</div>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="hyperlink_target">
		<label>
			<input type="checkbox" name="hyperlink_target" value="_blank" data-unchecked-value="_self" {{when hyperlink_target is equal | _blank}}checked{{endwhen hyperlink_target}} /> Открывать гиперссылку в новом окне
		</label>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="show_start">
		<label>Дата начала показа баннера</label>
		<input class="form-control date-time-picker" type="text" name="show_start" value="{{show_start|now:datetime(Y-m-d H:i)}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="show_end">
		<label>Дата окончания показа баннера</label>
		<input class="form-control date-time-picker" type="text" name="show_end" value="{{show_end:datetime(Y-m-d H:i)}}" />
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="shows_limit">
		<label>Максимальное количество показов</label>
		<input class="form-control" type="number" name="shows_limit" value="{{shows_limit}}" />
		<div class="help-block">При достижении лимита баннер перестанет показываться.</div>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="clicks_limit">
		<label>Максимальное количество переходов</label>
		<input class="form-control" type="number" name="clicks_limit" value="{{clicks_limit}}" />
		<div class="help-block">При достижении лимита баннер перестанет показываться.</div>
		<div class="help-block error"></div>
	</div>
</form>
