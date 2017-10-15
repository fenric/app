'use strict';

(function()
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{};

	/**
	 * Загрузка изображения
	 */
	$component.prototype.image = function(file, onSuccess)
	{
		return this.xhr.put('/user/api/upload-image/', file, {repeat: true, success: function(response)
		{
			if (onSuccess instanceof Function) {
				onSuccess.call(this, response, this);
			}
		}});
	};

	/**
	 * Загрузка PDF
	 */
	$component.prototype.pdf = function(file, onSuccess)
	{
		return this.xhr.put('/user/api/upload-pdf/', file, {repeat: true, success: function(response)
		{
			if (onSuccess instanceof Function) {
				onSuccess.call(this, response, this);
			}
		}});
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('uploader', $component);

})();
