'use strict';

(function()
{
	var $component;

	/**
	 * Компонент рабочего стола
	 *
	 * @access  public
	 * @return  void
	 */
	$component = function()
	{
		this.account = null;

		this.routes = {};
		this.routes.read = '/admin/api/account/';
		this.routes.signIn = '/user/login/process/';
		this.routes.signOut = '/user/logout/';
	};

	/**
	 * Чтение учетной записи
	 *
	 * @param   callback   complete
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.read = function(complete)
	{
		this.with(function(self)
		{
			self.httpRequest.get(self.routes.read, {repeat: true, success: function(response)
			{
				self.account = response;

				complete.call(this, self);
			}});
		});
	};

	/**
	 * Авторизация учетной записи
	 *
	 * @param   callback   complete
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.login = function(complete)
	{
		this.with(function(self)
		{
			if ($desktop.exists('div.desktop-admin-login-overlay')) {
				return;
			}

			$desktop.hide();

			$bugaboo.load(self.root + '/views/login.tpl', function(tpl)
			{
				$desktop.add(tpl.format({
					root: self.root,
					account: self.account,
				})).show();

				var formSubmitButton = $desktop.find('button.desktop-admin-login-form-button');
				var formResponseContainer = $desktop.find('div.desktop-admin-login-form-response');

				$desktop.find('form.desktop-admin-login-form').addEventListener('submit', function(event)
				{
					event.preventDefault();

					formSubmitButton.disabled = true;
					formResponseContainer.classList.add('hidden');

					event.request = self.httpRequest.post(self.routes.signIn, this);

					event.request.complete(function(response)
					{
						formSubmitButton.disabled = null;
						formResponseContainer.classList.remove('hidden');
						formResponseContainer.textContent = response.message;
					});

					event.request.successful(function(response)
					{
						$desktop.remove('div.desktop-admin-login-overlay');

						if (complete instanceof Function)
						{
							complete.call(this);
						}
					});
				});

				$desktop.find('button.desktop-admin-login-cancel').addEventListener('click', function(event)
				{
					$desktop.remove('div.desktop-admin-login-overlay');
				});
			});
		});
	};

	/**
	 * Разавторизация учетной записи
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.logout = function()
	{
		this.with(function(self)
		{
			$desktop.hide();

			self.httpRequest.get(self.routes.signOut, {success: function()
			{
				$desktop.show();

				self.login();
			}});
		});
	};

	/**
	 * Загрузка компонента рабочего стола
	 *
	 * @param   callback   complete
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.__load__ = function(complete)
	{
		this.read(function()
		{
			complete();
		});
	};

	/**
	 * Инициализация компонента рабочего стола
	 *
	 * @param   callback   complete
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.__init__ = function(complete)
	{
		this.with(function(self)
		{
			$desktop.module('icon').add({
				id: 'logout',
				label: 'Выйти из системы',
				image: self.root + '/res/icons/logout@32.png',
				click: function(event) {
					self.logout();
				},
			});
		});

		complete();
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('admin', $component);
})();
