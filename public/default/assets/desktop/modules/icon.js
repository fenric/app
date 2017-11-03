'use strict';

(function()
{
	var $module = function()
	{
		this.gridsize = 72;

		this.elements = {};
	};

	$module.prototype.add = function(params)
	{
		this.elements[params.id] = {};

		this.elements[params.id].element = this.create(params);

		this.elements[params.id].element.setAttribute('data-id', params.id);

		this.elements[params.id].element.addEventListener('dblclick', function(event)
		{
			event.preventDefault();

			params.click.call(this, event);
		});

		this.elements[params.id].element.addEventListener('touchstart', function(event)
		{
			event.preventDefault();

			params.click.call(this, event);
		});

		$desktop.add(this.elements[params.id].element);
	};

	$module.prototype.shift = function(id, top, left)
	{
		var state = {};

		state.top = this.elements[id].top;
		state.left = this.elements[id].left;

		this.elements[id].top = top;
		this.elements[id].left = left;

		this.elements[id].element.style.top = top + 'px';
		this.elements[id].element.style.left = left + 'px';

		if (! (state.top == top && state.left == left))
		{
			$desktop.module('request').patch('{root}/api/save-desktop-icon/', {id: id, top: top, left: left});
		}
	};

	$module.prototype.create = function(params)
	{
		var self = this;

		var container = document.createElement('div');

		var imageframe = document.createElement('div');
		var labelframe = document.createElement('div');
		var badgeframe = document.createElement('div');

		var imageelement = document.createElement('img');
		var labelelement = document.createElement('span');

		container.classList.add('desktop-icon');
		imageframe.classList.add('desktop-icon-image');
		labelframe.classList.add('desktop-icon-label');
		badgeframe.classList.add('desktop-icon-badge');

		imageelement.src = params.image;
		labelelement.textContent = params.label;

		imageframe.appendChild(imageelement);
		labelframe.appendChild(labelelement);

		container.appendChild(imageframe);
		container.appendChild(labelframe);
		container.appendChild(badgeframe);

		container.addEventListener('mousedown', function(event)
		{
			var drag = {};

			drag.during = function(event)
			{
				event.preventDefault();

				drag.top = event.clientY + drag.beginTop;
				drag.left = event.clientX + drag.beginLeft;

				container.style.top = drag.top + 'px';
				container.style.left = drag.left + 'px';

				drag.offset += drag.top;
				drag.offset += drag.left;
			};

			drag.stopped = function(event)
			{
				event.preventDefault();

				container.classList.remove('draggable');

				document.removeEventListener('mousemove', drag.during);
				document.removeEventListener('mouseup', drag.stopped);

				if (drag.offset === 0) {
					return;
				}

				if (drag.top < 0) {
					drag.top = 0;
				}
				if (drag.top > window.innerHeight - (self.gridsize * 2)) {
					drag.top = window.innerHeight - (self.gridsize * 2);
				}

				if (drag.left < 0) {
					drag.left = 0;
				}
				if (drag.left > window.innerWidth - (self.gridsize * 2)) {
					drag.left = window.innerWidth - (self.gridsize * 2);
				}

				drag.gap = {};

				drag.gap.top = drag.top % self.gridsize;
				drag.gap.left = drag.left % self.gridsize;

				if (drag.gap.top > 0)
				{
					drag.top = (drag.gap.top < self.gridsize / 2) ? drag.top - drag.gap.top : drag.top + (self.gridsize - drag.gap.top);
				}

				if (drag.gap.left > 0)
				{
					drag.left = (drag.gap.left < self.gridsize / 2) ? drag.left - drag.gap.left : drag.left + (self.gridsize - drag.gap.left);
				}

				for (var id in self.elements)
				{
					if (drag.top == self.elements[id].top)
					{
						if (drag.left == self.elements[id].left)
						{
							$desktop.module('icon').shift(id, self.elements[params.id].top, self.elements[params.id].left);
						}
					}
				}

				$desktop.module('icon').shift(params.id, drag.top, drag.left);
			};

			if (event.which === 1)
			{
				event.preventDefault();

				drag.offset = 0;

				drag.beginTop = container.offsetTop - event.clientY;
				drag.beginLeft = container.offsetLeft - event.clientX;

				document.addEventListener('mousemove', drag.during);
				document.addEventListener('mouseup', drag.stopped);

				container.classList.add('draggable');
			}
		});

		return container;
	};

	$module.prototype.sort = function(order)
	{
		order = order || {};

		for (var id in order)
		{
			if (this.elements[id] !== undefined)
			{
				this.elements[id].top = order[id].top;
				this.elements[id].left = order[id].left;

				$desktop.module('icon').shift(id, order[id].top, order[id].left);
			}
		}

		for (var id in this.elements)
		{
			if (order[id] === undefined)
			{
				order[id] = {top: 0, left: 0}

				while (true)
				{
					if (this.freecell(order[id].top, order[id].left))
					{
						break;
					}

					if (order[id].top + this.gridsize > window.innerHeight)
					{
						order[id].top = 0;
						order[id].left += this.gridsize;

						continue;
					}

					order[id].top += this.gridsize;
				}

				$desktop.module('icon').shift(id, order[id].top, order[id].left);
			}
		}
	};

	$module.prototype.freecell = function(top, left)
	{
		for (var id in this.elements)
		{
			if (top === this.elements[id].top)
			{
				if (left === this.elements[id].left)
				{
					return false;
				}
			}
		}

		return true;
	}

	$desktop.regmod('icon', $module);
})();
