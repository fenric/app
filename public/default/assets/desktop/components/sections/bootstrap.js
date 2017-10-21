'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Разделы';
		this.favicon = 'folder';

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 25;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all = '{root}/api/section/all/?&{params}';
		this.routes.create = '{root}/api/section/create/';
		this.routes.update = '{root}/api/section/update/{id}/';
		this.routes.delete = '{root}/api/section/delete/{id}/';
		this.routes.unload = '{root}/api/section/unload/';
		this.routes.read = '{root}/api/section/read/{id}/';

		this.routes.fields = {};
		this.routes.fields.attach = '{root}/api/section/attach-field/{sectionId}/';
		this.routes.fields.detach = '{root}/api/section/detach-field/{fieldId}/';
		this.routes.fields.sort = '{root}/api/section/sort-fields/{sectionId}/';

		this.templates = {};
		this.templates.list = this.root + '/views/list.tpl';
		this.templates.fields = this.root + '/views/fields.tpl';
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

				modal.on('modal.live.search', function(event, element)
				{
					self.list({q: element.value});
				});
			}});

			self.modal().title('{title} / Список разделов', {title: self.title}).open().block();

			self.xhr.get(self.routes.all, {repeat: true, params: self.params.toSerialize(), success: function(items)
			{
				self.modal().title('{title} / Список разделов ({count})', {title: self.title, count: items.count});

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
							area.value = area.ckeditor ? area.ckeditor.getData() : area.value;
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

			modal.title('{title} / Создание раздела', {title: self.title}).open();

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
							area.value = area.ckeditor ? area.ckeditor.getData() : area.value;
						});

						self.xhr.patch(self.routes.update, form, {repeat: true, id: id}).complete(function(response)
						{
							$desktop.component('formhandle').handle(form, response);

							modal.unblock();
						});
					});
				});
			}});

			modal.title('{title} / Редактирование раздела / ...', {title: self.title}).open().block();

			self.read(id, function(item)
			{
				modal.title('{title} / Редактирование раздела / {header}', {title: self.title, header: item.header}).unblock();

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
	 * Управление дополнительными полями объекта
	 */
	$component.prototype.fields = function(id)
	{
		var modal;

		this.with(function(self)
		{
			modal = self.modal('fields:' + id, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.fields(id);
				});
			}});

			modal.title('{title} / Дополнительные поля раздела / ...', {title: self.title}).open().block();

			self.read(id, function(section)
			{
				modal.title('{title} / Дополнительные поля раздела / {header}', {title: self.title, header: section.header});

				$desktop.component('fields').unload(function(fields)
				{
					$bugaboo.load(self.templates.fields, function(tpl)
					{

						// Удаление уже прикрепленных дополнительных полей из списка
						$desktop.iterate(fields, function(parentKey, parent)
						{
							$desktop.iterate(section.fields, function(fieldKey, field)
							{
								if (parent.id == field.parent.id)
								{
									delete fields[parentKey];
								}
							});
						});

						modal.content(tpl.format({
							section: section,
							fields: fields,
						})).unblock();

						modal.click('.attach', function(event)
						{
							self.xhr.post(self.routes.fields.attach, this.getAttribute('data-id'), {sectionId: section.id}).complete(function(response)
							{
								self.fields(section.id);
							});
						});

						modal.search('.detach', function(element)
						{
							jQuery(element).confirmation({onConfirm: function()
							{
								self.xhr.delete(self.routes.fields.detach, {fieldId: element.getAttribute('data-id')}).complete(function(response)
								{
									self.fields(section.id);
								});
							}});
						});

						modal.find('div.sortable', function(container)
						{
							jQuery(container).sortable({axis: 'y', update: function(event, ui)
							{
								var sortedIds = new Array();

								modal.search('div.sortable-item', function(element)
								{
									sortedIds.push(element.getAttribute('data-id'));
								});

								self.xhr.patch(self.routes.fields.sort, {fieldIds: sortedIds}, {sectionId: section.id});
							}});
						});
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

				modal.search('textarea.ckeditor', function(element)
				{
					$desktop.component('ckeditor').init(element);

					modal.onclosing(function() {
						element.ckeditor.destroy();
					});
				});

				modal.search('select.select-picker', function(element)
				{
					jQuery(element).selectpicker({
						// @continue
					});

					modal.onclosing(function() {
						jQuery(element).selectpicker('destroy');
					});
				});

				modal.click('button.picture-reset', function(event)
				{
					modal.clear('.picture-container');
				});

				modal.change('input.picture-upload', function(event, element)
				{
					var container;

					modal.block();

					$desktop.component('uploader').image(element.files[0], function(response)
					{
						element.value = null;

						container = document.createDocumentFragment();

						container.appendChild($desktop.createElement('img', {
							class: 'img-thumbnail', src: '/upload/150x150/' + response.file,
						}));

						container.appendChild($desktop.createElement('input', {
							type: 'hidden', name: 'picture', value: response.file,
						}));

						modal.replace('div.picture-container', container);

						modal.unblock();
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
	$desktop.regcom('sections', $component);

})(window['jQuery']);
