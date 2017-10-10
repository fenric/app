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
				$bugaboo.elementary['desktop'] = this;

				$bugaboo.formatters['datetime'] = function(value, format)
				{
					if (value.length === 0) {
						return '';
					}

					if (value === 'now') {
						value = new Date();
					}

					jQuery.datetimepicker.setLocale('ru');

					return new DateFormatter().formatDate(new Date(value), format);
				};

				this.module('request').onload(function(response, event)
				{
					var message = '';

					if (response instanceof Object) {
						if (response.message !== undefined) {
							message = response.message;
						}
					}

					if (this.status === 401) {
						$desktop.component('admin').login(function() {
							$desktop.module('request').runRepeatRequest();
						});
					}
					else if (this.status === 400) {
						$desktop.module('notify').warning('HTTP ошибка 400',
							message || 'Плохой или неверный запрос.');
					}
					else if (this.status === 403) {
						$desktop.module('notify').warning('HTTP ошибка 403',
							message || 'Недостаточно прав для выполнения запроса.');
					}
					else if (this.status === 404) {
						$desktop.module('notify').warning('HTTP ошибка 404',
							message || 'Не удалось найти ресурс, возможно он был удалён ранее.');
					}
					else if (this.status === 405) {
						$desktop.module('notify').warning('HTTP ошибка 405',
							message || 'Метод не поддерживается контроллером или сервером.');
					}
					else if (this.status === 413) {
						$desktop.module('notify').warning('HTTP ошибка 413',
							message || 'Сервер отвергнул запрос т.к. запрос оказался слишком большой.');
					}
					else if (this.status === 414) {
						$desktop.module('notify').warning('HTTP ошибка 414',
							message || 'Сервер отвергнул запрос т.к. URI слишком длинный.');
					}
					else if (this.status === 415) {
						$desktop.module('notify').warning('HTTP ошибка 415',
							message || 'Тип загружаемого файла не поддерживается.');
					}
					else if (this.status === 423) {
						$desktop.module('notify').warning('HTTP ошибка 423',
							message || 'Ресурс временно заблокирован.');
					}
					else if (this.status === 500) {
						$desktop.module('notify').error('HTTP ошибка 500',
							message || 'На сервере произошёл технический сбой.');
					}
					else if (this.status === 503) {
						$desktop.module('notify').error('HTTP ошибка 503',
							message || 'Не удалось выполнить операцию по техническим причинам.');
					}
					else if (this.status === 504) {
						$desktop.module('notify').error('HTTP ошибка 504',
							message || 'Сервер не успел обработать запрос за отведённое ему время, попробуйте выполнить действие ещё раз.');
					}
					else if (this.status < 200 || this.status > 202) {
						$desktop.module('notify').error('HTTP ошибка ' + this.status,
							message || 'Uncaught HTTP code...');
					}
				});

				this.component('admin').with(function()
				{
					$desktop.module('icon').sort(this.account.desktop.icons || null);

					if (this.account.desktop.palette)
					{
						$desktop.app.classList.add(this.account.desktop.palette);
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
