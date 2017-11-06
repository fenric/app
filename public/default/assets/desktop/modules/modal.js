'use strict';

(function()
{
	var $modal;
	var $module;

	/**
	 * Модальное окно
	 *
	 * @param   int      id
	 * @param   object   element
	 * @param   object   params
	 *
	 * @access  public
	 * @return  void
	 */
	$modal = function(id, element, params)
	{
		this.id = id;

		this.params = params;
		this.element = element;
		this.eventListeners = {};

		this.iconNode = element.querySelector('div.desktop-modal-head > i.fa');
		this.headNode = element.querySelector('div.desktop-modal-head > span');
		this.bodyNode = element.querySelector('div.desktop-modal-body');

		this.defaultPercentageWidth = 80;
		this.defaultPercentageHeight = 80;

		(function(self)
		{
			self.on('modal.content.find', function()
			{
				self.find('input.modal-live-search', function(element)
				{
					element.focus();
				});
			});

		})(this);
	};

	/**
	 * Добавление слушателя события
	 *
	 * @param   string     eventName
	 * @param   Function   eventListener
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.on = function(eventName, eventListener)
	{
		if (this.eventListeners[eventName] === undefined) {
			this.eventListeners[eventName] = new Array();
		}

		this.eventListeners[eventName].push(eventListener);
	};

	/**
	 * Вызов слушателей событий
	 *
	 * @param   string   eventName
	 * @param   Array    eventParams
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.triggerEventListeners = function(eventName, eventParams)
	{
		eventParams = eventParams || [];

		if (this.eventListeners[eventName] instanceof Array) {
			this.eventListeners[eventName].forEach(function(eventListener) {
				eventListener.apply(this, eventParams);
			});
		}
	};

	/**
	 * Удаление слушателей событий
	 *
	 * @param   string   eventName
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.deleteEventListeners = function(eventName)
	{
		if (this.eventListeners[eventName] instanceof Array) {
			delete this.eventListeners[eventName];
		}
	};

	/**
	 * Регистрация слушателя события который будет вызван при изменении заголовка модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onchangetitle = function(callback) {
		this.params.onchangetitle = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван при изменении содержимого модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onchangecontent = function(callback) {
		this.params.onchangecontent = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван перед открытием модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onopening = function(callback) {
		this.params.onopening = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван после открытия модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onopen = function(callback) {
		this.params.onopen = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван перед закрытием модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onclosing = function(callback) {
		this.params.onclosing = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван после закрытия модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onclose = function(callback) {
		this.params.onclose = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван перед блокировкой окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onblocking = function(callback) {
		this.params.onblocking = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван после блокировки окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onblock = function(callback) {
		this.params.onblock = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван перед разблокировкой модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onunblocking = function(callback) {
		this.params.onunblocking = callback;
	};

	/**
	 * Регистрация слушателя события который будет вызван после разблокировки модального окна
	 *
	 * @param   Function   callback
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.onunblock = function(callback) {
		this.params.onunblock = callback;
	};

	/**
	 * Получение модального окна в виде узла
	 *
	 * @access  public
	 * @return  Node
	 */
	$modal.prototype.getNode = function() {
		return this.element;
	};

	/**
	 * Получение иконки модального окна в виде узла
	 *
	 * @access  public
	 * @return  Node
	 */
	$modal.prototype.getIconNode = function() {
		return this.iconNode;
	};

	/**
	 * Получение заголовка модального окна в виде узла
	 *
	 * @access  public
	 * @return  Node
	 */
	$modal.prototype.getHeadNode = function() {
		return this.headNode;
	};

	/**
	 * Получение содержимого модального окна в виде узла
	 *
	 * @access  public
	 * @return  Node
	 */
	$modal.prototype.getBodyNode = function() {
		return this.bodyNode;
	};

	/**
	 * Поиск узла внутри содержимого модального окна
	 *
	 * @param   string     selector
	 * @param   Function   reader
	 * @param   object     context
	 *
	 * @access  public
	 * @return  Node
	 */
	$modal.prototype.find = function(selector, reader, context)
	{
		var element = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		if (element instanceof Node) {
			if (reader instanceof Function) {
				reader.call(element, element);
			}
		}

		return element;
	};

	/**
	 * Поиск узлов внутри содержимого модального окна
	 *
	 * @param   string     selector
	 * @param   Function   reader
	 * @param   object     context
	 *
	 * @access  public
	 * @return  array
	 */
	$modal.prototype.search = function(selector, reader, context)
	{
		var elements = Array.prototype.slice.call(
			this.bodyNode.querySelectorAll(
				$desktop.interpolate(selector, context)
			)
		);

		if (elements.length > 0) {
			if (reader instanceof Function) {
				elements.forEach(function(element) {
					reader.call(element, element);
				});
			}
		}

		return elements;
	};

	/**
	 * Проверка существования узла внутри содержимого модального окна
	 *
	 * @param   string   selector
	 * @param   object   context
	 *
	 * @access  public
	 * @return  bool
	 */
	$modal.prototype.exists = function(selector, context)
	{
		if (this.find(selector, null, context) instanceof Node) {
			return true;
		}

		return false;
	};

	/**
	 * Прослушивание события узла внутри содержимого модального окна
	 *
	 * @param   string     selector
	 * @param   string     eventname
	 * @param   Function   listener
	 * @param   object     context
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.listen = function(selector, eventname, listener, context)
	{
		this.search(selector, function(element)
		{
			element.addEventListener(eventname, function(event)
			{
				listener.call(this, event, this);
			});

		}, context);
	};

	$modal.prototype.click = function(selector, listener, context)
	{
		this.listen(selector, 'click', listener, context);
	};
	$modal.prototype.change = function(selector, listener, context)
	{
		this.listen(selector, 'change', listener, context);
	};
	$modal.prototype.keydown = function(selector, listener, context)
	{
		this.listen(selector, 'keydown', listener, context);
	};
	$modal.prototype.keypress = function(selector, listener, context)
	{
		this.listen(selector, 'keypress', listener, context);
	};
	$modal.prototype.keyup = function(selector, listener, context)
	{
		this.listen(selector, 'keyup', listener, context);
	};
	$modal.prototype.focus = function(selector, listener, context)
	{
		this.listen(selector, 'focus', listener, context);
	};
	$modal.prototype.blur = function(selector, listener, context)
	{
		this.listen(selector, 'blur', listener, context);
	};

	/**
	 * Смена иконки модального окна
	 *
	 * @param   string   value
	 *
	 * @access  public
	 * @return  object
	 *
	 * @see     http://fontawesome.io/icons/
	 */
	$modal.prototype.icon = function(value)
	{
		value = 'fa-' + value.replace(/^fa-/, '');

		this.iconNode.className = '';
		this.iconNode.classList.add('fa');
		this.iconNode.classList.add(value);

		return this;
	};

	/**
	 * Смена заголовка модального окна
	 *
	 * @param   mixed    value
	 * @param   object   context
	 *
	 * @access  public
	 * @return  object
	 */
	$modal.prototype.title = function(value, context)
	{
		while (this.headNode.firstChild) {
			this.headNode.removeChild(this.headNode.firstChild);
		}

		if (typeof value === 'string') {
			value = document.createTextNode(
				$desktop.interpolate(value, context)
			);
		}

		this.headNode.appendChild(value);

		if (this.params.onchangetitle instanceof Function) {
			this.params.onchangetitle.apply(this, arguments);
		}

		return this;
	};

	/**
	 * Смена содержимого модального окна
	 *
	 * @param   mixed    value
	 * @param   object   context
	 *
	 * @access  public
	 * @return  object
	 */
	$modal.prototype.content = function(value, context)
	{
		while (this.bodyNode.firstChild) {
			this.bodyNode.removeChild(this.bodyNode.firstChild);
		}

		if (typeof value === 'string') {
			value = document.createTextNode(
				$desktop.interpolate(value, context)
			);
		}

		this.bodyNode.appendChild(value);
		this.bodyNode.scrollTop = 0;

		if (this.params.onchangecontent instanceof Function) {
			this.params.onchangecontent.apply(this, arguments);
		}

		(function(self)
		{
			self.find('input.modal-live-search', function(element)
			{
				var finder;

				element.addEventListener('keyup', function(event)
				{
					clearTimeout(finder);

					finder = setTimeout(function()
					{
						self.triggerEventListeners('modal.live.search', [event, element]);

					}, 1000);
				});

				element.addEventListener('blur', function(event)
				{
					clearTimeout(finder);
				});
			});

		})(this);

		return this;
	};

	/**
	 * Открытие модального окна
	 *
	 * @param   int    width
	 * @param   int    height
	 * @param   bool   percentage
	 *
	 * @access  public
	 * @return  object
	 */
	$modal.prototype.open = function(width, height, percentage)
	{
		if (this.running()) {
			this.foreground();

			return this;
		}

		$desktop.module('modal').modals[this.id] = this;

		this.position(width, height, percentage);
		this.foreground();

		if (this.params.onopening instanceof Function) {
			this.params.onopening.apply(this, arguments);
		}

		$desktop.add(this.element);

		if (this.params.onopen instanceof Function) {
			this.params.onopen.apply(this, arguments);
		}

		return this;
	};

	/**
	 * Закрытие модального окна
	 *
	 * @access  public
	 * @return  object
	 */
	$modal.prototype.close = function()
	{
		delete $desktop.module('modal').modals[this.id];

		if (this.params.onclosing instanceof Function) {
			this.params.onclosing.apply(this, arguments);
		}

		$desktop.remove(this.element);

		this.element.classList.remove('state-background');
		this.element.classList.remove('state-foreground');

		if (this.params.onclose instanceof Function) {
			this.params.onclose.apply(this, arguments);
		}

		var $foregroundModal = $desktop.module('modal').byPosition(-1);

		if ($foregroundModal instanceof Object) {
			$foregroundModal.foreground();
		}

		return this;
	};

	/**
	 * Блокировка модального окна
	 *
	 * @access  public
	 * @return  object
	 */
	$modal.prototype.block = function()
	{
		if (this.params.onblocking instanceof Function) {
			this.params.onblocking.apply(this, arguments);
		}

		this.element.classList.add('blocked');

		if (this.params.onblock instanceof Function) {
			this.params.onblock.apply(this, arguments);
		}

		return this;
	};

	/**
	 * Разблокировка модального окна
	 *
	 * @access  public
	 * @return  object
	 */
	$modal.prototype.unblock = function()
	{
		if (this.params.onunblocking instanceof Function) {
			this.params.onunblocking.apply(this, arguments);
		}

		this.element.classList.remove('blocked');

		if (this.params.onunblock instanceof Function) {
			this.params.onunblock.apply(this, arguments);
		}

		return this;
	};

	/**
	 * Открыто ли модальное окно
	 *
	 * @access  public
	 * @return  bool
	 */
	$modal.prototype.running = function()
	{
		if (document.body.contains(this.element)) {
			return true;
		}

		return false;
	};

	/**
	 * Событие при отправки формы внутри модального окна
	 *
	 * @param   Function   onsubmit
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.submit = function(onsubmit)
	{
		var i, forms;

		forms = this.bodyNode.querySelectorAll('form');

		if (forms instanceof NodeList)
		{
			if (forms.length > 0)
			{
				for (i = 0; i < forms.length; i++)
				{
					if (forms[i] instanceof HTMLFormElement)
					{
						if (onsubmit instanceof Function)
						{
							forms[i].addEventListener('submit', function(event)
							{
								event.preventDefault();

								onsubmit.call(this, event, this, $desktop.module('params').create(this));
							});

							continue;
						}
					}
				}
			}
		}
	};

	/**
	 * Удаление узла внутри модального окна
	 *
	 * @param   string   selector
	 * @param   object   context
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.remove = function(selector, context)
	{
		var element = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		if (element instanceof Node) {
			element.parentNode.removeChild(element);
		}
	};

	/**
	 * Замена узла внутри модального окна новым содержимым
	 *
	 * @param   string   selector
	 * @param   Node     content
	 * @param   object   context
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.substitute = function(selector, contents, context)
	{
		var element = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		if (typeof contents === 'string') {
			contents = document.createTextNode(contents);
		}

		if (element instanceof Node) {
			element.parentNode.replaceChild(contents, element);
		}
	};

	/**
	 * Замена содержимого узла внутри модального окна
	 *
	 * @param   string   selector
	 * @param   Node     content
	 * @param   object   context
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.replace = function(selector, contents, context)
	{
		var container = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		while (container.firstChild) {
			container.removeChild(container.firstChild);
		}

		if (typeof contents === 'string') {
			contents = document.createTextNode(contents);
		}

		container.appendChild(contents);
	};

	/**
	 * Очистка содержимого узла внутри модального окна
	 *
	 * @param   string   selector
	 * @param   object   context
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.clear = function(selector, context)
	{
		var container = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		while (container.firstChild) {
			container.removeChild(container.firstChild);
		}
	};

	/**
	 * Позиционирование модального окна
	 *
	 * @param   numeric   width
	 * @param   numeric   height
	 * @param   boolean   percentage
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.position = function(width, height, percentage)
	{
		var style = {};

		if (width = parseInt(width)) {
			style.width = percentage ? ((window.innerWidth / 100) * width) : width;
		}
		else if (width = parseInt(this.params.width)) {
			style.width = width;
		}
		else {
			style.width = ((window.innerWidth / 100) * this.defaultPercentageWidth);
		}

		if (height = parseInt(height)) {
			style.height = percentage ? ((window.innerHeight / 100) * height) : height;
		}
		else if (height = parseInt(this.params.height)) {
			style.height = height;
		}
		else {
			style.height = ((window.innerHeight / 100) * this.defaultPercentageHeight);
		}

		style.top = ((window.innerHeight - style.height) / 2);
		style.left = ((window.innerWidth - style.width) / 2);

		this.element.style.top = style.top + 'px';
		this.element.style.left = style.left + 'px';
		this.element.style.width = style.width + 'px';
		this.element.style.height = style.height + 'px';
	};

	/**
	 * Вывод модального окна на передний план
	 *
	 * @access  public
	 * @return  void
	 */
	$modal.prototype.foreground = function()
	{
		if (this.element.classList.contains('state-foreground') === false)
		{
			var index;
			var zIndex = [0];

			var elements = $desktop.search('div.desktop-modal');

			for (index = 0; index < elements.length; index++)
			{
				zIndex.push(elements[index].style.zIndex);

				if (this.element.isEqualNode(elements[index])) {
					continue;
				}

				elements[index].classList.add('state-background');
				elements[index].classList.remove('state-foreground');
			}

			this.element.classList.add('state-foreground');
			this.element.classList.remove('state-background');
			this.element.style.zIndex = Math.max.apply(Math, zIndex) + 1;
		}
	};

	/**
	 * Модуль рабочего стола
	 *
	 * @access  public
	 * @return  void
	 */
	$module = function()
	{
		var self = this;

		this.id = 0;
		this.modals = {};

		this.altPress = false;
		this.ctrlPress = false;
		this.shiftPress = false;

		window.addEventListener('keydown', function(event)
		{
			switch (event.which)
			{
				case 16 :
					self.shiftPress = true;
					break;

				case 17 :
					self.ctrlPress = true;
					break;

				case 18 :
					self.altPress = true;
					break;
			}
		});

		window.addEventListener('keyup', function(event)
		{
			switch (event.which)
			{
				case 16 :
					self.shiftPress = false;
					break;

				case 17 :
					self.ctrlPress = false;
					break;

				case 18 :
					self.altPress = false;
					break;
			}
		});

		window.addEventListener('keydown', function(event)
		{
			var $foregroundModal;

			// Is pressed the alt and shift keys?
			if (self.altPress && self.shiftPress)
			{
				$foregroundModal = $desktop.module('modal').byPosition(-1);

				if ($foregroundModal instanceof Object)
				{
					switch (event.which)
					{
						// [ALT][SHIFT] + [E]
						case 69 :
							event.preventDefault();
							$foregroundModal.triggerEventListeners('modalContentEdit');
							$foregroundModal.triggerEventListeners('modal.content.edit');
							break;

						// [ALT][SHIFT] + [F]
						case 70 :
							event.preventDefault();
							$foregroundModal.triggerEventListeners('modalContentFind');
							$foregroundModal.triggerEventListeners('modal.content.find');
							break;

						// [ALT][SHIFT] + [N]
						case 78 :
							event.preventDefault();
							$foregroundModal.triggerEventListeners('modalContentNew');
							$foregroundModal.triggerEventListeners('modal.content.new');
							break;

						// [ALT][SHIFT] + [P]
						case 80 :
							event.preventDefault();
							$foregroundModal.triggerEventListeners('modalContentPrint');
							$foregroundModal.triggerEventListeners('modal.content.print');
							break;

						// [ALT][SHIFT] + [R]
						case 82 :
							event.preventDefault();
							$foregroundModal.triggerEventListeners('modalContentReload');
							$foregroundModal.triggerEventListeners('modal.content.reload');
							break;

						// [ALT][SHIFT] + [S]
						case 83 :
							event.preventDefault();
							$foregroundModal.triggerEventListeners('modalContentSave');
							$foregroundModal.triggerEventListeners('modal.content.save');
							break;

						// [ALT][SHIFT] + [W]
						case 87 :
							event.preventDefault();
							$foregroundModal.close();
							break;

						// [ALT][SHIFT] + [Z]
						case 90 :
							event.preventDefault();
							$foregroundModal.unblock();
							break;
					}
				}
			}
		});
	};

	/**
	 * Открытие модального окна (alias)
	 *
	 * @param   object   params
	 *
	 * @access  public
	 * @return  object
	 */
	$module.prototype.open = function(params)
	{
		return this.create(params).open();
	};

	/**
	 * Создание модального окна
	 *
	 * @param   object   params
	 *
	 * @access  public
	 * @return  object
	 */
	$module.prototype.create = function(params)
	{
		params = params || {};

		if (typeof params.icon === 'string') {
			params.icon = 'fa-' + params.icon.replace(/^fa-/, '');
		}

		if (typeof params.title === 'string') {
			params.title = document.createTextNode(params.title);
		}
		if (typeof params.content === 'string') {
			params.content = document.createTextNode(params.content);
		}

		var container = document.createElement('div');
		var wrapframe = document.createElement('div');
		var headframe = document.createElement('div');
		var bodyframe = document.createElement('div');
		var sizeframe = document.createElement('div');

		var headicon = document.createElement('i');
		var headtitle = document.createElement('span');
		var headbtnclose = document.createElement('button');
		var headbtnmaximize = document.createElement('button');

		if (params.title instanceof Node) {
			headtitle.appendChild(params.title);
		}
		if (params.content instanceof Node) {
			bodyframe.appendChild(params.content);
		}

		container.classList.add('desktop-modal');
		wrapframe.classList.add('desktop-modal-wrap');
		headframe.classList.add('desktop-modal-head');
		bodyframe.classList.add('desktop-modal-body');
		sizeframe.classList.add('desktop-modal-size');

		headicon.classList.add('fa');
		headicon.classList.add(params.icon || 'fa-cube');

		headbtnclose.classList.add('desktop-modal-on-close');
		headbtnmaximize.classList.add('desktop-modal-on-maximize');

		headframe.appendChild(headicon);
		headframe.appendChild(headtitle);
		headframe.appendChild(headbtnclose);
		headframe.appendChild(headbtnmaximize);

		wrapframe.appendChild(headframe);
		wrapframe.appendChild(bodyframe);
		container.appendChild(wrapframe);
		container.appendChild(sizeframe);

		/**
		 * Вывод модального окна на передний план
		 */
		container.addEventListener('mousedown', function(event)
		{
			container.$modal.foreground();
		});

		/**
		 * Позиционирование модального окна
		 */
		headframe.addEventListener('mousedown', function(event)
		{
			var drag = {};

			drag.during = function(event)
			{
				event.preventDefault();

				drag.top = event.clientY + drag.beginTop;
				drag.left = event.clientX + drag.beginLeft;

				container.style.top = drag.top + 'px';
				container.style.left = drag.left + 'px';
			};

			drag.stopped = function(event)
			{
				event.preventDefault();

				container.classList.remove('state-draggable');

				document.removeEventListener('mousemove', drag.during);
				document.removeEventListener('mouseup', drag.stopped);
			};

			if (event.which === 1)
			{
				event.preventDefault();

				drag.beginTop = container.offsetTop - event.clientY;
				drag.beginLeft = container.offsetLeft - event.clientX;

				document.addEventListener('mousemove', drag.during);
				document.addEventListener('mouseup', drag.stopped);

				container.classList.add('state-draggable');
			}
		});

		/**
		 * Масштабирование модального окна
		 */
		sizeframe.addEventListener('mousedown', function(event)
		{
			var resize = {};

			resize.during = function(event)
			{
				event.preventDefault();

				resize.width = (event.clientX - resize.beginLeft) + resize.beginWidth;
				resize.height = (event.clientY - resize.beginTop) + resize.beginHeight;

				if (resize.width >= 250 && resize.width <= window.innerWidth)
				{
					container.style.width = resize.width + 'px';
				}

				if (resize.height >= 250 && resize.height <= window.innerHeight)
				{
					container.style.height = resize.height + 'px';
				}
			};

			resize.stopped = function(event)
			{
				event.preventDefault();

				container.classList.remove('state-resizable')

				document.removeEventListener('mousemove', resize.during);
				document.removeEventListener('mouseup', resize.stopped);
			};

			if (event.which === 1)
			{
				event.preventDefault();

				resize.beginTop = event.clientY;
				resize.beginLeft = event.clientX;
				resize.beginWidth = container.offsetWidth;
				resize.beginHeight = container.offsetHeight;

				document.addEventListener('mousemove', resize.during);
				document.addEventListener('mouseup', resize.stopped);

				container.classList.add('state-resizable');
			}
		});

		/**
		 * Закрытие модального окна
		 */
		headbtnclose.addEventListener('click', function(event)
		{
			event.preventDefault();

			container.$modal.close();
		});

		/**
		 * Максимальное масштабирование модального окна
		 */
		headbtnmaximize.addEventListener('click', function(event)
		{
			event.preventDefault();

			if (container.hasAttribute('data-maximize'))
			{
				container.removeAttribute('data-maximize');

				container.style.top = container.getAttribute('data-before-maximize-top');
				container.style.left = container.getAttribute('data-before-maximize-left');
				container.style.width = container.getAttribute('data-before-maximize-width');
				container.style.height = container.getAttribute('data-before-maximize-height');

				container.classList.remove('state-maximize');

				return;
			}

			container.setAttribute('data-maximize', 'true');
			container.setAttribute('data-before-maximize-top', container.style.top);
			container.setAttribute('data-before-maximize-left', container.style.left);
			container.setAttribute('data-before-maximize-width', container.style.width);
			container.setAttribute('data-before-maximize-height', container.style.height);

			container.style.top = '0px';
			container.style.left = '0px';
			container.style.width = window.innerWidth + 'px';
			container.style.height = window.innerHeight + 'px';

			container.classList.add('state-maximize');
		});

		container.$modal = new $modal(
			++this.id, container, params
		);

		return container.$modal;
	};

	/**
	 * Получение экземпляра модального окна по его позиции
	 *
	 * @param   number   position
	 *
	 * @access  public
	 * @return  mixed
	 */
	$module.prototype.byPosition = function(position)
	{
		var i;

		var all = new Array();

		var elements = $desktop.search('div.desktop-modal');

		if (elements.length > 0)
		{
			if (elements.length > position)
			{
				if (position < 0)
				{
					position = elements.length - 1;
				}

				for (i = 0; i < elements.length; i++)
				{
					all.push(elements[i].$modal);
				}

				return all.sort(function(a, b)
				{
					return a.element.style.zIndex - b.element.style.zIndex;

				})[position];
			}
		}
	};

	/**
	 * Регистрация модуля рабочего стола
	 */
	$desktop.regmod('modal', $module);
})();
