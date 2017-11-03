'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.root = $desktop.component('banners').root;

		this.title = 'Клиенты баннеров';
		this.favicon = null;

		this.params = $desktop.module('params').create();

		this.params.default = {};
		this.params.default.page = 1;
		this.params.default.limit = 25;

		this.params.load(this.params.default);

		this.routes = {};
		this.routes.all = '{root}/api/banner/all-clients/?&{params}';
		this.routes.unload = '{root}/api/banner/unload-clients/';
		this.routes.create = '{root}/api/banner/create-client/';
		this.routes.update = '{root}/api/banner/update-client/{id}/';
		this.routes.delete = '{root}/api/banner/delete-client/{id}/';
		this.routes.read = '{root}/api/banner/read-client/{id}/';

		this.templates = {};
		this.templates.list = this.root + '/views/list-clients.tpl';
		this.templates.form = this.root + '/views/form-client.tpl';
	};

	/**
	 * Список объектов
	 */
	$component.prototype.list = function(options)
	{};

	/**
	 * Простая выгрузка объектов
	 */
	$component.prototype.unload = function(complete)
	{
		complete.call(null, []);
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('banners.clients', $component);

})(window['jQuery']);
