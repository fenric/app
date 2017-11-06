'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Баннеры';
		this.favicon = null;

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 25;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all = '{root}/api/banner/all-banners/?&{params}';
		this.routes.unload = '{root}/api/banner/unload-banners/';
		this.routes.create = '{root}/api/banner/create-banner/';
		this.routes.update = '{root}/api/banner/update-banner/{id}/';
		this.routes.delete = '{root}/api/banner/delete-banner/{id}/';
		this.routes.read = '{root}/api/banner/read-banner/{id}/';

		this.templates = {};
		this.templates.list = this.root + '/views/list-banners.tpl';
		this.templates.form = this.root + '/views/form-banner.tpl';
	};

	/**
	 * Список объектов
	 */
	$component.prototype.list = function(options)
	{
		options = options || {};

		if (options.page === void(0)) {
			options.page = this.params.default.page;
		}
		if (options.reset === true) {
			this.params.clear(this.params.default);
		}

		for (var key in options) {
			this.params.set(key, options[key]);
		}

		this.with(function(self)
		{
			self.modal(null, {created: function(modal)
			{
				modal.on('modal.content.new', function()
				{
					self.add();
				});

				modal.on('modal.content.reload', function()
				{
					self.list(self.params.all());
				});

				modal.on('modal.live.search', function(event, element)
				{
					self.list({q: element.value});
				});
			}});

			self.modal().title('{title} / Список баннеров', {title: self.title}).open().block();

			self.xhr.get(self.routes.all, {repeat: true, params: self.params.toSerialize(), success: function(items)
			{
				self.modal().title('{title} / Список баннеров ({count})', {title: self.title, count: items.count});

				$bugaboo.load(self.templates.list, function(tpl)
				{
					self.modal().content(tpl.format({
						params: self.params,
						items: items,
					})).unblock();

					self.modal().submit(function(event)
					{
						self.params.load(this);

						self.list();
					});

					self.modal().search('.delete', function(element)
					{
						jQuery(element).confirmation({onConfirm: function()
						{
							self.delete(element.getAttribute('data-id'), function(response)
							{
								self.list(options);
							});
						}});
					});

					self.modal().getBodyNode().scrollTop = 0;
				});
			}});
		});
	};

	/**
	 * Создание объекта
	 */
	$component.prototype.add = function()
	{
		var modal, request;

		this.with(function(self)
		{
			modal = self.modal(Math.random(), {created: function(modal)
			{
				modal.on('modal.content.save', function()
				{
					modal.find('form', function(form)
					{
						modal.block();

						request = self.xhr.post(self.routes.create, form, {
							repeat: true,
						});

						request.complete(function(response)
						{
							$desktop.component('formhandle').handle(form, response);

							modal.unblock();
						});

						request.successful(function(response)
						{
							self.edit(response.created.id);

							modal.close();
						});
					});
				});
			}});

			modal.title('{title} / Создание баннера', {title: self.title}).open();

			self.form(modal, {});
		});
	};

	/**
	 * Редактирование объекта
	 */
	$component.prototype.edit = function(id)
	{
		var modal;

		this.with(function(self)
		{
			modal = self.modal(id, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.edit(id);
				});

				modal.on('modal.content.save', function()
				{
					modal.find('form', function(form)
					{
						modal.block();

						self.xhr.patch(self.routes.update, form, {repeat: true, id: id}).complete(function(response)
						{
							$desktop.component('formhandle').handle(form, response);

							modal.unblock();
						});
					});
				});
			}});

			modal.title('{title} / Редактирование баннера / ...', {title: self.title}).open().block();

			self.read(id, function(item)
			{
				modal.title('{title} / Редактирование баннера / {banner_title}', {title: self.title, banner_title: item.title}).unblock();

				self.form(modal, item);
			});
		});
	};

	/**
	 * Удаление объекта
	 */
	$component.prototype.delete = function(id, complete)
	{
		this.xhr.delete(this.routes.delete, {repeat: true, id: id, success: function(response)
		{
			complete.call(this, response);
		}});
	};

	/**
	 * Чтение объекта
	 */
	$component.prototype.read = function(id, complete)
	{
		this.xhr.get(this.routes.read, {repeat: true, id: id, success: function(response)
		{
			complete.call(this, response);
		}});
	};

	/**
	 * Основная форма компонента
	 */
	$component.prototype.form = function(modal, params)
	{
		params = params || {};

		this.with(function(self)
		{
			modal.block();

			$desktop.component('banners.groups').unload(function(groups)
			{
				$desktop.component('banners.clients').unload(function(clients)
				{
					$bugaboo.load(self.templates.form, function(tpl)
					{
						params.groups = groups;
						params.clients = clients;

						modal.content(
							tpl.format(params)
						).unblock();

						modal.search('.select-picker', function(element)
						{
							jQuery(element).selectpicker({});

							modal.onclosing(function()
							{
								jQuery(element).selectpicker('destroy');
							});
						});

						modal.search('.date-time-picker', function(element)
						{
							jQuery(element).datetimepicker({
								format: 'Y-m-d H:i',
								datepicker: true,
								timepicker: true,
								scrollInput: false,
							});

							modal.onclosing(function()
							{
								jQuery(element).datetimepicker('destroy');
							});
						});

						modal.click('.picture-delete', function(event)
						{
							modal.clear('.picture-container');
						});

						modal.change('.picture-upload', function(event, element)
						{
							modal.block();

							$desktop.component('uploader').image(element.files[0], function(response)
							{
								modal.replace('.picture-container', $desktop.createElement('img', {
									'class': ['img-thumbnail', 'form-element'],
									'style': 'margin-bottom: 10px;',
									'src': '/upload/' + response.file,
									'data-name': 'picture',
									'data-value': response.file,
								}));

							}).complete(function()
							{
								element.value = null;

								modal.unblock();
							});
						});

						modal.click('.picture-edit', function(event, element)
						{
							modal.find('.picture-container > img', function(element)
							{
								$desktop.component('cropper').edit('/upload/' + element.getAttribute('data-value'), function(response)
								{
									modal.substitute('.picture-container > img', $desktop.createElement('img', {
										'class': ['img-thumbnail', 'form-element'],
										'style': 'margin-bottom: 10px;',
										'src': '/upload/' + response.file,
										'data-name': 'picture',
										'data-value': response.file,
									}));

									return false;
								});
							});
						});

						modal.submit(function(event)
						{
							modal.triggerEventListeners('modal.content.save');
						});
					});
				});
			});
		});
	};

	/**
	 * Помощь в работе с компонентом
	 */
	$component.prototype.help = function()
	{
		// @todo
	};

	/**
	 * Загрузка компонента
	 */
	$component.prototype.__load__ = function(complete)
	{
		this.with(function(self)
		{
			$desktop.include(self.root + '/subcomponents/groups.js', function(event)
			{
				$desktop.include(self.root + '/subcomponents/clients.js', function(event)
				{
					complete();
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
				self.list();
			}});
		});

		complete();
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('banners', $component);

})(window['jQuery']);
