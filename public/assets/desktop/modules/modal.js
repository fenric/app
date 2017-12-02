'use strict';

(function()
{
	var $events;
	var $modal;
	var $module;

	$events = function()
	{
		this.eventListeners = {};
	};

	$events.prototype.addEventListener = function(eventName, eventListener)
	{
		if (this.eventListeners[eventName] === undefined)
		{
			this.eventListeners[eventName] = new Array();
		}

		this.eventListeners[eventName].push(eventListener);
	};

	$events.prototype.triggerEventListeners = function(eventName, eventParams, eventScope)
	{
		if (this.eventListeners[eventName] instanceof Array)
		{
			this.eventListeners[eventName].forEach(function(eventListener)
			{
				eventListener.apply(eventScope || null, eventParams || []);
			});
		}
	};

	$events.prototype.deleteEventListeners = function(eventName)
	{
		if (this.eventListeners[eventName] instanceof Array)
		{
			delete this.eventListeners[eventName];
		}
	};

	$events.prototype.on = function(eventName, eventListener)
	{
		this.addEventListener(eventName, eventListener);
	};

	$events.prototype.trigger = function(eventName, eventParams, eventScope)
	{
		this.triggerEventListeners(eventName, eventParams, eventScope);
	};

	$events.prototype.off = function(eventName)
	{
		this.deleteEventListeners(eventName);
	};

	/**
	 * Модальное окно
	 *
	 * @constructor
	 *
	 * @param   {number}   id
	 * @param   {node}     element
	 * @param   {object}   params
	 *
	 * @return  {void}
	 */
	$modal = function(id, element, params)
	{
		$events.apply(this, arguments);

		this.id = id;

		this.params = params;
		this.element = element;

		this.iconNode = element.querySelector('div.desktop-modal-head > i');
		this.headNode = element.querySelector('div.desktop-modal-head > span');
		this.bodyNode = element.querySelector('div.desktop-modal-body');

		this.defaultPercentageWidth = 80;
		this.defaultPercentageHeight = 80;

		this.on('modal.content.find', function()
		{
			this.find('input.modal-live-search', function(element)
			{
				element.focus();
			});
		});
	};

	/**
	 * Наследование логики событий
	 */
	$modal.prototype = Object.create($events.prototype);

	/**
	 * Регистрация слушателя события который будет вызван при изменении иконки модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onchangeicon = function(listener)
	{
		this.on('change.icon', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван при изменении заголовка модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onchangetitle = function(listener)
	{
		this.on('change.title', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван при изменении содержимого модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onchangecontent = function(listener)
	{
		this.on('change.content', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван перед открытием модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onopening = function(listener)
	{
		this.on('before.open', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван после открытия модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onopen = function(listener)
	{
		this.on('after.open', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван перед закрытием модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onclosing = function(listener)
	{
		this.on('before.close', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван после закрытия модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onclose = function(listener)
	{
		this.on('after.close', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван перед блокировкой модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onblocking = function(listener)
	{
		this.on('before.block', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван после блокировки модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onblock = function(listener)
	{
		this.on('after.block', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван перед разблокировкой модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onunblocking = function(listener)
	{
		this.on('before.unblock', listener);
	};

	/**
	 * Регистрация слушателя события который будет вызван после разблокировки модального окна
	 *
	 * @param   {callback}   listener
	 *
	 * @return  {void}
	 */
	$modal.prototype.onunblock = function(listener)
	{
		this.on('after.unblock', listener);
	};

	/**
	 * Получение модального окна в виде узла
	 *
	 * @return  {node}
	 */
	$modal.prototype.getNode = function()
	{
		return this.element;
	};

	/**
	 * Получение иконки модального окна в виде узла
	 *
	 * @return  {node}
	 */
	$modal.prototype.getIconNode = function()
	{
		return this.iconNode;
	};

	/**
	 * Получение заголовка модального окна в виде узла
	 *
	 * @return  {node}
	 */
	$modal.prototype.getHeadNode = function()
	{
		return this.headNode;
	};

	/**
	 * Получение содержимого модального окна в виде узла
	 *
	 * @return  {node}
	 */
	$modal.prototype.getBodyNode = function()
	{
		return this.bodyNode;
	};

	/**
	 * Поиск узла внутри содержимого модального окна
	 *
	 * @param   {string}     selector
	 * @param   {callback}   callback
	 * @param   {object}     context
	 *
	 * @return  {node}
	 */
	$modal.prototype.find = function(selector, callback, context)
	{
		var element = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		if (element instanceof Node)
		{
			if (callback instanceof Function)
			{
				callback.call(element, element);
			}
		}

		return element;
	};

	/**
	 * Поиск узлов внутри содержимого модального окна
	 *
	 * @param   {string}     selector
	 * @param   {callback}   callback
	 * @param   {object}     context
	 *
	 * @return  {array}
	 */
	$modal.prototype.search = function(selector, callback, context)
	{
		var elements = Array.prototype.slice.call(
			this.bodyNode.querySelectorAll(
				$desktop.interpolate(selector, context)
			)
		);

		if (callback instanceof Function)
		{
			elements.forEach(function(element)
			{
				callback.call(element, element);
			});
		}

		return elements;
	};

	/**
	 * Проверка существования узла внутри содержимого модального окна
	 *
	 * @param   String   selector
	 * @param   Object   context
	 *
	 * @return  Boolean
	 */
	$modal.prototype.exists = function(selector, context)
	{
		var element = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		return !! (element instanceof Node);
	};

	/**
	 * Удаление узла внутри содержимого модального окна
	 *
	 * @param   String   selector
	 * @param   Object   context
	 *
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
	 * Замена узла внутри содержимого модального окна новым содержимым
	 *
	 * @param   String   selector
	 * @param   Node     content
	 * @param   Object   context
	 *
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
	 * Замена содержимого узла внутри содержимого модального окна
	 *
	 * @param   String   selector
	 * @param   Node     content
	 * @param   Object   context
	 *
	 * @return  void
	 */
	$modal.prototype.replace = function(selector, contents, context)
	{
		var element = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		while (element.firstChild) {
			element.removeChild(element.firstChild);
		}

		if (typeof contents === 'string') {
			contents = document.createTextNode(contents);
		}

		element.appendChild(contents);
	};

	/**
	 * Очистка содержимого узла внутри содержимого модального окна
	 *
	 * @param   String   selector
	 * @param   Object   context
	 *
	 * @return  void
	 */
	$modal.prototype.clear = function(selector, context)
	{
		var element = this.bodyNode.querySelector(
			$desktop.interpolate(selector, context)
		);

		while (element.firstChild) {
			element.removeChild(element.firstChild);
		}
	};

	/**
	 * Прослушивание события узла внутри содержимого модального окна
	 *
	 * @param   String     selector
	 * @param   String     eventName
	 * @param   Function   eventListener
	 * @param   Object     context
	 *
	 * @return  void
	 */
	$modal.prototype.listen = function(selector, eventName, eventListener, context)
	{
		this.search(selector, function(element)
		{
			element.addEventListener(eventName, function(event)
			{
				eventListener.call(this, event, this);
			});

		}, context);
	};

	/**
	 * Прослушивание события при отправки формы внутри содержимого модального окна
	 *
	 * @param   Function   callback
	 *
	 * @return  void
	 *
	 * @see     https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onsubmit
	 */
	$modal.prototype.submit = function(callback)
	{
		if (callback instanceof Function)
		{
			this.listen('form', 'submit', function(event, form)
			{
				event.preventDefault();

				callback.call(form, event, form,
					$desktop.module('params').create(form)
				);
			});
		}
	};

	$modal.prototype.onsubmit = function(callback)
	{
		this.submit(callback);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/oncontextmenu
	 */
	$modal.prototype.contextmenu = function(selector, eventListener, context)
	{
		this.listen(selector, 'contextmenu', eventListener, context);
	};
	$modal.prototype.oncontextmenu = function(selector, eventListener, context)
	{
		this.contextmenu(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onclick
	 */
	$modal.prototype.click = function(selector, eventListener, context)
	{
		this.listen(selector, 'click', eventListener, context);
	};
	$modal.prototype.onclick = function(selector, eventListener, context)
	{
		this.click(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/ondblclick
	 */
	$modal.prototype.dblclick = function(selector, eventListener, context)
	{
		this.listen(selector, 'dblclick', eventListener, context);
	};
	$modal.prototype.ondblclick = function(selector, eventListener, context)
	{
		this.dblclick(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onchange
	 */
	$modal.prototype.change = function(selector, eventListener, context)
	{
		this.listen(selector, 'change', eventListener, context);
	};
	$modal.prototype.onchange = function(selector, eventListener, context)
	{
		this.change(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onkeydown
	 */
	$modal.prototype.keydown = function(selector, eventListener, context)
	{
		this.listen(selector, 'keydown', eventListener, context);
	};
	$modal.prototype.onkeydown = function(selector, eventListener, context)
	{
		this.keydown(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onkeypress
	 */
	$modal.prototype.keypress = function(selector, eventListener, context)
	{
		this.listen(selector, 'keypress', eventListener, context);
	};
	$modal.prototype.onkeypress = function(selector, eventListener, context)
	{
		this.keypress(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onkeyup
	 */
	$modal.prototype.keyup = function(selector, eventListener, context)
	{
		this.listen(selector, 'keyup', eventListener, context);
	};
	$modal.prototype.onkeyup = function(selector, eventListener, context)
	{
		this.keyup(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onfocus
	 */
	$modal.prototype.focus = function(selector, eventListener, context)
	{
		this.listen(selector, 'focus', eventListener, context);
	};
	$modal.prototype.onfocus = function(selector, eventListener, context)
	{
		this.focus(selector, eventListener, context);
	};

	/**
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/GlobalEventHandlers/onblur
	 */
	$modal.prototype.blur = function(selector, eventListener, context)
	{
		this.listen(selector, 'blur', eventListener, context);
	};
	$modal.prototype.onblur = function(selector, eventListener, context)
	{
		this.blur(selector, eventListener, context);
	};

	/**
	 * Смена иконки модального окна
	 *
	 * @param   String   value
	 *
	 * @return  this
	 *
	 * @see     http://fontawesome.io/icons/
	 */
	$modal.prototype.icon = function(value)
	{
		value = 'fa-' + value.replace(/^fa-/, '');

		this.iconNode.className = '';
		this.iconNode.classList.add('fa');
		this.iconNode.classList.add(value);

		this.trigger('change.icon', [this, this.iconNode]);

		$desktop.module('modal').trigger('change.icon', [this, this.iconNode]);

		return this;
	};

	/**
	 * Смена заголовка модального окна
	 *
	 * @param   String   value
	 * @param   Object   context
	 *
	 * @return  this
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

		this.trigger('change.title', [this, this.headNode]);

		$desktop.module('modal').trigger('change.title', [this, this.headNode]);

		return this;
	};

	/**
	 * Смена содержимого модального окна
	 *
	 * @param   Node     value
	 * @param   Object   context
	 *
	 * @return  this
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

		this.trigger('change.content', [this, this.bodyNode]);

		$desktop.module('modal').trigger('change.content', [this, this.bodyNode]);

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
						self.trigger('modal.live.search', [event, element]);

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
	 * @param   Number    width
	 * @param   Number    height
	 * @param   Boolean   percentage
	 *
	 * @return  this
	 */
	$modal.prototype.open = function(width, height, percentage)
	{
		if (this.running())
		{
			if (this.element.classList.contains('state-minimize'))
			{
				// @continue

				this.element.classList.remove('state-minimize');
			}

			this.foreground();

			return this;
		}

		$desktop.module('modal').modals[this.id] = this;

		this.position(width, height, percentage);
		this.foreground();

		this.trigger('before.open', [this]);

		$desktop.module('modal').trigger('before.open', [this]);

		$desktop.add(this.element);

		$desktop.module('modal').trigger('after.open', [this]);

		this.trigger('after.open', [this]);

		return this;
	};

	/**
	 * Закрытие модального окна
	 *
	 * @return  this
	 */
	$modal.prototype.close = function()
	{
		delete $desktop.module('modal').modals[this.id];

		this.element.classList.remove('state-minimize');
		this.element.classList.remove('state-maximize');

		this.element.classList.remove('state-background');
		this.element.classList.remove('state-foreground');

		this.trigger('before.close', [this]);

		$desktop.module('modal').trigger('before.close', [this]);

		$desktop.remove(this.element);

		$desktop.module('modal').trigger('after.close', [this]);

		this.trigger('after.close', [this]);

		var $foregroundModal = $desktop.module('modal').byPosition(-1);

		if ($foregroundModal instanceof Object) {
			$foregroundModal.foreground();
		}

		return this;
	};

	/**
	 * Блокировка модального окна
	 *
	 * @return  this
	 */
	$modal.prototype.block = function()
	{
		this.trigger('before.block', [this]);

		$desktop.module('modal').trigger('before.block', [this]);

		this.element.classList.add('blocked');

		$desktop.module('modal').trigger('after.block', [this]);

		this.trigger('after.block', [this]);

		return this;
	};

	/**
	 * Разблокировка модального окна
	 *
	 * @return  this
	 */
	$modal.prototype.unblock = function()
	{
		this.trigger('before.unblock', [this]);

		$desktop.module('modal').trigger('before.unblock', [this]);

		this.element.classList.remove('blocked');

		$desktop.module('modal').trigger('after.unblock', [this]);

		this.trigger('after.unblock', [this]);

		return this;
	};

	/**
	 * Открыто ли модальное окно
	 *
	 * @return  Boolean
	 */
	$modal.prototype.running = function()
	{
		return !! document.body.contains(this.element);
	};

	/**
	 * Позиционирование модального окна
	 *
	 * @param   Number    width
	 * @param   Number    height
	 * @param   Boolean   percentage
	 *
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

				elements[index].$modal.trigger('backgrounded', [
					elements[index].$modal,
				], elements[index].$modal);

				$desktop.module('modal').trigger('backgrounded', [
					elements[index].$modal,
				], elements[index].$modal);
			}

			this.element.classList.add('state-foreground');
			this.element.classList.remove('state-background');
			this.element.style.zIndex = Math.max.apply(Math, zIndex) + 1;

			this.trigger('foregrounded', [this], this);

			$desktop.module('modal').trigger('foregrounded', [this], this);
		}
	};

	/**
	 * Модуль рабочего стола
	 *
	 * @return  void
	 */
	$module = function()
	{
		$events.apply(this, arguments);

		this.id = 0;
		this.modals = {};

		this.altPress = false;
		this.ctrlPress = false;
		this.shiftPress = false;

		(function(self)
		{
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
							// [ALT][SHIFT][E]
							case 69 :
								event.preventDefault();

								$foregroundModal.trigger('modalContentEdit', [$foregroundModal], $foregroundModal);
								$foregroundModal.trigger('modal.content.edit', [$foregroundModal], $foregroundModal);

								$desktop.module('modal').trigger('modalContentEdit', [$foregroundModal], $foregroundModal);
								$desktop.module('modal').trigger('modal.content.edit', [$foregroundModal], $foregroundModal);
								break;

							// [ALT][SHIFT][F]
							case 70 :
								event.preventDefault();

								$foregroundModal.trigger('modalContentFind', [$foregroundModal], $foregroundModal);
								$foregroundModal.trigger('modal.content.find', [$foregroundModal], $foregroundModal);

								$desktop.module('modal').trigger('modalContentFind', [$foregroundModal], $foregroundModal);
								$desktop.module('modal').trigger('modal.content.find', [$foregroundModal], $foregroundModal);
								break;

							// [ALT][SHIFT][N]
							case 78 :
								event.preventDefault();

								$foregroundModal.trigger('modalContentNew', [$foregroundModal], $foregroundModal);
								$foregroundModal.trigger('modal.content.new', [$foregroundModal], $foregroundModal);

								$desktop.module('modal').trigger('modalContentNew', [$foregroundModal], $foregroundModal);
								$desktop.module('modal').trigger('modal.content.new', [$foregroundModal], $foregroundModal);
								break;

							// [ALT][SHIFT][P]
							case 80 :
								event.preventDefault();

								$foregroundModal.trigger('modalContentPrint', [$foregroundModal], $foregroundModal);
								$foregroundModal.trigger('modal.content.print', [$foregroundModal], $foregroundModal);

								$desktop.module('modal').trigger('modalContentPrint', [$foregroundModal], $foregroundModal);
								$desktop.module('modal').trigger('modal.content.print', [$foregroundModal], $foregroundModal);
								break;

							// [ALT][SHIFT][R]
							case 82 :
								event.preventDefault();

								$foregroundModal.trigger('modalContentReload', [$foregroundModal], $foregroundModal);
								$foregroundModal.trigger('modal.content.reload', [$foregroundModal], $foregroundModal);

								$desktop.module('modal').trigger('modalContentReload', [$foregroundModal], $foregroundModal);
								$desktop.module('modal').trigger('modal.content.reload', [$foregroundModal], $foregroundModal);
								break;

							// [ALT][SHIFT][S]
							case 83 :
								event.preventDefault();

								$foregroundModal.trigger('modalContentSave', [$foregroundModal], $foregroundModal);
								$foregroundModal.trigger('modal.content.save', [$foregroundModal], $foregroundModal);

								$desktop.module('modal').trigger('modalContentSave', [$foregroundModal], $foregroundModal);
								$desktop.module('modal').trigger('modal.content.save', [$foregroundModal], $foregroundModal);
								break;

							// [ALT][SHIFT][W]
							case 87 :
								event.preventDefault();
								$foregroundModal.close();
								break;

							// [ALT][SHIFT][Z]
							case 90 :
								event.preventDefault();
								$foregroundModal.unblock();
								break;
						}
					}
				}
			});
		})(this);
	};

	/**
	 * Наследование логики событий
	 */
	$module.prototype = Object.create($events.prototype);

	/**
	 * Открытие модального окна (alias)
	 *
	 * @param   Object   params
	 *
	 * @return  Object
	 */
	$module.prototype.open = function(params)
	{
		var modal = this.create(params);

		modal.open();

		return modal;
	};

	/**
	 * Создание модального окна
	 *
	 * @param   Object   params
	 *
	 * @return  Object
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
		var headbtnminimize = document.createElement('button');

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
		headbtnminimize.classList.add('desktop-modal-on-minimize');

		headframe.appendChild(headicon);
		headframe.appendChild(headtitle);
		headframe.appendChild(headbtnclose);
		headframe.appendChild(headbtnmaximize);
		headframe.appendChild(headbtnminimize);

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

		/**
		 * Сворачивание модального окна
		 */
		headbtnminimize.addEventListener('click', function(event)
		{
			event.preventDefault();

			// @continue

			container.classList.add('state-minimize');
		});

		container.$modal = new $modal(
			++this.id, container, params
		);

		return container.$modal;
	};

	/**
	 * Получение экземпляра модального окна по его позиции
	 *
	 * @param   Number   position
	 *
	 * @return  Object
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
