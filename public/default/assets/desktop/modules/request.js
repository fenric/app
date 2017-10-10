'use strict';

(function()
{
	var $module = function()
	{
		this.params = {};

		this.registeredRepeatRequest = null;
	};

	$module.prototype.runRepeatRequest = function()
	{
		if (this.registeredRepeatRequest instanceof Function)
		{
			this.registeredRepeatRequest.call(this);
		}
	};

	$module.prototype.registerRepeatRequest = function(repeatRequest)
	{
		if (repeatRequest instanceof Function)
		{
			this.registeredRepeatRequest = repeatRequest;
		}
	};

	$module.prototype.onload = function(callback)
	{
		this.params.onload = callback;
	};

	$module.prototype.onerror = function(callback)
	{
		this.params.onerror = callback;
	};

	$module.prototype.onabort = function(callback)
	{
		this.params.onabort = callback;
	};

	$module.prototype.onprogress = function(callback)
	{
		this.params.onprogress = callback;
	};

	$module.prototype.get = function(uri, params)
	{
		params = params || {};

		if (params.repeat)
		{
			this.registerRepeatRequest(function()
			{
				this.get(uri, params);
			});
		}

		var req = this.open('GET', uri, params);

		req.send();

		return req;
	};

	$module.prototype.post = function(uri, data, params)
	{
		params = params || {};

		if (params.repeat)
		{
			this.registerRepeatRequest(function()
			{
				this.post(uri, data, params);
			});
		}

		var req = this.open('POST', uri, params);

		if (Object.prototype.toString.call(data).localeCompare('[object Object]') === 0)
		{
			data = $desktop.module('params').create(data).toSerialize();
		}
		else if (Object.prototype.toString.call(data).localeCompare('[object HTMLFormElement]') === 0)
		{
			data = $desktop.module('params').create(data).toSerialize();
		}

		req.send(data);

		return req;
	};

	$module.prototype.patch = function(uri, data, params)
	{
		params = params || {};

		if (params.repeat)
		{
			this.registerRepeatRequest(function()
			{
				this.patch(uri, data, params);
			});
		}

		var req = this.open('PATCH', uri, params);

		if (Object.prototype.toString.call(data).localeCompare('[object Object]') === 0)
		{
			data = $desktop.module('params').create(data).toSerialize();
		}
		else if (Object.prototype.toString.call(data).localeCompare('[object HTMLFormElement]') === 0)
		{
			data = $desktop.module('params').create(data).toSerialize();
		}

		req.send(data);

		return req;
	};

	$module.prototype.delete = function(uri, params)
	{
		params = params || {};

		if (params.repeat)
		{
			this.registerRepeatRequest(function()
			{
				this.delete(uri, params);
			});
		}

		var req = this.open('DELETE', uri, params);

		req.send();

		return req;
	};

	$module.prototype.put = function(uri, data, params)
	{
		params = params || {};

		if (params.repeat)
		{
			this.registerRepeatRequest(function()
			{
				this.put(uri, data, params);
			});
		}

		var req = this.open('PUT', uri, params);

		req.send(data);

		return req;
	};

	$module.prototype.open = function(verb, uri, params)
	{
		var self = this;

		var request = new XMLHttpRequest();

		request.open(verb, this.prepareURI(uri, params));

		request.setRequestHeader('Accept', 'application/json');

		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

		request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

		request.onload = function(event)
		{
			this.uri = uri;

			this.verb = verb;

			var response = this.responseText;

			var contenttype = this.getResponseHeader('Content-Type');

			switch (contenttype.split(';').shift())
			{
				case 'application/xml' :
					response = this.responseXML;
					break;

				case 'application/json' :
					response = JSON.parse(this.responseText || "null");
					break;
			}

			if (params.onload instanceof Function)
			{
				params.onload.call(this, response, event);
			}

			if (self.params.onload instanceof Function)
			{
				self.params.onload.call(this, response, event);
			}

			if (this.status >= 200 && this.status <= 299)
			{
				if (params.success instanceof Function)
				{
					params.success.call(this, response, event);
				}
			}

			if (this.status >= 300 && this.status <= 399)
			{
				if (params.redirect instanceof Function)
				{
					params.redirect.call(this, response, event);
				}
			}

			if (this.status >= 400 && this.status <= 499)
			{
				if (params.clienterror instanceof Function)
				{
					params.clienterror.call(this, response, event);
				}
			}

			if (this.status >= 500 && this.status <= 599)
			{
				if (params.servererror instanceof Function)
				{
					params.servererror.call(this, response, event);
				}
			}

			if (response instanceof Object)
			{
				if (response.success === true)
				{
					if (params.successful instanceof Function)
					{
						params.successful.call(this, response, event);
					}
				}

				if (response.success === false)
				{
					if (params.unsuccessful instanceof Function)
					{
						params.unsuccessful.call(this, response, event);
					}
				}
			}
		};

		request.onerror = function(event)
		{
			if (params.onerror instanceof Function)
			{
				params.onerror.call(this, event);
			}

			if (self.params.onerror instanceof Function)
			{
				self.params.onerror.call(this, event);
			}
		};

		request.onabort = function(event)
		{
			if (params.onabort instanceof Function)
			{
				params.onabort.call(this, event);
			}

			if (self.params.onabort instanceof Function)
			{
				self.params.onabort.call(this, event);
			}
		};

		request.onprogress = function(event)
		{
			if (params.onprogress instanceof Function)
			{
				params.onprogress.call(this, event);
			}

			if (self.params.onprogress instanceof Function)
			{
				self.params.onprogress.call(this, event);
			}
		};

		request.complete = function(callback)
		{
			params.onload = callback;

			return request;
		};

		request.success = function(callback)
		{
			params.success = callback;

			return request;
		};

		request.successful = function(callback)
		{
			params.successful = callback;

			return request;
		};

		request.unsuccessful = function(callback)
		{
			params.unsuccessful = callback;

			return request;
		};

		return request;
	};

	$module.prototype.prepareURI = function(uri, params)
	{
		params = params || {};

		params.root = window.location.pathname.replace(/\/$/, '') || '';

		uri = $desktop.interpolate(uri, params);

		uri += (uri.indexOf('?') < 0 ? '?' : '&') + Math.random();

		return uri;
	};

	$desktop.regmod('request', $module);
})();
