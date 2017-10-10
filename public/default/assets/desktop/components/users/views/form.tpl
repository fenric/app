<form class="form">
	<nav class="top">
		<div class="clearfix">
			<div class="btn-group pull-left">
				<button type="submit" class="btn btn-sm btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
				</button>
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-sm btn-info" onclick="$desktop.component('users').help()">
					<i class="fa fa-life-ring" aria-hidden="true"></i> Помощь
				</button>
			</div>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="role">
		<label>Роль учетной записи</label>
		<select class="form-control" name="role">
			<option value=""></option>
			<option value="administrator" {{when role is equal | administrator}}selected{{endwhen role}}>&#x2654; Администратор</option>
			<option value="redactor" {{when role is equal | redactor}}selected{{endwhen role}}>&#x2657; Редактор</option>
			<option value="moderator" {{when role is equal | moderator}}selected{{endwhen role}}>&#x2658; Модератор</option>
			<option value="user" {{when role is equal | user}}selected{{endwhen role}}>&#x2659; Пользователь</option>
		</select>
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="email">
		<label>Электронный адрес учетной записи</label>
		<input class="form-control" type="text" name="email" value="{{email}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="username">
		<label>Имя учетной записи</label>
		<input class="form-control" type="text" name="username" value="{{username}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="password">
		<label>Пароль учетной записи</label>
		<input class="form-control" type="text" name="password" value="" />
		{{when id is not empty}}
			<div class="help-block">Введите новый пароль если хотите изменить его, или оставьте поле пустым, чтобы оставить текущий пароль без изменений.</div>
		{{endwhen id}}
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="photo">
		<label>Фото пользователя</label>
		<input class="form-control photo-upload" type="file" accept="image/*" />
		<div class="photo-container" style="margin: 10px 0;">
			{{when photo is not empty}}
				<img class="img-thumbnail" src="/upload/150x150/{{photo}}" />
				<input type="hidden" name="photo" value="{{photo}}" />
			{{endwhen photo}}
		</div>
		<button type="button" class="btn btn-sm btn-danger photo-reset">
			<i class="fa fa-trash-o" aria-hidden="true"></i> Удалить фото
		</button>
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="firstname">
		<label>Имя пользователя</label>
		<input class="form-control" type="text" name="firstname" value="{{firstname}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="lastname">
		<label>Фамилия пользователя</label>
		<input class="form-control" type="text" name="lastname" value="{{lastname}}" />
		<div class="help-block error"></div>
	</div>
	<hr>

	<div class="form-group" data-name="gender">
		<label>Пол пользователя</label>
		<select class="form-control" name="gender">
			<option value=""></option>
			<option value="male" {{when gender is equal | male}}selected{{endwhen gender}}>&#x2642; Мужчина</option>
			<option value="female" {{when gender is equal | female}}selected{{endwhen gender}}>&#x2640; Женщина</option>
		</select>
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="birthday">
		<label>День рождения пользователя</label>
		<input class="form-control date-picker" type="text" name="birthday" value="{{birthday:datetime(Y-m-d)}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="about">
		<label>Резюме пользователя</label>
		<textarea class="form-control" name="about" rows="6">{{about}}</textarea>
		<div class="help-block error"></div>
	</div>

	<hr>
	<div class="form-group" data-name="ban_from">
		<label>С какого числа начинается блокировка учетной записи</label>
		<input class="form-control date-time-picker" type="text" name="ban_from" value="{{ban_from:datetime(Y-m-d H:i:s)}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="ban_until">
		<label>По какое число продолжается блокировка учетной записи</label>
		<input class="form-control date-time-picker" type="text" name="ban_until" value="{{ban_until:datetime(Y-m-d H:i:s)}}" />
		<div class="help-block error"></div>
	</div>
	<div class="form-group" data-name="ban_reason">
		<label>Причина блокировки учетной записи</label>
		<textarea class="form-control" name="ban_reason" rows="3">{{ban_reason}}</textarea>
		<div class="help-block error"></div>
	</div>
</form>
