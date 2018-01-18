'use strict';

// Recommended icons pack:
// https://www.iconfinder.com/iconsets/fatcow

(function()
{
	$desktop.init();

	$request.get('{root}/api/desktop-modules/', {success: function(modules)
	{
		$request.get('{root}/api/desktop-components/', {success: function(components)
		{
			$desktop.render({modules: modules, components: components, onload: function()
			{
				jQuery.datetimepicker.setLocale('ru');

				$bugaboo.elementary['desktop'] = this;

				$bugaboo.formatters['datetime'] = function(value, format)
				{
					var df;

					if (value.length > 0)
					{
						df = new DateFormatter();

						if (value === 'now')
						{
							return df.formatDate(new Date(), format);
						}

						return df.formatDate(new Date(value), format);
					}
				};

				this.module('request').onload(function(response, event)
				{
					var message = '';

					if (response instanceof Object)
					{
						if (response.message !== undefined)
						{
							message = response.message;

							if (response.errfile !== undefined)
							{
								message += '<hr>in file: ' + response.errfile;

								if (response.errline !== undefined)
								{
									message += '<br>on line: ' + response.errline;
								}
							}
						}
					}

					switch (this.status)
					{
						case 200 :
						case 201 :
							break;

						case 401 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_INFO);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('Для того, чтобы продолжить, необходимо ввести пароль');
								notify.setMessage(message || 'Все незавершенные процессы автоматически возобновятся, после того как вы введете пароль.', true);
								notify.display();

								$desktop.component('admin').login(function()
								{
									notify.close();

									$desktop.module('request').runRepeatRequest();
								});
							});
							break;

						case 400 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 400');
								notify.setMessage(message || 'Плохой или неверный запрос.', true);
								notify.display();
							});
							break;

						case 403 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 403');
								notify.setMessage(message || 'Недостаточно прав для выполнения запроса.', true);
								notify.display();
							});
							break;

						case 404 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 404');
								notify.setMessage(message || 'Не удалось найти ресурс, возможно он был удалён ранее.', true);
								notify.display();
							});
							break;

						case 405 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 405');
								notify.setMessage(message || 'Метод не поддерживается контроллером или сервером.', true);
								notify.display();
							});
							break;

						case 413 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 413');
								notify.setMessage(message || 'Сервер отвергнул запрос т.к. запрос оказался слишком большой.', true);
								notify.display();
							});
							break;

						case 414 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 414');
								notify.setMessage(message || 'Сервер отвергнул запрос т.к. URI слишком длинный.', true);
								notify.display();
							});
							break;

						case 415 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 415');
								notify.setMessage(message || 'Тип загружаемого файла не поддерживается.', true);
								notify.display();
							});
							break;

						case 423 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_WARNING);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 423');
								notify.setMessage(message || 'Ресурс временно заблокирован.', true);
								notify.display();
							});
							break;

						case 500 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_ERROR);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 500');
								notify.setMessage(message || 'На сервере произошёл технический сбой.', true);
								notify.display();
							});
							break;

						case 503 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_ERROR);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 503');
								notify.setMessage(message || 'Не удалось выполнить операцию по техническим причинам.', true);
								notify.display();
							});
							break;

						case 504 :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_ERROR);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP 504');
								notify.setMessage(message || 'Сервер не успел обработать запрос за отведённое ему время, попробуйте выполнить действие ещё раз.', true);
								notify.display();
							});
							break;

						default :
							new $notify(function(notify)
							{
								notify.setType(notify.TYPE_ERROR);
								notify.setPosition(notify.POSITION_TOP_RIGHT);
								notify.setLifetime(-1);
								notify.setTitle('HTTP ' + this.status);
								notify.setMessage(message || 'Uncaught HTTP code...', true);
								notify.display();
							});
							break;
					}
				});

				this.component('admin').with(function()
				{
					$desktop.module('icon').sort(this.account.desktop.icons || null);

					if (this.account.desktop.modalContentFontSize)
					{
						$desktop.modalContentFontSizeControl(
							this.account.desktop.modalContentFontSize
						);
					}

					if (this.account.desktop.palette)
					{
						$desktop.app.classList.add(
							this.account.desktop.palette
						);
					}

					if (this.account.desktop.wallpaper)
					{
						$desktop.app.style.backgroundImage = 'url(/upload/' + this.account.desktop.wallpaper + ')';

						$request.get('/upload/{file}', {file: this.account.desktop.wallpaper, onload: function(response)
						{
							$desktop.show();
						}});

						return;
					}

					$desktop.show();
				});
			}});
		}});
	}});
})();
