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
		for (var i = 0; i < form.elements.length; i++)
		{
			if (form.elements[i].disabled)
			{
				continue;
			}

			if (form.elements[i].name.length === 0)
			{
				continue;
			}

			form.elements[i].dump = {};
			form.elements[i].dump.name = form.elements[i].name;
			form.elements[i].dump.value = null;
			form.elements[i].dump.values = [];
			form.elements[i].dump.arrayable = false;

			if (form.elements[i].dump.name.indexOf('[]') === form.elements[i].dump.name.length - 2)
			{
				form.elements[i].dump.name = form.elements[i].dump.name.substring(0, form.elements[i].dump.name.length - 2);
				form.elements[i].dump.value = [];
				form.elements[i].dump.arrayable = true;

				if (this.exists(form.elements[i].dump.name))
				{
					form.elements[i].dump.value = (this.get(form.elements[i].dump.name) instanceof Array) ? this.get(form.elements[i].dump.name) : [this.get(form.elements[i].dump.name)];
				}
			}

			/**
			 * Обработка текстовых полей...
			 */
			if (((form.elements[i] instanceof HTMLInputElement) && (! /(?:radio|checkbox|submit|button|reset|image|file)/i.test(form.elements[i].type))) || (form.elements[i] instanceof HTMLTextAreaElement))
			{
				if (form.elements[i].dump.arrayable)
				{
					form.elements[i].dump.value.push(form.elements[i].value.trim());

					this.set(form.elements[i].dump.name, form.elements[i].dump.value);

					continue;
				}

				this.set(form.elements[i].dump.name, form.elements[i].value.trim());

				continue;
			}

			/**
			 * Обработка флажков и радиокнопок...
			 */
			if ((form.elements[i] instanceof HTMLInputElement) && (/(?:radio|checkbox)/i.test(form.elements[i].type)))
			{
				if (form.elements[i].dump.arrayable)
				{
					if (form.elements[i].checked)
					{
						form.elements[i].dump.value.push(form.elements[i].value.trim());

						this.set(form.elements[i].dump.name, form.elements[i].dump.value);
					}

					else if (form.elements[i].hasAttribute('data-unchecked-value'))
					{
						form.elements[i].dump.value.push(form.elements[i].getAttribute('data-unchecked-value').trim());

						this.set(form.elements[i].dump.name, form.elements[i].dump.value);
					}

					else if (this.exists(form.elements[i].dump.name) && (form.elements[i].type === 'checkbox'))
					{
						var index;

						if ((index = form.elements[i].dump.value.indexOf(form.elements[i].value.trim())) >= 0)
						{
							form.elements[i].dump.value.splice(index, 1);

							this.set(form.elements[i].dump.name, form.elements[i].dump.value);
						}
					}
				}

				else if (form.elements[i].checked)
				{
					this.set(form.elements[i].dump.name, form.elements[i].value.trim());
				}

				else if (form.elements[i].hasAttribute('data-unchecked-value'))
				{
					this.set(form.elements[i].dump.name, form.elements[i].getAttribute('data-unchecked-value').trim());
				}

				else if (this.exists(form.elements[i].dump.name) && (form.elements[i].type === 'checkbox'))
				{
					this.remove(form.elements[i].dump.name);
				}

				continue;
			}

			/**
			 * Обработка выпадающего меню...
			 */
			if (form.elements[i] instanceof HTMLSelectElement)
			{
				for (var o = 0; o < form.elements[i].options.length; o++)
				{
					if (form.elements[i].options[o].selected)
					{
						form.elements[i].dump.values.push(form.elements[i].options[o].value.trim());
					}
				}

				if (form.elements[i].dump.arrayable || form.elements[i].multiple || form.elements[i].dump.values.length > 1)
				{
					this.set(form.elements[i].dump.name, form.elements[i].dump.values);
				}

				else if (form.elements[i].dump.values.length > 0)
				{
					this.set(form.elements[i].dump.name, form.elements[i].dump.values[0]);
				}

				else if (this.exists(form.elements[i].dump.name))
				{
					this.remove(form.elements[i].dump.name);
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
