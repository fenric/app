'use strict';

(function()
{
	var $params = function(values)
	{
		this.items = new Object();

		this.load(values);
	};

	$params.prototype.set = function(key, value)
	{
		this.items[key] = value;

		return this;
	};

	$params.prototype.get = function(key, reserve)
	{
		if (this.items[key] !== undefined)
		{
			return this.items[key];
		}

		return reserve;
	};

	$params.prototype.remove = function(key, reserve)
	{
		if (this.items[key] !== undefined)
		{
			var removed = this.items[key];

			delete this.items[key];

			return removed;
		}

		return reserve;
	};

	$params.prototype.exists = function(key)
	{
		if (this.items[key] !== undefined)
		{
			return true;
		}

		return false;
	};

	$params.prototype.clear = function(values)
	{
		this.items = new Object();

		values && this.load(values);

		return this;
	};

	$params.prototype.all = function()
	{
		return this.items;
	};

	$params.prototype.keys = function()
	{
		return Object.keys(this.all());
	};

	$params.prototype.values = function()
	{
		return Object.values(this.all());
	};

	$params.prototype.count = function()
	{
		return this.keys().length;
	};

	$params.prototype.load = function(values)
	{
		var key;

		if (values instanceof Object)
		{
			if (Object.prototype.toString.call(values).localeCompare('[object Object]') === 0)
			{
				for (key in values)
				{
					this.set(key, values[key]);
				}
			}

			else if (Object.prototype.toString.call(values).localeCompare('[object HTMLFormElement]') === 0)
			{
				this.fromForm(values);
			}
		}

		return this;
	};

	$params.prototype.toJson = function()
	{
		return JSON.stringify(this.items);
	};

	$params.prototype.toSerialize = function()
	{
		var key;
		var segment;
		var segments = [];

		for (key in this.items)
		{
			segment = this.buildSegment(key, this.items[key]);

			if (segment.length > 0)
			{
				segments.push(segment);
			}
		}

		return segments.join('&');
	};

	$params.prototype.buildSegment = function(key, value)
	{
		var parts = new Array();

		if (value instanceof Function)
		{
			parts.push(this.buildSegment(key, value()));
		}

		else if (value instanceof Array)
		{
			for (var i = 0; i < value.length; i++)
			{
				parts.push(this.buildSegment(key + '[]', value[i]));
			}
		}

		else if (value instanceof Object)
		{
			for (var k in value)
			{
				parts.push(this.buildSegment(key + '[' + k + ']', value[k]));
			}
		}

		if (typeof value === 'number')
		{
			value = value.toString();
		}

		if (typeof value === 'string')
		{
			parts.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
		}

		return parts.join('&');
	};

	$params.prototype.fromForm = function(form)
	{
		var felements = Array.prototype.slice.call(form.elements);
		var uelements = Array.prototype.slice.call(form.querySelectorAll('.form-element'));

		for (var i = 0; i < uelements.length; i++)
		{
			if (uelements[i].hasAttribute('data-name'))
			{
				if (uelements[i].hasAttribute('data-value'))
				{
					felements.push((function(element)
					{
						element.name = uelements[i].getAttribute('data-name');
						element.value = uelements[i].getAttribute('data-value');

						return element;

					})(document.createElement('input')));
				}
			}
		}

		for (var i = 0; i < felements.length; i++)
		{
			if (felements[i].disabled)
			{
				continue;
			}

			if (felements[i].name.length === 0)
			{
				continue;
			}

			felements[i].dump = {};
			felements[i].dump.name = felements[i].name;
			felements[i].dump.value = null;
			felements[i].dump.values = [];
			felements[i].dump.arrayable = false;

			if (felements[i].dump.name.indexOf('[]') === felements[i].dump.name.length - 2)
			{
				felements[i].dump.name = felements[i].dump.name.substring(0, felements[i].dump.name.length - 2);
				felements[i].dump.value = [];
				felements[i].dump.arrayable = true;

				if (this.exists(felements[i].dump.name))
				{
					felements[i].dump.value = (this.get(felements[i].dump.name) instanceof Array) ? this.get(felements[i].dump.name) : [this.get(felements[i].dump.name)];
				}
			}

			/**
			 * Обработка текстовых полей...
			 */
			if (((felements[i] instanceof HTMLInputElement) && (! /(?:radio|checkbox|submit|button|reset|image|file)/i.test(felements[i].type))) || (felements[i] instanceof HTMLTextAreaElement))
			{
				if (felements[i].dump.arrayable)
				{
					felements[i].dump.value.push(felements[i].value.trim());

					this.set(felements[i].dump.name, felements[i].dump.value);

					continue;
				}

				this.set(felements[i].dump.name, felements[i].value.trim());

				continue;
			}

			/**
			 * Обработка флажков и радиокнопок...
			 */
			if ((felements[i] instanceof HTMLInputElement) && (/(?:radio|checkbox)/i.test(felements[i].type)))
			{
				if (felements[i].dump.arrayable)
				{
					if (felements[i].checked)
					{
						felements[i].dump.value.push(felements[i].value.trim());

						this.set(felements[i].dump.name, felements[i].dump.value);
					}

					else if (felements[i].hasAttribute('data-unchecked-value'))
					{
						felements[i].dump.value.push(felements[i].getAttribute('data-unchecked-value').trim());

						this.set(felements[i].dump.name, felements[i].dump.value);
					}

					else if (this.exists(felements[i].dump.name) && (felements[i].type === 'checkbox'))
					{
						var index;

						if ((index = felements[i].dump.value.indexOf(felements[i].value.trim())) >= 0)
						{
							felements[i].dump.value.splice(index, 1);

							this.set(felements[i].dump.name, felements[i].dump.value);
						}
					}
				}

				else if (felements[i].checked)
				{
					this.set(felements[i].dump.name, felements[i].value.trim());
				}

				else if (felements[i].hasAttribute('data-unchecked-value'))
				{
					this.set(felements[i].dump.name, felements[i].getAttribute('data-unchecked-value').trim());
				}

				else if (this.exists(felements[i].dump.name) && (felements[i].type === 'checkbox'))
				{
					this.remove(felements[i].dump.name);
				}

				continue;
			}

			/**
			 * Обработка выпадающего меню...
			 */
			if (felements[i] instanceof HTMLSelectElement)
			{
				for (var o = 0; o < felements[i].options.length; o++)
				{
					if (felements[i].options[o].selected)
					{
						felements[i].dump.values.push(felements[i].options[o].value.trim());
					}
				}

				if (felements[i].dump.arrayable || felements[i].multiple || felements[i].dump.values.length > 1)
				{
					this.set(felements[i].dump.name, felements[i].dump.values);
				}

				else if (felements[i].dump.values.length > 0)
				{
					this.set(felements[i].dump.name, felements[i].dump.values[0]);
				}

				else if (this.exists(felements[i].dump.name))
				{
					this.remove(felements[i].dump.name);
				}

				continue;
			}
		}
	};

	var $module = function()
	{};

	$module.prototype.create = function(values)
	{
		return new $params(values);
	};

	$desktop.regmod('params', $module);
})();
