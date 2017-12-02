<div class="desktop-admin-login-overlay">
	<form class="desktop-admin-login-form">
		<div class="desktop-admin-login-form-admin-photo">
			{{when account.photo is empty}}
				<img class="img-circle" src="{{root}}/res/avatar.png" width="128" height="128" />
			{{endwhen account.photo}}

			{{when account.photo is not empty}}
				<img class="img-circle" src="/upload/128x128/{{account.photo}}" width="128" height="128" />
			{{endwhen account.photo}}
		</div>
		<div class="desktop-admin-login-form-admin-fullname">
			<strong>@{{account.username}}</strong>
		</div>
		<div class="form-group">
			<input class="form-control text-center" type="password" name="password" placeholder="********" required autofocus />
			<div class="desktop-admin-login-form-response hidden"></div>
		</div>
		<div class="form-group">
			<div class="btn-group-vertical btn-block">
				<button type="submit" class="btn btn-success btn-block btn-sm text-uppercase desktop-admin-login-form-button">
					<span>Войти</span>
				</button>
				<button type="reset" class="btn btn-danger btn-block btn-sm text-uppercase desktop-admin-login-cancel">
					<span>Отмена</span>
				</button>
			</div>
		</div>
		<div class="desktop-admin-login-form-note">
			<span>Ваша сессия истекла, введите пароль,<br>и нажмите «ВОЙТИ», чтобы продолжить.</span>
		</div>
		<input type="hidden" name="username" value="{{account.username}}" />
	</form>
</div>
