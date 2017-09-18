'use strict';

(function()
{
	var $component;

	/**
	 * Конструктор компонента
	 *
	 * @access  public
	 * @return  void
	 */
	$component = function()
	{
		this.title = 'Обновление системы';

		this.favicon = 'refresh';
	};

	/**
	 * Запуск обновления
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.run = function()
	{
		var container;

		this.with(function(self)
		{
			self.modal(null).title(self.title).open(800, 480).block();

			$desktop.module('request').get('/admin/update/', {repeat: true, success: function(response)
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
