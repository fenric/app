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
		this.title = 'Рабочий стол';
		this.favicon = 'paint-brush';
		this.template = this.root + '/views/form.tpl';

		this.routes = {};
		this.routes.saveDesktopPalette = '/admin/api/save-desktop-palette/';
		this.routes.saveDesktopWallpaper = '/admin/api/save-desktop-wallpaper/';
	};

	/**
	 * Открытие приложения
	 *
	 * @access  public
	 * @return  void
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

				modal.listenClick('.sort-desktop-icons', function(event)
				{
					event.preventDefault();

					$desktop.module('icon').sort();
				});

				modal.listenClick('.desktop-pallet', function(event)
				{
					$desktop.decorate(this.getAttribute('data-value'), function(pallet)
					{
						self.httpRequest.patch(self.routes.saveDesktopPalette, {'palette': pallet}, {repeat: true});
					});
				});

				modal.listenChange('.desktop-wallpaper', function(event)
				{
					event.preventDefault();
					event.target.disabled = true;

					$desktop.component('uploader').image(this.files[0], function(response)
					{
						$desktop.app.style.backgroundImage = 'url(/upload/' + response.file + ')';

						self.httpRequest.patch(self.routes.saveDesktopWallpaper, {'wallpaper': response.file}, {repeat: true});

					}).complete(function(response)
					{
						event.target.value = null;
						event.target.disabled = false;
					});
				});
			});
		});
	};

	/**
	 * Инициализация компонента
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
