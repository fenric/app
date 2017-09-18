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
		this.title = 'Публикации';
		this.favicon = 'file';

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 20;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all = '/admin/api/publication/all/?&{params}';
		this.routes.create = '/admin/api/publication/create/';
		this.routes.update = '/admin/api/publication/update/{id}/';
		this.routes.delete = '/admin/api/publication/delete/{id}/';
		this.routes.read = '/admin/api/publication/read/{id}/';

		this.routes.photos = {};
		this.routes.photos.all = '/admin/api/publication/all-photos/{publicationId}/';
		this.routes.photos.create = '/admin/api/publication/create-photo/{publicationId}/';
		this.routes.photos.enable = '/admin/api/publication/enable-photo/{photoId}/';
		this.routes.photos.disable = '/admin/api/publication/disable-photo/{photoId}/';
		this.routes.photos.delete = '/admin/api/publication/delete-photo/{photoId}/';
		this.routes.photos.sort = '/admin/api/publication/sort-photos/';

		this.templates = {};
		this.templates.list = this.root + '/views/list.tpl';
		this.templates.photo = this.root + '/views/photo.tpl';
		this.templates.photos = this.root + '/views/photos.tpl';
		this.templates.form = this.root + '/views/form.tpl';
	};

	/**
	 * Список объектов
	 *
	 * @param   object   options
	 *
	 * @access  public
	 * @return  void
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
					self.list(options);
				});

				modal.on('modal.content.find', function()
				{
					// @continue
				});
			}});

			self.modal().title('{title} / Список публикаций', {title: self.title}).open().block();

			self.httpRequest.get(self.routes.all, {repeat: true, params: self.params.toSerialize(), success: function(items)
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

						self.modal().search('.delete[data-toggle=confirmation]', function(element)
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
	 *
	 * @access  public
	 * @return  void
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

						modal.search('textarea.ckeditor', function(area)
						{
							area.value = area.ckeditor.getData();
						});

						request = self.httpRequest.post(self.routes.create, form, {
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
	 *
	 * @param   integer   id
	 *
	 * @access  public
	 * @return  void
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

						modal.search('textarea.ckeditor', function(area)
						{
							area.value = area.ckeditor.getData();
						});

						self.httpRequest.patch(self.routes.update, form, {repeat: true, id: id}).complete(function(response)
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
	 *
	 * @param   integer    id
	 * @param   callback   complete
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.read = function(id, complete)
	{
		this.with(function(self)
		{
			self.httpRequest.get(self.routes.read, {repeat: true, id: id, success: function(response)
			{
				complete.call(this, response);
			}});
		});
	};

	/**
	 * Удаление объекта
	 *
	 * @param   integer    id
	 * @param   callback   complete
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.delete = function(id, complete)
	{
		this.with(function(self)
		{
			self.httpRequest.delete(self.routes.delete, {repeat: true, id: id, success: function(response)
			{
				complete.call(this, response);
			}});
		});
	};

	/**
	 * Управление фотографиями объекта
	 *
	 * @param   integer   publicationId
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.photos = function(publicationId)
	{
		var modal;

		this.with(function(self)
		{
			modal = self.modal(publicationId * 1000000, {created: function(modal)
			{
				modal.on('modal.content.reload', function()
				{
					self.photos(publicationId);
				});
			}});

			modal.title('{title} / Фотографии публикации / ...', {title: self.title}).open().block();

			self.read(publicationId, function(publication)
			{
				modal.title('{title} / Фотографии публикации / {header}', {title: self.title, header: publication.header});

				self.httpRequest.get(self.routes.photos.all, {repeat: true, publicationId: publicationId, success: function(photos)
				{
					modal.title('{title} / Фотографии публикации ({count}) / {header}', {title: self.title, header: publication.header, count: photos.count});

					$bugaboo.load(self.templates.photo, function(tplPhoto)
					{
						$bugaboo.load(self.templates.photos, function(tplPhotos)
						{
							modal.content(tplPhotos.format({
								publication: publication,
								photos: photos,
							})).unblock();

							modal.find('div.gallery', function(gallery)
							{
								if (photos.count > 0)
								{
									photos.items.forEach(function(photo)
									{
										gallery.appendChild(tplPhoto.format({
											publication: publication,
											photo: photo,
										}));
									});
								}

								modal.listenChange('.upload', function(event)
								{
									var queue = event.target.files.length;

									for (var i = 0; i < event.target.files.length; i++)
									{
										// Разблокируется автоматически после перезагрузки...
										modal.block();

										$desktop.component('uploader').image(event.target.files[i], function(uploaded)
										{
											self.httpRequest.post(self.routes.photos.create, {file: uploaded.file}, {repeat: true, publicationId: publicationId, success: function(response)
											{
												(queue === 0) && self.photos(publicationId);
											}});

										}).complete(function(response)
										{
											(--queue === 0) && self.photos(publicationId);
										});
									}
								});

								modal.listenClick('.enable', function(event)
								{
									self.httpRequest.patch(self.routes.photos.enable, null, {repeat: true, photoId: event.target.getAttribute('data-id'), success: function(response)
									{
										self.photos(publication.id);
									}});
								});

								modal.listenClick('.disable', function(event)
								{
									self.httpRequest.patch(self.routes.photos.disable, null, {repeat: true, photoId: event.target.getAttribute('data-id'), success: function(response)
									{
										self.photos(publication.id);
									}});
								});

								modal.search('.delete', function(element)
								{
									jQuery(element).confirmation({onConfirm: function()
									{
										self.httpRequest.delete(self.routes.photos.delete, {repeat: true, photoId: element.getAttribute('data-id'), success: function(response)
										{
											modal.remove('div.photo[data-id="' + element.getAttribute('data-id') + '"]');
										}});
									}});
								});

								jQuery(gallery).sortable({handle: 'img', update: function(event, ui)
								{
									self.httpRequest.patch(self.routes.photos.sort, {id: jQuery(gallery).sortable('toArray', {attribute: 'data-id'})}, {repeat: true});
								}});
							});
						});
					});
				}});
			});
		});
	};

	/**
	 * Основная форма компонента
	 *
	 * @param   object   modal
	 * @param   object   params
	 *
	 * @access  public
	 * @return  void
	 */
	$component.prototype.form = function(modal, params)
	{
		params = params || {};

		this.with(function(self)
		{
			modal.block();

			$desktop.component('tags').unload(function(tags)
			{
				$desktop.component('sections').unload(function(sections)
				{
					$bugaboo.load(self.templates.form, function(tpl)
					{
						params.tags = tags;
						params.sections = sections;

						modal.content(
							tpl.format(params)
						).unblock();

						modal.search('select.select-picker', function(element)
						{
							jQuery(element).selectpicker();
						});

						modal.search('input.date-time-picker', function(element)
						{
							jQuery(element).datetimepicker({format: 'Y-m-d H:i'});
						});

						modal.search('textarea.ckeditor', function(element)
						{
							$desktop.component('ckeditor').init(element);
						});

						modal.listenClick('button.picture-reset', function(event)
						{
							modal.clear('.picture-container');
						});

						modal.listenChange('input.picture-upload', function(event)
						{
							var container;

							modal.block();

							$desktop.component('uploader').image(event.target.files[0], function(response)
							{
								event.target.value = null;

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
