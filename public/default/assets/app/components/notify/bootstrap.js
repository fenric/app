'use strict';

var $notify;

/**
 * @description
 */
$notify = function(callback)
{
	this.NOTIFY_CLASS_NAME = 'fenric-notify';
	this.CONTAINER_CLASS_NAME = 'fenric-notify-container';

	this.TYPE_INFO = 'fenric-notify-info';
	this.TYPE_SUCCESS = 'fenric-notify-success';
	this.TYPE_WARNING = 'fenric-notify-warning';
	this.TYPE_ERROR = 'fenric-notify-error';

	this.POSITION_TOP_RIGHT = 'top-right';
	this.POSITION_RIGHT_BOTTOM = 'right-bottom';
	this.POSITION_BOTTOM_LEFT = 'bottom-left';
	this.POSITION_LEFT_TOP = 'left-top';

	this.POSITION_TOP_RIGHT_CLASS_NAME = 'fenric-notify-container-' + this.POSITION_TOP_RIGHT;
	this.POSITION_RIGHT_BOTTOM_CLASS_NAME = 'fenric-notify-container-' + this.POSITION_RIGHT_BOTTOM;
	this.POSITION_BOTTOM_LEFT_CLASS_NAME = 'fenric-notify-container-' + this.POSITION_BOTTOM_LEFT;
	this.POSITION_LEFT_TOP_CLASS_NAME = 'fenric-notify-container-' + this.POSITION_LEFT_TOP;

	this.views = {};
	this.views.notify = '/assets/app/components/notify/views/notify.tpl';

	this.type = this.TYPE_INFO;
	this.position = this.POSITION_TOP_RIGHT;
	this.lifetime = 5000;

	this.icon = null;
	this.title = null;
	this.message = null;
	this.messageHtml = false;

	this.timer = null;
	this.element = null;
	this.containers = {};
	this.eventsListeners = {};

	this.init();

	if (callback instanceof Function)
	{
		callback.call(this, this);
	}
};

/**
 * @description
 */
$notify.prototype.setType = function(value)
{
	this.type = value;

	return this;
};

/**
 * @description
 */
$notify.prototype.getType = function()
{
	return this.type;
};

/**
 * @description
 */
$notify.prototype.setPosition = function(value)
{
	this.position = value;

	return this;
};

/**
 * @description
 */
$notify.prototype.getPosition = function()
{
	return this.position;
};

/**
 * @description
 */
$notify.prototype.setLifetime = function(value)
{
	this.lifetime = value;

	return this;
};

/**
 * @description
 */
$notify.prototype.getLifetime = function()
{
	return this.lifetime;
};

/**
 * @description
 */
$notify.prototype.setIcon = function(value)
{
	this.icon = value;

	return this;
};

/**
 * @description
 */
$notify.prototype.getIcon = function()
{
	return this.icon;
};

/**
 * @description
 */
$notify.prototype.setTitle = function(value)
{
	this.title = value;

	return this;
};

/**
 * @description
 */
$notify.prototype.getTitle = function()
{
	return this.title;
};

/**
 * @description
 */
$notify.prototype.setMessage = function(value, isHtml)
{
	this.message = value;

	this.htmlMessage(isHtml);

	return this;
};

/**
 * @description
 */
$notify.prototype.htmlMessage = function(value)
{
	this.messageHtml = !! value;

	return this;
};

/**
 * @description
 */
$notify.prototype.isHtmlMessage = function()
{
	return !! this.messageHtml;
};

/**
 * @description
 */
$notify.prototype.getMessage = function()
{
	return this.message;
};

/**
 * @description
 */
$notify.prototype.getTimer = function()
{
	return this.timer;
};

/**
 * @description
 */
$notify.prototype.getElement = function()
{
	return this.element;
};

/**
 * @description
 */
$notify.prototype.getContainer = function()
{
	return this.containers[this.getPosition()];
};

/**
 * @description
 */
$notify.prototype.onDisplay = function(eventListener)
{
	if (eventListener instanceof Function)
	{
		if (this.eventsListeners.onDisplay === undefined)
		{
			this.eventsListeners.onDisplay = new Array();
		}

		this.eventsListeners.onDisplay.push(eventListener);
	}
};

/**
 * @description
 */
$notify.prototype.triggerDisplay = function()
{
	var i;

	if (this.eventsListeners.onDisplay instanceof Array)
	{
		for (i in this.eventsListeners.onDisplay)
		{
			this.eventsListeners.onDisplay[i].apply(this, arguments);
		}
	}
};

/**
 * @description
 */
$notify.prototype.onClick = function(eventListener)
{
	if (eventListener instanceof Function)
	{
		if (this.eventsListeners.onClick === undefined)
		{
			this.eventsListeners.onClick = new Array();
		}

		this.eventsListeners.onClick.push(eventListener);
	}
};

/**
 * @description
 */
$notify.prototype.triggerClick = function()
{
	var i;

	if (this.eventsListeners.onClick instanceof Array)
	{
		for (i in this.eventsListeners.onClick)
		{
			this.eventsListeners.onClick[i].apply(this, arguments);
		}
	}
};

/**
 * @description
 */
$notify.prototype.onHover = function(eventListener)
{
	if (eventListener instanceof Function)
	{
		if (this.eventsListeners.onHover === undefined)
		{
			this.eventsListeners.onHover = new Array();
		}

		this.eventsListeners.onHover.push(eventListener);
	}
};

/**
 * @description
 */
$notify.prototype.triggerHover = function()
{
	var i;

	if (this.eventsListeners.onHover instanceof Array)
	{
		for (i in this.eventsListeners.onHover)
		{
			this.eventsListeners.onHover[i].apply(this, arguments);
		}
	}
};

/**
 * @description
 */
$notify.prototype.onClose = function(eventListener)
{
	if (eventListener instanceof Function)
	{
		if (this.eventsListeners.onClose === undefined)
		{
			this.eventsListeners.onClose = new Array();
		}

		this.eventsListeners.onClose.push(eventListener);
	}
};

/**
 * @description
 */
$notify.prototype.triggerClose = function()
{
	var i;

	if (this.eventsListeners.onClose instanceof Array)
	{
		for (i in this.eventsListeners.onClose)
		{
			this.eventsListeners.onClose[i].apply(this, arguments);
		}
	}
};

/**
 * @description
 */
$notify.prototype.display = function()
{
	this.with(function(self)
	{
		self.view(self.views.notify, function(view)
		{
			self.element = document.createElement('div');
			self.element.classList.add(self.NOTIFY_CLASS_NAME);
			self.element.classList.add(self.getType());

			self.element.appendChild(view.format({
				icon: self.getIcon(),
				title: self.getTitle(),
				message: self.getMessage(),
				messageHtml: self.isHtmlMessage(),
			}));

			switch (self.getPosition())
			{
				case self.POSITION_TOP_RIGHT :
				case self.POSITION_LEFT_TOP :
					self.getContainer().insertBefore(
						self.element, self.getContainer().firstChild
					);
					break;

				case self.POSITION_RIGHT_BOTTOM :
				case self.POSITION_BOTTOM_LEFT :
					self.getContainer().appendChild(self.element);
					break;
			}

			if (self.getContainer().querySelector('a.fenric-notify-close') instanceof Node)
			{
				self.getContainer().querySelector('a.fenric-notify-close').addEventListener('click', function(event)
				{
					if (self.getTimer() !== void(0))
					{
						self.getTimer().break();
					}

					self.close();
				});
			}

			self.triggerDisplay();

			self.element.addEventListener('click', function(event)
			{
				self.triggerClick(event);
			});

			if (self.getLifetime() > 0)
			{
				self.timer = new $timer(self.getLifetime(), function()
				{
					self.close();
				});

				self.element.addEventListener('mouseover', function(event)
				{
					self.getTimer().pause();

					self.triggerHover(event);
				});

				self.element.addEventListener('mouseout', function(event)
				{
					self.getTimer().continue();
				});
			}
		});
	});
};

/**
 * @description
 */
$notify.prototype.close = function()
{
	if (this.getElement() instanceof Node)
	{
		if (this.getContainer() instanceof Node)
		{
			this.getContainer().removeChild(
				this.getElement()
			);

			this.triggerClose();
		}
	}
};

/**
 * @description
 */
$notify.prototype.init = function()
{
	if (! document.querySelector('div.' + this.POSITION_TOP_RIGHT_CLASS_NAME))
	{
		this.containers[this.POSITION_TOP_RIGHT] = document.createElement('div');

		this.containers[this.POSITION_TOP_RIGHT].classList.add(this.CONTAINER_CLASS_NAME);
		this.containers[this.POSITION_TOP_RIGHT].classList.add(this.POSITION_TOP_RIGHT_CLASS_NAME);

		document.body.appendChild(this.containers[this.POSITION_TOP_RIGHT]);
	}

	if (! document.querySelector('div.' + this.POSITION_RIGHT_BOTTOM_CLASS_NAME))
	{
		this.containers[this.POSITION_RIGHT_BOTTOM] = document.createElement('div');

		this.containers[this.POSITION_RIGHT_BOTTOM].classList.add(this.CONTAINER_CLASS_NAME);
		this.containers[this.POSITION_RIGHT_BOTTOM].classList.add(this.POSITION_RIGHT_BOTTOM_CLASS_NAME);

		document.body.appendChild(this.containers[this.POSITION_RIGHT_BOTTOM]);
	}

	if (! document.querySelector('div.' + this.POSITION_BOTTOM_LEFT_CLASS_NAME))
	{
		this.containers[this.POSITION_BOTTOM_LEFT] = document.createElement('div');

		this.containers[this.POSITION_BOTTOM_LEFT].classList.add(this.CONTAINER_CLASS_NAME);
		this.containers[this.POSITION_BOTTOM_LEFT].classList.add(this.POSITION_BOTTOM_LEFT_CLASS_NAME);

		document.body.appendChild(this.containers[this.POSITION_BOTTOM_LEFT]);
	}

	if (! document.querySelector('div.' + this.POSITION_LEFT_TOP_CLASS_NAME))
	{
		this.containers[this.POSITION_LEFT_TOP] = document.createElement('div');

		this.containers[this.POSITION_LEFT_TOP].classList.add(this.CONTAINER_CLASS_NAME);
		this.containers[this.POSITION_LEFT_TOP].classList.add(this.POSITION_LEFT_TOP_CLASS_NAME);

		document.body.appendChild(this.containers[this.POSITION_LEFT_TOP]);
	}

	this.containers[this.POSITION_TOP_RIGHT] = document
		.querySelector('div.' + this.POSITION_TOP_RIGHT_CLASS_NAME);

	this.containers[this.POSITION_RIGHT_BOTTOM] = document
		.querySelector('div.' + this.POSITION_RIGHT_BOTTOM_CLASS_NAME);

	this.containers[this.POSITION_BOTTOM_LEFT] = document
		.querySelector('div.' + this.POSITION_BOTTOM_LEFT_CLASS_NAME);

	this.containers[this.POSITION_LEFT_TOP] = document
		.querySelector('div.' + this.POSITION_LEFT_TOP_CLASS_NAME);
};

/**
 * @description
 */
$notify.prototype.view = function(file, complete)
{
	$bugaboo.load(file, complete);
};

/**
 * @description
 */
$notify.prototype.with = function(callback)
{
	if (callback instanceof Function)
	{
		callback.call(this, this);
	}
};
