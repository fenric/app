'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Сниппеты';
		this.favicon = null;

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 25;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all = '{root}/api/snippet/all/?&{params}';
		this.routes.create = '{root}/api/snippet/create/';
		this.routes.update = '{root}/api/snippet/update/{id}/';
		this.routes.delete = '{root}/api/snippet/delete/{id}/';
		this.routes.read = '{root}/api/snippet/read/{id}/';

		this.templates = {};
		this.templates.list = this.root + '/views/list.tpl';
		this.templates.form = this.root + '/views/form.tpl';
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
			}});

			self.modal().title('{title} / Список сниппетов', {title: self.title}).open().block();

			self.xhr.get(self.routes.all, {repeat: true, params: self.params.toSerialize(), success: function(items)
			{
				self.modal().title('{title} / Список сниппетов ({count})', {title: self.title, count: items.count});

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

						modal.search('textarea', function(area)
						{
							area.value = area.codemirror ? area.codemirror.getValue() : area.value;
						});

						request = self.xhr.post(self.routes.create, form,
						{
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

			modal.title('{title} / Создание сниппета', {title: self.title}).open();

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

						modal.search('textarea', function(area)
						{
							area.value = area.codemirror ? area.codemirror.getValue() : area.value;
						});

						self.xhr.patch(self.routes.update, form, {repeat: true, id: id}).complete(function(response)
						{
							$desktop.component('formhandle').handle(form, response);

							modal.unblock();
						});
					});
				});
			}});

			modal.title('{title} / Редактирование сниппета / ...', {title: self.title}).open().block();

			self.read(id, function(item)
			{
				modal.title('{title} / Редактирование сниппета / {itemTitle}', {title: self.title, itemTitle: item.title}).unblock();

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
	 * Демонстрация объекта
	 */
	$component.prototype.demo = function(id)
	{
		var modal, iframe;

		this.with(function(self)
		{
			modal = self.modal(id * 1000000, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.demo(id);
				});
			}});

			modal.title('{title} / Демонстрация сниппета / ...', {title: self.title}).open().block();

			self.read(id, function(snippet)
			{
				modal.title('{title} / Демонстрация сниппета / {snippetTitle}', {title: self.title, snippetTitle: snippet.title});

				iframe = document.createElement('iframe');

				iframe.src = 'data:text/html;charset=utf-8,' + encodeURI('<!DOCTYPE html><html><head></head><body>' + snippet.parsed_value + '</body></html>');

				iframe.style.position = 'absolute';

				iframe.style.top = '2%';
				iframe.style.bottom = '2%';

				iframe.style.left = '1%';
				iframe.style.right = '1%';

				iframe.style.width = '98%';
				iframe.style.height = '96%';

				iframe.style.border = '1px solid #eee';

				modal.content(iframe).unblock();
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

				modal.search('textarea.codemirror', function(element)
				{
					element.codemirror = CodeMirror.fromTextArea(element, {
						mode: 'php',
						theme: 'eclipse',
						viewportMargin: Infinity,
						lineNumbers: true,
						indentUnit: 4,
						indentWithTabs: true,
						styleActiveLine: true,
						matchBrackets: true,
						matchTags: true,
						autoCloseTags: true,
					});
				});

				modal.submit(function(event)
				{
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
	$desktop.regcom('snippets', $component);

})(window['jQuery']);
