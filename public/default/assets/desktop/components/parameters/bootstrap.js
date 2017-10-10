'use strict';

(function(jQuery)
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
		this.title = 'Параметры';
		this.favicon = 'cogs';

		this.routes = {};
		this.routes.all = '{root}/api/parameter/all/';
		this.routes.save = '{root}/api/parameter/save/';

		this.templates = {};
		this.templates.form = this.root + '/views/form.tpl';
	};

	/**
	 * Запуск компонента
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.open = function()
	{
		var modal, parameters;

		this.with(function(self)
		{
			modal = self.modal(null, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.open();
				});

				modal.on('modal.content.save', function()
				{
					modal.find('form', function(form)
					{
						modal.block();

						self.xhr.post(self.routes.save, form, {repeat: true, success: function(response)
						{
							$desktop.component('formhandle').handle(form, response);

							modal.unblock();
						}});
					});
				});
			}});

			modal.title(self.title).open().block();

			self.xhr.get(self.routes.all, {repeat: true, success: function(response)
			{
				$bugaboo.load(self.templates.form, function(tpl)
				{
					parameters = {};

					if (response.count > 0) {
						response.items.forEach(function(parameter) {
							parameters[parameter.code] = parameter.value;
						});
					}

					modal.content(
						tpl.format(parameters)
					).unblock();

					modal.submit(function(event) {
						modal.triggerEventListeners('modal.content.save');
					});
				});
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
				self.open();
			}});
		});

		complete();
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('parameters', $component);

})(window['jQuery']);
