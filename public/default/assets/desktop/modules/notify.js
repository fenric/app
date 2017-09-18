'use strict';

(function()
{
	var $module = function()
	{
		this.border = 10;
	};

	$module.prototype.create = function(type, title, content, onclick, onclose)
	{
		if (typeof title === 'string')
		{
			title = document.createTextNode(title);
		}

		if (typeof content === 'string')
		{
			content = document.createTextNode(content);
		}

		var self = this;

		var container = document.createElement('div');
		var headframe = document.createElement('div');
		var bodyframe = document.createElement('div');

		container.classList.add('desktop-notify');
		container.classList.add('desktop-notify-' + type);
		headframe.classList.add('desktop-notify-head');
		bodyframe.classList.add('desktop-notify-body');

		headframe.appendChild(title);
		bodyframe.appendChild(content);
		container.appendChild(headframe);
		container.appendChild(bodyframe);

		if (onclick instanceof Function)
		{
			container.addEventListener('click', function(event)
			{
				onclick(event);

				container.parentNode.removeChild(container);

				if (onclose instanceof Function)
				{
					onclose();
				}

				self.sort();
			});
		}

		container.addEventListener('mousedown', function(event)
		{
			var drag = {};

			drag.during = function(event)
			{
				event.preventDefault();

				drag.left = event.clientX + drag.capture;

				drag.offset = Math.abs(drag.begin - event.clientX);

				drag.opacity = 1 - (drag.offset / container.offsetWidth);

				container.style.left = drag.left + 'px';

				if (drag.opacity >= 0 && drag.opacity <= 1) {
					container.style.opacity = drag.opacity;
				}
			};

			drag.stopped = function(event)
			{
				event.preventDefault();

				document.removeEventListener('mousemove', drag.during);
				document.removeEventListener('mouseup', drag.stopped);

				if (drag.offset >= container.offsetWidth)
				{
					container.parentNode.removeChild(container);

					if (onclose instanceof Function)
					{
						onclose();
					}

					self.sort();

					return;
				}

				container.style.left = drag.begin + drag.capture + 'px';

				container.style.opacity = 1;
			};

			if (event.which === 1)
			{
				event.preventDefault();

				drag.begin = event.clientX;

				drag.capture = container.offsetLeft - event.clientX;

				document.addEventListener('mousemove', drag.during);
				document.addEventListener('mouseup', drag.stopped);
			}
		});

		return container;
	};

	$module.prototype.info = function(title, content, onclick, onclose)
	{
		var element = this.create('info', title, content, onclick, onclose);

		$desktop.add(element);

		this.position(element);

		return element;
	};

	$module.prototype.success = function(title, content, onclick, onclose)
	{
		var element = this.create('success', title, content, onclick, onclose);

		$desktop.add(element);

		this.position(element);

		return element;
	};

	$module.prototype.warning = function(title, content, onclick, onclose)
	{
		var element = this.create('warning', title, content, onclick, onclose);

		$desktop.add(element);

		this.position(element);

		return element;
	};

	$module.prototype.error = function(title, content, onclick, onclose)
	{
		var element = this.create('error', title, content, onclick, onclose);

		$desktop.add(element);

		this.position(element);

		return element;
	};

	$module.prototype.plain = function(title, content, onclick, onclose)
	{
		var element = this.create('plain', title, content, onclick, onclose);

		$desktop.add(element);

		this.position(element);

		return element;
	};

	$module.prototype.position = function(element)
	{
		var i;

		var top = this.border;

		var elements = $desktop.search('div.desktop-notify');

		for (i = 0; i < elements.length; i++)
		{
			if (element.isEqualNode(elements[i]))
			{
				continue;
			}

			top += elements[i].offsetHeight + this.border;
		}

		element.style.top = top + 'px';
	};

	$module.prototype.sort = function()
	{
		var i;

		var top = this.border;

		var elements = $desktop.search('div.desktop-notify');

		for (i = 0; i < elements.length; i++)
		{
			if (i >= 1)
			{
				top += elements[i - 1].offsetHeight + this.border;
			}

			elements[i].style.top = top + 'px';
		}
	};

	$desktop.regmod('notify', $module);
})();
