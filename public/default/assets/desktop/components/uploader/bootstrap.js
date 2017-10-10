'use strict';

(function()
{
	var $component;

	/**
	 * Конструктор компонента
	 *
	 * @access  public
	 * @return  void
	 */
	$component = function()
	{};

	/**
	 * Загрузка изображения
	 *
	 * @param   File       file
	 * @param   Function   complete
	 *
	 * @access  public
	 * @return  object
	 */
	$component.prototype.image = function(file, complete)
	{
		return $desktop.module('request').put('/user/api/upload-image/', file, {repeat: true, success: function(response)
		{
			complete.call(this, response, this);
		}});
	};

	/**
	 * Загрузка PDF
	 *
	 * @param   File       file
	 * @param   Function   complete
	 *
	 * @access  public
	 * @return  object
	 */
	$component.prototype.pdf = function(file, complete)
	{
		return $desktop.module('request').put('/user/api/upload-pdf/', file, {repeat: true, success: function(response)
		{
			complete.call(this, response, this);
		}});
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('uploader', $component);

})();
