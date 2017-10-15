'use strict';

(function()
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Обновление системы';
		this.favicon = 'refresh';
	};

	/**
	 * Запуск обновления
	 */
	$component.prototype.run = function()
	{
		var container;

		this.with(function(self)
		{
			self.modal(null).title(self.title).open(800, 480).block();

			self.xhr.get('{root}/update/', {repeat: true, success: function(response)
			{
				container = document.createElement('pre');

				container.appendChild(
					document.createTextNode(response)
				);

				self.modal(null).content(container).unblock();
			}});
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
				self.run();
			}});
		});

		complete();
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('update', $component);

})();
