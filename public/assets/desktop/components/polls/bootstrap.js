'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Опросы';
		this.favicon = 'pie-chart';

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 25;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all = '{root}/api/poll/all/?&{params}';
		this.routes.create = '{root}/api/poll/create/';
		this.routes.update = '{root}/api/poll/update/{id}/';
		this.routes.delete = '{root}/api/poll/delete/{id}/';
		this.routes.unload = '{root}/api/poll/unload/';
		this.routes.read = '{root}/api/poll/read/{id}/';

		this.routes.variants = {};
		this.routes.variants.create = '{root}/api/poll/create-variant/{id}/';
		this.routes.variants.update = '{root}/api/poll/update-variant/{id}/';
		this.routes.variants.delete = '{root}/api/poll/delete-variant/{id}/';
		this.routes.variants.sort = '{root}/api/poll/sort-variants/';

		this.templates = {};
		this.templates.list = this.root + '/views/list.tpl';
		this.templates.form = this.root + '/views/form.tpl';
		this.templates.variant = this.root + '/views/variant.tpl';
		this.templates.variants = this.root + '/views/variants.tpl';
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

			self.modal().title('{title} / Список опросов', {title: self.title}).open().block();

			self.xhr.get(self.routes.all, {repeat: true, params: self.params.toSerialize(), success: function(items)
			{
				self.modal().title('{title} / Список опросов ({count})', {title: self.title, count: items.count});

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

			modal.title('{title} / Создание опроса', {title: self.title}).open();

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

			modal.title('{title} / Редактирование опроса / ...', {title: self.title}).open().block();

			self.read(id, function(item)
			{
				modal.title('{title} / Редактирование опроса / {item_title}', {title: self.title, item_title: item.title}).unblock();

				self.form(modal, item);
			});
		});
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
	 * Простая выгрузка объектов
	 */
	$component.prototype.unload = function(complete)
	{
		this.xhr.get(this.routes.unload, {repeat: true, success: function(response)
		{
			complete.call(this, response);
		}});
	};

	/**
	 * Варианты ответов опроса
	 */
	$component.prototype.variants = function(id)
	{
		var modal;

		this.with(function(self)
		{
			modal = self.modal('variants:' + id, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.variants(id);
				});
			}});

			modal.title('{title} / Варианты ответов опроса / ...', {title: self.title}).open().block();

			self.read(id, function(poll)
			{
				modal.title('{title} / Варианты ответов опроса / {poll_title}', {title: self.title, poll_title: poll.title})

				$bugaboo.load(self.templates.variants, function(tpl)
				{
					modal.content(
						tpl.format({poll: poll})
					).unblock();

					modal.submit(function(event, form, params)
					{
						if (form.hasAttribute('data-id'))
						{
							if (form.hasAttribute('data-action'))
							{
								switch (form.getAttribute('data-action'))
								{
									case 'create' :
										modal.block();
										self.xhr.post(self.routes.variants.create, params.toSerialize(), {repeat: true, id: form.getAttribute('data-id')}).complete(function() {
											self.variants(poll.id);
										});
										break;

									case 'update' :
										modal.block();
										self.xhr.patch(self.routes.variants.update, params.toSerialize(), {repeat: true, id: form.getAttribute('data-id')}).complete(function() {
											modal.unblock();
										});
										break;
								}
							}
						}
					});

					modal.search('.delete', function(element)
					{
						jQuery(element).confirmation({onConfirm: function(event)
						{
							self.xhr.delete(self.routes.variants.delete, {repeat: true, id: element.form.getAttribute('data-id'), success: function()
							{
								modal.remove('.poll-variant[data-id="{id}"]', {id: element.form.getAttribute('data-id')});
							}});
						}});
					});

					modal.find('.sortable', function(element)
					{
						jQuery(element).sortable({handle: '.sortable-handle', update: function(event, ui)
						{
							self.xhr.patch(self.routes.variants.sort, {id: jQuery(this).sortable('toArray', {attribute: 'data-id'})}, {repeat: true});
						}});
					});
				});
			});
		});
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

			$bugaboo.load(self.templates.form, function(tpl)
			{
				modal.content(
					tpl.format(params)
				).unblock();

				modal.search('input.date-time-picker', function(element)
				{
					jQuery(element).datetimepicker({
						format: 'Y-m-d H:i',
						datepicker: true,
						timepicker: true,
						scrollInput: false,
					});

					modal.onclosing(function() {
						jQuery(element).datetimepicker('destroy');
					});
				});

				modal.submit(function(event) {
					modal.triggerEventListeners('modal.content.save');
				});
			});
		});
	};

	/**
	 * Помощь в работе с компонентом
	 */
	$component.prototype.help = function()
	{};

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
	$desktop.regcom('polls', $component);

})(window['jQuery']);
