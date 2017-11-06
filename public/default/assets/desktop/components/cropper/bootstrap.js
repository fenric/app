'use strict';

(function(jQuery)
{
	var $component;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{
		this.title = 'Фоторедактор';
		this.favicon = 'magic';
	};

	/**
	 * Редактирование фотографии
	 */
	$component.prototype.edit = function(photo, complete)
	{
		if (! photo) {
			return;
		}

		var modal, cropper;

		this.with(function(self)
		{
			modal = self.modal(Math.random());

			modal.title(self.title).open().block();

			self.view('cropper', function(view)
			{
				modal.content(view.format({
					photo: photo,
				})).unblock();

				modal.find('.photo', function(element)
				{
					element.addEventListener('ready', function()
					{
						modal.replace('.photo-size', document.createTextNode([
							Math.ceil(cropper.getData().width),
							Math.ceil(cropper.getData().height)
						].join('x')));

						modal.click('.cropper-command', function(event, element)
						{
							switch (element.getAttribute('data-command'))
							{
								case 'drag-mode' :
									cropper.setDragMode(
										element.getAttribute('data-value')
									);
									break;

								case 'zoom' :
									cropper.zoom(element.getAttribute('data-value'));
									break;

								case 'move-x' :
									cropper.move(element.getAttribute('data-value'), 0);
									break;

								case 'move-y' :
									cropper.move(0, element.getAttribute('data-value'));
									break;

								case 'scale-x' :
									cropper.scaleX(0 - (cropper.getData().scaleX || 1));
									break;

								case 'scale-y' :
									cropper.scaleY(0 - (cropper.getData().scaleY || 1));
									break;

								case 'rotate' :
									cropper.rotate(element.getAttribute('data-value'));
									break;

								case 'aspect-ratio' :
									cropper.crop();
									cropper.setAspectRatio(eval(
										element.getAttribute('data-value')
									));
									break;

								case 'aspect-ratio-off' :
									cropper.clear();
									cropper.setAspectRatio(NaN);
									break;

								case 'reset' :
									cropper.clear();
									cropper.reset();
									break;

								case 'save' :
									self.save(modal, cropper, complete);
									break;
							}
						});

						modal.on('modal.content.save', function() {
							self.save(modal, cropper, complete);
						});

						modal.on('modal.content.reload', function() {
							cropper.clear();
							cropper.reset();
						});
					});

					element.addEventListener('crop', function()
					{
						modal.replace('.photo-size', document.createTextNode([
							Math.ceil(cropper.getData().width),
							Math.ceil(cropper.getData().height)
						].join('x')));
					});

					cropper = new Cropper(element, {
						viewMode: 1,
						autoCrop: false,
					});

					modal.onclosing(function() {
						cropper.destroy();
					});
				});
			});
		});
	};

	/**
	 * Сохранение фотографии
	 */
	$component.prototype.save = function(modal, cropper, complete)
	{
		this.with(function(self)
		{
			modal.block();

			cropper.getCroppedCanvas().toBlob(function(blob)
			{
				$desktop.component('uploader').image(blob, function(response)
				{
					modal.close();

					if (complete instanceof Function)
					{
						if (complete.call(this, response) === false)
						{
							return;
						}
					}

					self.edit('/upload/' + response.file);

				}).complete(function()
				{
					modal.unblock();
				});
			});
		});
	};

	/**
	 * Помощь в работе с компонентом
	 */
	$component.prototype.help = function()
	{};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('cropper', $component);

})(window['jQuery']);
