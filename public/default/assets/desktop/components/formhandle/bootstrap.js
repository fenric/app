'use strict';

(function()
{
	var $component;

	/**
	 * Компонент рабочего стола
	 */
	$component = function()
	{};

	/**
	 * Обработка формы
	 */
	$component.prototype.handle = function(form, response)
	{
		var i;
		var err;
		var group;
		var groups = form.querySelectorAll('div.form-group');

		for (i = 0; i < groups.length; i++)
		{
			groups[i].classList.remove('has-error');

			if (groups[i].querySelector('div.help-block.error'))
			{
				groups[i].querySelector('div.help-block.error').innerHTML = "";
			}
		}

		if (response instanceof Object)
		{
			if (response.errors !== void(0))
			{
				for (i = 0; i < response.errors.length; i++)
				{
					err = response.errors[i];

					group = form.querySelector('div.form-group[data-name="' + err[1] + '"]') || form.querySelector('div.form-group[data-name="*"]');

					if (group instanceof Node)
					{
						group.classList.add('has-error');

						if (group.querySelector('div.help-block.error'))
						{
							err[2] = '<p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;' + err[0] + '</p>';

							group.querySelector('div.help-block.error').innerHTML += err[2];
						}
					}
				}
			}
		}
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('formhandle', $component);

})();
