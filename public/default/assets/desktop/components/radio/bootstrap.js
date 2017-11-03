'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Радио';
		this.favicon = 'music';

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 25;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all = '{root}/api/radio/all/?&{params}';
		this.routes.create = '{root}/api/radio/create/';
		this.routes.update = '{root}/api/radio/update/{id}/';
		this.routes.delete = '{root}/api/radio/delete/{id}/';
		this.routes.unload = '{root}/api/radio/unload/';
		this.routes.read = '{root}/api/radio/read/{id}/';

		this.routes.nowPlaying = '{root}/api/radio/now-playing/{id}/';

		this.templates = {};
		this.templates.list = this.root + '/views/list.tpl';
		this.templates.form = this.root + '/views/form.tpl';
		this.templates.player = this.root + '/views/player.tpl';

		this.player = new Audio();
		this.player.autoplay = false;
		this.player.volume = 0.8;
		this.player.muted = false

		this.player.station = null;
		this.player.nowPlaying = null;
		this.player.survey = null;
		this.player.surveyTimeout = 15000;
		this.player.surveyEnabled = false;
		this.player.lastSurveyRequest = null;
	};

	/**
	 * Открытие компонента
	 */
	$component.prototype.open = function()
	{
		var modal;

		this.with(function(self)
		{
			modal = self.modal('player', {created: function(modal)
			{
				modal.onopen(function()
				{
					self.player.surveyEnabled = true;
				});

				modal.onclose(function()
				{
					self.player.surveyEnabled = false;
				});

				modal.on('modal.content.new', function()
				{
					self.add();
				});

				modal.on('modal.content.reload', function()
				{
					self.open();
				});
			}});

			modal.title(self.title).open(800, 600).block();

			self.unload(function(stations)
			{
				$bugaboo.load(self.templates.player, function(tpl)
				{
					modal.content(tpl.format({
						stations: stations,
					})).unblock();

					modal.click('.radio-player-action-play', function(event, element)
					{
						modal.block();

						self.play(element.getAttribute('data-id'), function(nowPlaying)
						{
							self.open();
						});
					});

					modal.click('.radio-player-action-now-playing', function(event, element)
					{
						modal.block();

						self.nowPlaying(element.getAttribute('data-id'), function(nowPlaying)
						{
							self.open();
						});
					});

					modal.click('.radio-player-action-volume-down', function(event, element)
					{
						self.volumeDown();
					});

					modal.click('.radio-player-action-volume-up', function(event, element)
					{
						self.volumeUp();
					});

					modal.click('.radio-player-action-stop', function(event, element)
					{
						self.stop();
					});
				});
			});
		});
	};

	/**
	 * Запуск радиостанции
	 */
	$component.prototype.play = function(id, nowPlaying)
	{
		this.with(function(self)
		{
			self.stop();

			self.read(id, function(station)
			{
				self.icon().querySelector('.desktop-icon-badge').innerHTML = '&bull;';
				self.icon().querySelector('.desktop-icon-badge').classList.add('show');

				self.player.src = station.stream;
				self.player.station = station;
				self.player.play();

				self.nowPlaying(station.id, function(response)
				{
					self.player.nowPlaying = response;

					if (nowPlaying instanceof Function) {
						nowPlaying.call(this, response);
					}

					self.player.survey = setInterval(function()
					{
						if (self.player.surveyEnabled)
						{
							self.nowPlaying(station.id, function(response)
							{
								self.player.nowPlaying = response;

								if (nowPlaying instanceof Function) {
									nowPlaying.call(this, response);
								}
							});
						}

					}, self.player.surveyTimeout);
				});
			});
		});
	};

	/**
	 * Остановка радиостанции
	 */
	$component.prototype.stop = function()
	{
		this.icon().querySelector('.desktop-icon-badge').innerHTML = null;
		this.icon().querySelector('.desktop-icon-badge').classList.remove('show');

		this.player.src = null;
		this.player.station = null;
		this.player.nowPlaying = null;

		clearInterval(this.player.survey);
	};

	/**
	 * Опрос радиостанции
	 */
	$component.prototype.nowPlaying = function(id, complete)
	{
		this.with(function(self)
		{
			if (self.player.lastSurveyRequest)
			{
				self.player.lastSurveyRequest.abort();

				self.player.lastSurveyRequest = null;
			}

			self.player.lastSurveyRequest = self.xhr.get(self.routes.nowPlaying, {id: id});

			self.player.lastSurveyRequest.success(function(response)
			{
				if (complete instanceof Function)
				{
					complete.call(this, response);
				}
			});
		});
	};

	/**
	 * Убавление громкости в плеере
	 */
	$component.prototype.volumeDown = function()
	{
		if (this.player.volume >= 0.1) {
			this.player.volume -= 0.1;
		}
	};

	/**
	 * Прибавление громкости в плеере
	 */
	$component.prototype.volumeUp = function()
	{
		if (this.player.volume <= 0.9) {
			this.player.volume += 0.1;
		}
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
				modal.on('modal.content.new', function() {
					self.add();
				});

				modal.on('modal.content.reload', function() {
					self.list(self.params.all());
				});

				modal.on('modal.live.search', function(event, element) {
					self.list({q: element.value});
				});
			}});

			self.modal().title('{title} / Список радиостанций', {title: self.title}).open().block();

			self.xhr.get(self.routes.all, {repeat: true, params: self.params.toSerialize(), success: function(items)
			{
				self.modal().title('{title} / Список радиостанций ({count})', {title: self.title, count: items.count});

				$bugaboo.load(self.templates.list, function(tpl)
				{
					self.modal().content(tpl.format({
						params: self.params,
						items: items,
					})).unblock();

					self.modal().submit(function(event) {
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

			modal.title('{title} / Создание радиостанции', {title: self.title}).open();

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

			modal.title('{title} / Редактирование радиостанции / ...', {title: self.title}).open().block();

			self.read(id, function(item)
			{
				modal.title('{title} / Редактирование радиостанции / {radio_title}', {title: self.title, radio_title: item.title}).unblock();

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
				self.open();
			}});
		});

		complete();
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('radio', $component);

})(window['jQuery']);
