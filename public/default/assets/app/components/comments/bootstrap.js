'use strict';

var $comments;

/**
 * @description
 */
$comments = function(
	publicationId,
	formContainerQuerySelector,
	commentsContainerQuerySelector
) {
	this.views = {};
	this.views.form = '/assets/app/components/comments/views/form.tpl';
	this.views.comment = '/assets/app/components/comments/views/comment.tpl';

	this.routes = {};
	this.routes.all = '/api/comment/all/{id}/';
	this.routes.create = '/api/comment/create/';
	this.routes.update = '/api/comment/update/{id}/';
	this.routes.delete = '/api/comment/delete/{id}/';
	this.routes.read = '/api/comment/read/{id}/';

	this.defaultFormContainerQuerySelector = '.comments > .comments-form-container';
	this.defaultCommentsContainerQuerySelector = '.comments > .comments-container'

	this.publicationId = publicationId;

	this.formContainerQuerySelector = formContainerQuerySelector ||
		this.defaultFormContainerQuerySelector;

	this.commentsContainerQuerySelector = commentsContainerQuerySelector ||
		this.defaultCommentsContainerQuerySelector;

	this.formContainer = null;
	this.commentsContainer = null;

	this.init();
};

/**
 * @description
 */
$comments.prototype.init = function()
{
	this.formContainer = document.querySelector(
		this.formContainerQuerySelector
	);

	this.commentsContainer = document.querySelector(
		this.commentsContainerQuerySelector
	);

	if (! (this.formContainer instanceof Node))
	{
		throw new Error('The comments form is not found on the page.');
	}

	if (! (this.commentsContainer instanceof Node))
	{
		throw new Error('The comments container is not found on the page.');
	}

	this.with(function(self)
	{
		self.view(self.views.form, function(view)
		{
			self.purge(self.formContainer);

			self.formContainer.appendChild(view.format({
				user_id: $fenric.user.getId(),
				user_photo: $fenric.user.getPhoto(),
				publication_id: self.publicationId,
			}));

			self.search(self.formContainer, 'form', function(key, element)
			{
				self.formHandle(element);
			});

			self.load(function()
			{
				self.search(document, '.comments-reload', function(key, element)
				{
					element.addEventListener('click', function(event)
					{
						if (! element.classList.contains('locked'))
						{
							element.classList.add('locked');

							self.search(element, '.fa', function(key, icon)
							{
								icon.classList.add('fa-spin');
							});

							self.load(function()
							{
								self.search(element, '.fa', function(key, icon)
								{
									icon.classList.remove('fa-spin');
								});

								element.classList.remove('locked');
							});
						}
					});
				});
			});
		});
	});
};

/**
 * @description
 */
$comments.prototype.formHandle = function(form, id)
{
	this.with(function(self)
	{
		form.data = {};

		form.addEventListener('submit', function(event)
		{
			event.preventDefault();

			self.each(form.elements, function(key, element)
			{
				if (element.name.trim().length > 0)
				{
					if (element.value.trim().length > 0)
					{
						if (form.data[element.name.trim()] === undefined)
						{
							form.data[element.name.trim()] = element.value.trim();
						}
					}
				}
			});

			if (form.classList.contains('sending')) {
				return true;
			}
			if (form.data.content === undefined) {
				return false;
			}
			if (form.data.content.length === 0) {
				return false;
			}

			form.classList.add('sending');

			$request[id ? 'patch' : 'post'](self.routes[id ? 'update' : 'create'], form.data, {id: id, onload: function(response)
			{
				if (response.success)
				{
					self.load(function()
					{
						form.data = {};
						form.reset();

						self.search(form, '.comments-form-picture-preview > img', function(key, img)
						{
							img.parentNode.removeChild(img);
						});

						form.classList.remove('sending');
					});

					return true;
				}

				form.classList.remove('sending');

				self.each(response.errors, function(key, error)
				{
					new $notify(function(notify)
					{
						notify.setType(notify.TYPE_ERROR);
						notify.setPosition(notify.POSITION_TOP_RIGHT);
						notify.setMessage(error[0]);
						notify.display();
					});
				});
			}});
		});

		self.search(form, 'input[type="file"]', function(key, input)
		{
			input.addEventListener('change', function(event)
			{
				form.classList.add('sending');

				$request.put('/user/api/upload-image/', input.files[0], {onload: function(response)
				{
					form.classList.remove('sending');

					input.value = null;

					if (response instanceof Object)
					{
						if (response.file !== undefined)
						{
							form.data.picture = response.file;

							self.search(form, '.comments-form-picture-preview', function(key, container)
							{
								var img;

								img = document.createElement('img');
								img.src = '/upload/0x100/' + form.data.picture;
								img.classList.add('img-thumbnail');

								img.addEventListener('click', function(event)
								{
									container.removeChild(img);
									delete form.data.picture;
								});

								self.purge(container).appendChild(img);
							});
						}

						if (response.success === false)
						{
							if (response.message !== null)
							{
								new $notify(function(notify)
								{
									notify.setType(notify.TYPE_ERROR);
									notify.setPosition(notify.POSITION_TOP_RIGHT);
									notify.setMessage(response.message);
									notify.display();
								});
							}
						}
					}
				}})
			});
		});
	});
};

/**
 * @description
 */
$comments.prototype.load = function(complete)
{
	this.with(function(self)
	{
		self.view(self.views.comment, function(view)
		{
			$request.get(self.routes.all, {id: self.publicationId, success: function(response)
			{
				self.purge(self.commentsContainer);

				self.commentsContainer.appendChild(
					self.tree(view, response.items)
				);

				// Подсветка родителей...
				self.search(self.commentsContainer, 'li', function(key, element)
				{
					element.addEventListener('mouseover', function(event)
					{
						self.search(self.commentsContainer, 'ol[data-parent-id="' + this.getAttribute('data-parent-id') + '"]', function(key, element)
						{
							element.classList.add('hoverable');
						});
					});

					element.addEventListener('mouseout', function(event)
					{
						self.search(self.commentsContainer, 'ol[data-parent-id="' + this.getAttribute('data-parent-id') + '"]', function(key, element)
						{
							element.classList.remove('hoverable');
						});
					});
				});

				// Ответ на комментарий.
				self.search(self.commentsContainer, '.comment-action-reply', function(key, element)
				{
					element.addEventListener('click', function(event)
					{
						self.search(self.commentsContainer, '.comment-form-reply[data-id="' + element.getAttribute('data-id') + '"]', function(key, container)
						{
							self.view(self.views.form, function(view)
							{
								self.purge(container);

								container.appendChild(view.format({
									user_id: $fenric.user.getId(),
									user_photo: $fenric.user.getPhoto(),
									parent_id: element.getAttribute('data-id'),
									publication_id: self.publicationId,
									replyable: true,
								}));

								container.classList.remove('d-none');

								self.search(container, 'form', function(key, form)
								{
									self.formHandle(form);

									self.search(form, 'button[type="reset"]', function(key, button)
									{
										button.addEventListener('click', function(event)
										{
											container.classList.add('d-none');

											self.purge(container);
										});
									});
								});
							});
						});
					});
				});

				// Редактирование комментария.
				self.search(self.commentsContainer, '.comment-action-edit', function(key, element)
				{
					element.addEventListener('click', function(event)
					{
						$request.get(self.routes.read, {id: element.getAttribute('data-id'), success: function(comment)
						{
							self.search(self.commentsContainer, '.comment-form-edit[data-id="' + comment.id + '"]', function(key, container)
							{
								self.view(self.views.form, function(view)
								{
									self.purge(container);

									container.appendChild(view.format({
										user_id: $fenric.user.getId(),
										user_photo: $fenric.user.getPhoto(),
										picture: comment.picture,
										content: comment.content,
										editable: true,
									}));

									container.classList.remove('d-none');

									self.search(container, 'form', function(key, form)
									{
										self.formHandle(form, comment.id);

										self.search(form, 'button[type="reset"]', function(key, button)
										{
											button.addEventListener('click', function(event)
											{
												container.classList.add('d-none');

												self.purge(container);
											});
										});
									});
								});
							});
						}});
					});
				});

				// Удаление комментария.
				self.search(self.commentsContainer, '.comment-action-remove', function(key, element)
				{
					element.addEventListener('click', function(event)
					{
						$request.delete(self.routes.delete, {id: element.getAttribute('data-id'), success: function(response)
						{
							if (response.success)
							{
								self.load();

								return true;
							}

							self.each(response.errors, function(key, error)
							{
								new $notify(function(notify)
								{
									notify.setType(notify.TYPE_ERROR);
									notify.setPosition(notify.POSITION_TOP_RIGHT);
									notify.setMessage(error[0]);
									notify.display();
								});
							});
						}});
					});
				});

				if (complete instanceof Function)
				{
					complete.call(this, response);
				}
			}});
		});
	});
};

/**
 * @description
 */
$comments.prototype.tree = function(view, comments, parentId, depth)
{
	var ol, li;

	depth = depth || 1;

	ol = document.createElement('ol');
	ol.setAttribute('data-depth', depth);
	ol.setAttribute('data-parent-id', parentId);

	this.with(function(self)
	{
		self.each(comments, function(index, comment)
		{
			if (comment.parent_id === (parentId || null))
			{
				li = document.createElement('li');
				li.setAttribute('data-id', comment.id);
				li.setAttribute('data-parent-id', comment.parent_id);

				li.appendChild(view.format({
					user_id: $fenric.user.getId(),
					user_photo: $fenric.user.getPhoto(),
					user_is_administrator: $fenric.user.isAdministrator(),
					user_is_redactor: $fenric.user.isRedactor(),
					user_is_moderator: $fenric.user.isModerator(),
					user_is_user: $fenric.user.isUser(),
					comment: comment,
				}));

				if (comment.children > 0)
				{
					li.appendChild(self.tree(
						view, comments, comment.id, depth + 1
					));
				}

				ol.appendChild(li);
			}
		});
	});

	return ol;
};

/**
 * @description
 */
$comments.prototype.each = function(object, callback)
{
	var key;

	if (object instanceof NodeList)
	{
		object = Array.prototype.slice.call(object);
	}

	if (object instanceof HTMLFormControlsCollection)
	{
		object = Array.prototype.slice.call(object);
	}

	if (object instanceof Object)
	{
		if (callback instanceof Function)
		{
			for (key in object)
			{
				callback(key, object[key], object);
			}
		}
	}
};

/**
 * @description
 */
$comments.prototype.purge = function(element)
{
	while (element.firstChild)
	{
		element.removeChild(element.firstChild);
	}

	return element;
};

/**
 * @description
 */
$comments.prototype.search = function(element, querySelector, callback)
{
	this.each(element.querySelectorAll(querySelector), callback);
};

/**
 * @description
 */
$comments.prototype.view = function(file, complete)
{
	$bugaboo.load(file, complete);
};

/**
 * @description
 */
$comments.prototype.with = function(callback)
{
	if (callback instanceof Function)
	{
		callback.call(this, this);
	}
};
