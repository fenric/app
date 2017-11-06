'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Публикации';
		this.favicon = 'file';

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 25;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all            = '{root}/api/publication/all/?&{params}';
		this.routes.search         = '{root}/api/publication/search/?&q={q}';
		this.routes.create         = '{root}/api/publication/create/';
		this.routes.update         = '{root}/api/publication/update/{id}/';
		this.routes.delete         = '{root}/api/publication/delete/{id}/';
		this.routes.read           = '{root}/api/publication/read/{id}/';

		this.routes.photos = {};
		this.routes.photos.create  = '{root}/api/publication/{id}/create-photo/';
		this.routes.photos.replace = '{root}/api/publication/replace-photo/{id}/';
		this.routes.photos.delete  = '{root}/api/publication/delete-photo/{id}/';
		this.routes.photos.show    = '{root}/api/publication/show-photo/{id}/';
		this.routes.photos.hide    = '{root}/api/publication/hide-photo/{id}/';
		this.routes.photos.sort    = '{root}/api/publication/sort-photos/';

		this.templates = {};
		this.templates.list        = this.root + '/views/list.tpl';
		this.templates.photo       = this.root + '/views/photo.tpl';
		this.templates.photos      = this.root + '/views/photos.tpl';
		this.templates.relation    = this.root + '/views/relation.tpl';
		this.templates.field       = this.root + '/views/field.tpl';
		this.templates.form        = this.root + '/views/form.tpl';
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

			self.modal().title('{title} / Список публикаций', {title: self.title}).open().block();

			self.xhr.get(self.routes.all, {repeat: true, params: self.params.toSerialize(), success: function(items)
			{
				self.modal().title('{title} / Список публикаций ({count})', {title: self.title, count: items.count});

				$desktop.component('sections').unload(function(sections)
				{
					$bugaboo.load(self.templates.list, function(tpl)
					{
						self.modal().content(tpl.format({
							params: self.params,
							sections: sections,
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

			modal.title('{title} / Создание публикации', {title: self.title}).open();

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

			modal.title('{title} / Редактирование публикации / ...', {title: self.title}).open().block();

			self.read(id, function(item)
			{
				modal.title('{title} / Редактирование публикации / {header}', {title: self.title, header: item.header}).unblock();

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
	 * Управление фотографиями объекта
	 */
	$component.prototype.photos = function(id)
	{
		var modal;

		this.with(function(self)
		{
			modal = self.modal('photos:' + id, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.photos(id);
				});
			}});

			modal.title('{title} / Фотографии публикации / ...', {title: self.title}).open().block();

			self.read(id, function(publication)
			{
				modal.title('{title} / Фотографии публикации / {header}', {title: self.title, header: publication.header});

				$bugaboo.load(self.templates.photo, function(tplPhoto)
				{
					$bugaboo.load(self.templates.photos, function(tplPhotos)
					{
						modal.content(tplPhotos.format({
							publication: publication,
						})).unblock();

						modal.find('div.gallery', function(gallery)
						{
							$desktop.iterate(publication.photos, function(i, photo) {
								gallery.appendChild(tplPhoto.format({
									publication: publication,
									photo: photo,
								}));
							});

							modal.change('.upload', function(event, element)
							{
								// Разблокируется автоматически после перезагрузки...
								modal.block();

								var queue = element.files.length;

								for (var i = 0; i < element.files.length; i++)
								{
									$desktop.component('uploader').image(element.files[i]).complete(function(response)
									{
										if ($desktop.inArray(this.status, [200, 201]))
										{
											self.xhr.post(self.routes.photos.create, {file: response.file}, {repeat: true, id: publication.id}).complete(function(response)
											{
												(--queue === 0) && self.photos(publication.id);
											});

											return true;
										}

										(--queue === 0) && self.photos(publication.id);
									});
								}
							});

							modal.click('.to-show', function(event)
							{
								self.xhr.patch(self.routes.photos.show, null, {repeat: true, id: this.getAttribute('data-id'), success: function(response)
								{
									self.photos(publication.id);
								}});
							});

							modal.click('.to-hide', function(event)
							{
								self.xhr.patch(self.routes.photos.hide, null, {repeat: true, id: this.getAttribute('data-id'), success: function(response)
								{
									self.photos(publication.id);
								}});
							});

							modal.click('.edit', function(event, element)
							{
								$desktop.component('cropper').edit('/upload/' + element.getAttribute('data-value'), function(response)
								{
									self.xhr.patch(self.routes.photos.replace, {file: response.file}, {repeat: true, id: element.getAttribute('data-id'), success: function(response)
									{
										self.photos(publication.id);
									}});

									return false;
								});
							});

							modal.search('.delete', function(element)
							{
								jQuery(element).confirmation({onConfirm: function(event)
								{
									self.xhr.delete(self.routes.photos.delete, {repeat: true, id: element.getAttribute('data-id'), success: function(response)
									{
										modal.remove('div.photo[data-id="{id}"]', {id: element.getAttribute('data-id')});
									}});
								}});
							});

							jQuery(gallery).sortable({handle: 'img', update: function(event, ui)
							{
								self.xhr.patch(self.routes.photos.sort, {id: jQuery(gallery).sortable('toArray', {attribute: 'data-id'})}, {repeat: true});
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

			// load templates
			$bugaboo.load(self.templates.form, function(tplForm)
			{
				$bugaboo.load(self.templates.relation, function(tplRelation)
				{
					// load dependencies
					$desktop.component('tags').unload(function(tags)
					{
						$desktop.component('sections').unload(function(sections)
						{
							// selected attached tags
							$desktop.iterate(tags, function(key, value)
							{
								tags[key]['attached'] = $desktop.inArray(value.id, params.tags);
							});

							params.tags = tags;
							params.sections = sections;

							modal.content(
								tplForm.format(params)
							).unblock();

							modal.search('.fetch-fields', function(element)
							{
								modal.search('.fields-container', function(container)
								{
									modal.clear('.fields-container');

									if (element.value.length > 0)
									{
										modal.block();

										$desktop.component('sections').read(element.value, function(section)
										{
											self.fields(modal, container, section, params.fields || {}, function()
											{
												modal.unblock();
											});
										});
									}
								});
							});

							modal.change('.fetch-fields', function(event, element)
							{
								modal.search('.fields-container', function(container)
								{
									modal.clear('.fields-container');

									if (element.value.length > 0)
									{
										modal.block();

										$desktop.component('sections').read(element.value, function(section)
										{
											self.fields(modal, container, section, params.fields || {}, function()
											{
												modal.unblock();
											});
										});
									}
								});
							});

							modal.change('.picture-upload', function(event, element)
							{
								modal.block();

								$desktop.component('uploader').image(element.files[0], function(response)
								{
									modal.replace('.picture-container', $desktop.fragment(function(container)
									{
										container.appendChild($desktop.createElement('img', {
											'class': ['img-thumbnail', 'form-element'],
											'style': 'margin-bottom: 10px;',
											'src': '/upload/150x0/' + response.file,
											'data-name': 'picture',
											'data-value': response.file,
										}));

										if (response.source !== void(0))
										{
											container.appendChild($desktop.createElement('input', {
												'type': 'hidden',
												'name': 'picture_source',
												'value': response.source,
											}));
										}
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
											'src': '/upload/150x0/' + response.file,
											'data-name': 'picture',
											'data-value': response.file,
										}));

										return false;
									});
								});
							});

							modal.click('.picture-delete', function(event)
							{
								modal.clear('.picture-container');
							});

							modal.search('.ckeditor', function(element)
							{
								$desktop.component('ckeditor').init(element);

								modal.onclosing(function() {
									element.ckeditor.destroy();
								});
							});

							modal.search('.select-picker', function(element)
							{
								jQuery(element).selectpicker({
									// @continue
								});

								modal.onclosing(function() {
									jQuery(element).selectpicker('destroy');
								});
							});

							modal.search('.date-picker', function(element)
							{
								jQuery(element).datetimepicker({
									format: 'Y-m-d',
									datepicker: true,
									timepicker: false,
									scrollInput: false,
								});

								modal.onclosing(function() {
									jQuery(element).datetimepicker('destroy');
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

								modal.onclosing(function() {
									jQuery(element).datetimepicker('destroy');
								});
							});

							modal.search('.time-picker', function(element)
							{
								jQuery(element).datetimepicker({
									format: 'H:i',
									datepicker: false,
									timepicker: true,
									scrollInput: false,
								});

								modal.onclosing(function() {
									jQuery(element).datetimepicker('destroy');
								});
							});

							modal.find('.relations', function(container)
							{
								var finder;

								modal.keyup('.search-relations', function(event, element)
								{
									clearTimeout(finder);

									finder = setTimeout(function()
									{
										if (element.value.length > 0)
										{
											element.setAttribute('disabled', 'true');

											self.xhr.get(self.routes.search, {repeat: true, q: encodeURIComponent(element.value), success: function(response)
											{
												element.removeAttribute('disabled');
												element.focus();

												$desktop.iterate(response, function(key, value)
												{
													if (value.id == params.id) {
														return;
													}

													if (modal.exists('.relations > .relation[data-id="{id}"]', {id: value.id})) {
														return;
													}

													container.appendChild(
														tplRelation.format(value)
													);
												});
											}});
										}

									}, 800);
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
		});
	};

	/**
	 * Загрузка дополнительных полей
	 */
	$component.prototype.fields = function(modal, container, section, values, complete)
	{
		this.with(function(self)
		{
			$bugaboo.load(self.templates.field, function(tpl)
			{
				if (section.fields.length > 0)
				{
					$desktop.iterate(section.fields, function(key, field)
					{
						field.value = field.parent.default_value;

						// maybe null...
						if (! (values[field.parent.name] === void(0)))
						{
							field.value = values[field.parent.name];
						}

						container.appendChild(tpl.format({field: field}));
					});

					modal.search('.field-ckeditor', function(element)
					{
						$desktop.component('ckeditor').init(element);

						modal.onclosing(function() {
							element.ckeditor.destroy();
						});
					});

					modal.search('.field-date-picker', function(element)
					{
						jQuery(element).datetimepicker({
							format: 'Y-m-d',
							datepicker: true,
							timepicker: false,
							scrollInput: false,
						});

						modal.onclosing(function() {
							jQuery(element).datetimepicker('destroy');
						});
					});

					modal.search('.field-date-time-picker', function(element)
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

					modal.search('.field-time-picker', function(element)
					{
						jQuery(element).datetimepicker({
							format: 'H:i',
							datepicker: false,
							timepicker: true,
							scrollInput: false,
						});

						modal.onclosing(function() {
							jQuery(element).datetimepicker('destroy');
						});
					});

					modal.click('.field-image-delete', function(event, element)
					{
						modal.clear('.field-image-container[data-field-id="{id}"]', {
							id: element.getAttribute('data-field-id'),
						});
					});

					modal.change('.field-image-upload', function(event, element)
					{
						var selector = $desktop.interpolate('.field-image-container[data-field-id="{id}"]', {
							id: element.getAttribute('data-field-id'),
						});

						modal.find(selector, function(container)
						{
							modal.block();

							$desktop.component('uploader').image(element.files[0], function(response)
							{
								modal.replace(selector, $desktop.createElement('img', {
									'class': ['img-thumbnail', 'form-element'],
									'style': 'margin-bottom: 10px;',
									'src': '/upload/150x0/' + response.file,
									'data-name': container.getAttribute('data-field-name'),
									'data-value': response.file,
								}));

							}).complete(function()
							{
								element.value = null;

								modal.unblock();
							});
						});
					});

					modal.click('.field-image-edit', function(event, element)
					{
						var selector = $desktop.interpolate('.field-image-container[data-field-id="{id}"]', {
							id: element.getAttribute('data-field-id'),
						});

						modal.find(selector, function(container)
						{
							var selector = $desktop.interpolate('.field-image-container[data-field-id="{id}"] > img', {
								id: element.getAttribute('data-field-id'),
							});

							modal.find(selector, function(element)
							{
								$desktop.component('cropper').edit('/upload/' + element.getAttribute('data-value'), function(response)
								{
									modal.substitute(selector, $desktop.createElement('img', {
										'class': ['img-thumbnail', 'form-element'],
										'style': 'margin-bottom: 10px;',
										'src': '/upload/150x0/' + response.file,
										'data-name': container.getAttribute('data-field-name'),
										'data-value': response.file,
									}));

									return false;
								});
							});
						});
					});
				}

				if (complete instanceof Function) {
					complete();
				}
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
	$desktop.regcom('publications', $component);

})(window['jQuery']);
