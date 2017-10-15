'use strict';

(function()
{
	var $component;

	/**
	 * Компонент рабочего стола
	 */
	$component = function()
	{
		this.title = 'Рабочий стол';
		this.favicon = 'paint-brush';
		this.template = this.root + '/views/form.tpl';

		this.routes = {};
		this.routes.saveDesktopPalette = '{root}/api/save-desktop-palette/';
		this.routes.saveDesktopWallpaper = '{root}/api/save-desktop-wallpaper/';
	};

	/**
	 * Открытие приложения
	 */
	$component.prototype.open = function()
	{
		var modal;

		this.with(function(self)
		{
			modal = self.modal(null, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.open();
				});
			}});

			modal.title(self.title).open(346, 420).block();

			$bugaboo.load(self.template, function(tpl)
			{
				modal.content(
					tpl.format()
				).unblock();

				modal.click('.sort-desktop-icons', function(event)
				{
					event.preventDefault();

					$desktop.module('icon').sort();
				});

				modal.click('.desktop-palette', function(event)
				{
					$desktop.decorate(this.getAttribute('data-value'), function(palette)
					{
						self.xhr.patch(self.routes.saveDesktopPalette, {'palette': palette}, {repeat: true});
					});
				});

				modal.change('.desktop-wallpaper', function(event, element)
				{
					$desktop.hide();

					event.preventDefault();
					element.disabled = true;

					$desktop.component('uploader').image(element.files[0], function(response)
					{
						$desktop.hide();

						$desktop.app.style.backgroundImage = 'url(/upload/' + response.file + ')';

						self.xhr.get('/upload/{file}', {file: response.file}).complete(function()
						{
							self.xhr.patch(self.routes.saveDesktopWallpaper, {'wallpaper': response.file}, {repeat: true}).complete(function()
							{
								$desktop.show();
							});
						});

					}).complete(function()
					{
						element.value = null;
						element.disabled = false;

						$desktop.show();
					});
				});
			});
		});
	};

	/**
	 * Инициализация компонента
	 */
	$component.prototype.__init__ = function(complete)
	{
		this.with(function(self)
		{
			$desktop.module('icon').add({id: self.id, image: self.appIcon, label: self.title, click: function(event)
			{
				self.open();
			}});
		});

		complete();
	};

	/**
	 * Регистрация компонента рабочего стола
	 */
	$desktop.regcom('settings', $component);

})();
