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
									cropper.setAspectRatio(eval(
										element.getAttribute('data-value')
									));
									break;

								case 'reset' :
									cropper.reset();
									break;

								case 'save' :
									cropper.getCroppedCanvas().toBlob(function(blob)
									{
										modal.block();

										$desktop.component('uploader').image(blob, function(response)
										{
											modal.close();

											self.edit(response.file);

											if (complete instanceof Function) {
												complete.call(this, response);
											}

										}).complete(function()
										{
											modal.unblock();
										});
									});
									break;
							}
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
						autoCrop: true,
						autoCropArea: 0.8,
					});

					modal.onclosing(function() {
						cropper.destroy();
					});
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
