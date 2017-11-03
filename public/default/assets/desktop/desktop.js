'use strict';

var $desktop;

/**
 * Рабочий стол
 *
 * @access  public
 * @return  void
 */
$desktop = function()
{
	var self = this;

	self.app = document.querySelector('#desktop');

	self.modules = new Object();

	self.components = new Object();

	self.findDirname();
};

/**
 * Инициализация рабочего стола
 *
 * @access  public
 * @return  void
 */
$desktop.init = function()
{
	$desktop = new $desktop();
};

/**
 * Рендеринг рабочего стола
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.render = function(params)
{
	var self = this;

	self.params = params || {};

	self.params.modules = self.params.modules || [];

	self.params.components = self.params.components || [];

	self.includeModules(function()
	{
		self.includeComponents(function()
		{
			self.loadingComponents(function()
			{
				self.initializationComponents(function()
				{
					if (self.params.onload instanceof Function)
					{
						self.params.onload.call(self);
					}
				});
			});
		});
	});
};

/**
 * Добавление узла на рабочий стол
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.add = function(element)
{
	this.app.appendChild(element);

	return this;
};

/**
 * Удаление узла с рабочего стола
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.remove = function(element)
{
	if (typeof element === 'string') {
		element = this.find(element);
	}

	this.app.removeChild(element);

	return this;
};

/**
 * Поиск узла на рабочем столе
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.find = function(selector, context)
{
	return this.app.querySelector(
		this.interpolate(selector, context)
	);
};

/**
 * Поиск узлов на рабочем столе
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.search = function(selector, context)
{
	return Array.prototype.slice.call(
		this.app.querySelectorAll(
			this.interpolate(selector, context)
		)
	);
};

/**
 * Проверка существования узла на рабочем столе
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.exists = function(selector, context)
{
	if (this.find(selector, context) instanceof Node) {
		return true;
	}

	return false;
};

/**
 * Скрытие рабочего стола
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.hide = function()
{
	this.app.classList.add('loading');

	return this;
};

/**
 * Отображение рабочего стола
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.show = function()
{
	this.app.classList.remove('loading');

	return this;
};

/**
 * Декорирование рабочего стола
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.decorate = function(palette, complete)
{
	if (this.app.classList.contains(palette)) {
		return false;
	}

	this.app.classList.remove('blue');
	this.app.classList.remove('red');
	this.app.classList.remove('pink');
	this.app.classList.remove('purple');
	this.app.classList.remove('violet');
	this.app.classList.remove('cyan');
	this.app.classList.remove('green');
	this.app.classList.remove('lime');
	this.app.classList.remove('orange');
	this.app.classList.remove('brown');
	this.app.classList.remove('jeans');
	this.app.classList.remove('black');

	this.app.classList.add(palette);

	complete.call(this, palette);

	return this;
};

/**
 * Получение экземпляра модуля рабочего стола
 *
 * @access  public
 * @return  object
 */
$desktop.prototype.module = function(name)
{
	return this.modules[name];
};

/**
 * Получение экземпляра компонента рабочего стола
 *
 * @access  public
 * @return  object
 */
$desktop.prototype.component = function(name)
{
	return this.components[name];
};

/**
 * Регистрация модуля рабочего стола
 *
 * @access  public
 * @return  object
 */
$desktop.prototype.regmod = function(name, module)
{
	module.prototype.with = function(callback)
	{
		return callback.call(this, this);
	};

	return this.modules[name] = new module(this);
};

/**
 * Регистрация компонента рабочего стола
 *
 * @access  public
 * @return  object
 */
$desktop.prototype.regcom = function(name, component)
{
	component.prototype.id = name;

	component.prototype.root = [this.dirname, 'components', name].join('/');

	component.prototype.appIcon = [this.dirname, 'components', name, 'res', 'icon@32.png'].join('/');

	component.prototype.xhr = $desktop.module('request');

	component.prototype.modal = function(key, options)
	{
		key = key || this.id;

		options = options || {};

		if (this.modals === void(0))
		{
			this.modals = {};
		}

		if (this.modals[key] === void(0))
		{
			this.modals[key] = $desktop.module('modal').create({
				icon: options.favicon || this.favicon
			});

			if (options.created instanceof Function)
			{
				options.created.call(
					this.modals[key],
					this.modals[key]
				);
			}
		}

		return this.modals[key];
	};

	component.prototype.icon = function(id)
	{
		if ($desktop.module('icon').elements[id || this.id] !== void(0))
		{
			return $desktop.module('icon').elements[id || this.id]['element'];
		}
	};

	component.prototype.view = function(name, complete)
	{
		$bugaboo.load(this.root + '/views/' + name + '.tpl', complete);
	};

	component.prototype.with = function(callback)
	{
		return callback.call(this, this);
	};

	if (component.prototype.__load__ === void(0))
	{
		component.prototype.__load__ = function(complete)
		{
			complete();
		};
	}

	if (component.prototype.__init__ === void(0))
	{
		component.prototype.__init__ = function(complete)
		{
			complete();
		};
	}

	return this.components[name] = new component(this);
};

/**
 * {description}
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.findDirname = function()
{
	var $scripts = document.querySelectorAll('script');

	var $current = $scripts[$scripts.length-1].getAttribute('src');

    this.dirname = $current.substring(0, $current.lastIndexOf('/'));
};

/**
 * {description}
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.includeModules = function(complete)
{
	if (this.params.modules instanceof Array)
	{
		var script;

		var amount = this.params.modules.length;

		for (var i = 0; i < amount; i++)
		{
			script = document.createElement('script');

			script.setAttribute('src', this.dirname + '/modules/' + this.params.modules[i] + '.js?' + Math.random());

			script.setAttribute('data-module', this.params.modules[i]);

			script.addEventListener('load', (function(name)
			{
				return function(event)
				{
					console.info('Module [' + name + '] included and loaded as <script>.');

					if (--amount === 0)
					{
						console.info('All modules included and loaded as <script>.');
						console.log('');

						if (complete instanceof Function)
						{
							complete();
						}
					}
				};

			})(this.params.modules[i]));

			document.body.appendChild(script);
		}
	}
};

/**
 * {description}
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.includeComponents = function(complete)
{
	if (this.params.components instanceof Array)
	{
		var script;

		var amount = this.params.components.length;

		for (var i = 0; i < amount; i++)
		{
			script = document.createElement('script');

			script.setAttribute('src', this.dirname + '/components/' + this.params.components[i] + '/bootstrap.js?' + Math.random());

			script.setAttribute('data-component', this.params.components[i]);

			script.addEventListener('load', (function(name)
			{
				return function(event)
				{
					console.info('Component [' + name + '] included and loaded as <script>.');

					if (--amount === 0)
					{
						console.info('All components included and loaded as <script>.');
						console.log('');

						if (complete instanceof Function)
						{
							complete();
						}
					}
				};

			})(this.params.components[i]));

			document.body.appendChild(script);
		}
	}
};

/**
 * {description}
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.loadingComponents = function(complete)
{
	var amount = Object.keys(this.components).length;

	for (var key in this.components)
	{
		this.components[key].__load__((function(key)
		{
			return function()
			{
				console.info('Component [' + key + '] loaded.');

				if (--amount === 0)
				{
					console.info('All components loaded.');
					console.log('');

					if (complete instanceof Function)
					{
						complete();
					}
				}
			};

		})(key));
	}
};

/**
 * {description}
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.initializationComponents = function(complete)
{
	var amount = Object.keys(this.components).length;

	for (var key in this.components)
	{
		this.components[key].__init__((function(key)
		{
			return function()
			{
				console.info('Component [' + key + '] initialized.');

				if (--amount === 0)
				{
					console.info('All components initialized.');
					console.log('');

					if (complete instanceof Function)
					{
						complete();
					}
				}
			};

		})(key));
	}
};

/**
 * {description}
 *
 * @param   string     location
 * @param   callback   complete
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.include = function(location, complete)
{
	var script = document.createElement('script');

	script.setAttribute('src', location + '?' + Math.random());

	script.addEventListener('load', function(event)
	{
		if (complete instanceof Function) {
			complete.call(this, event);
		}
	});

	document.body.appendChild(script);
};

/**
 * {description}
 *
 * @param   mixed   needle
 * @param   array   haystack
 * @param   bool    strict
 *
 * @access  public
 * @return  bool
 */
$desktop.prototype.inArray = function(needle, haystack, strict)
{
	var i;

	if (haystack instanceof Array)
	{
		for (i = 0; i < haystack.length; i++)
		{
			if (strict === true)
			{
				if (haystack[i] === needle)
				{
					return true;
				}

				continue;
			}

			if (haystack[i] == needle)
			{
				return true;
			}
		}
	}

	return false;
};

/**
 * {description}
 *
 * @param   string   message
 * @param   object   context
 *
 * @access  public
 * @return  string
 */
$desktop.prototype.interpolate = function(message, context)
{
	var key, expression;

	if (context instanceof Object)
	{
		for (key in context)
		{
			expression = new RegExp('{' + key + '}', 'g');

			message = message.replace(expression, context[key]);
		}
	}

	return message;
};

/**
 * {description}
 *
 * @param   Object     object
 * @param   Function   iterator
 *
 * @access  public
 * @return  void
 */
$desktop.prototype.iterate = function(object, iterator)
{
	var key;

	if (object instanceof Object)
	{
		if (iterator instanceof Function)
		{
			for (key in object)
			{
				iterator(key, object[key], object);
			}
		}
	}
};

/**
 * {description}
 *
 * @param   string   tag
 * @param   object   attributes
 *
 * @access  public
 * @return  object
 */
$desktop.prototype.createElement = function(tag, attributes)
{
	var element = window.document.createElement(tag);

	if (attributes instanceof Object)
	{
		for (var name in attributes)
		{
			element.setAttribute(name, attributes[name]);
		}
	}

	return element;
};
