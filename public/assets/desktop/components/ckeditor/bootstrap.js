'use strict';

(function(CKEDITOR)
{
	var $component, $ckeditor;

	/**
	 * Конструктор компонента
	 */
	$component = function()
	{};

	/**
	 * Конструктор редактора
	 */
	$ckeditor = function(area)
	{
		$desktop.component('ckeditor').with(function(self)
		{
			CKEDITOR.replace(area);

			area.ckeditor = CKEDITOR.instances[area.getAttribute('name')];

			area.ckeditor.on('instanceReady', function(event)
			{
				area.ckeditor.contextMenu.addListener(function(element, selection)
				{
					return {cropping : CKEDITOR.TRISTATE_OFF};
				});

				area.ckeditor.addMenuItems({cropping : {
					group : 'image',
					label : 'Редактировать изображение',
					command : 'cropping',
					order : 10,
				}});
			});

			area.ckeditor.ui.addButton('btn-upload-image', {
				icon: self.root + '/res/icons/image@16.png',
				label: 'Загрузить изображение',
				command: 'cmd-upload-image',
			});

			area.ckeditor.ui.addButton('btn-upload-pdf', {
				icon: self.root + '/res/icons/pdf@16.png',
				label: 'Загрузить PDF документ',
				command: 'cmd-upload-pdf',
			});

			area.ckeditor.addCommand('cropping', {exec: function(editor)
			{
				if (editor.getSelection())
				{
					if (editor.getSelection().getSelectedElement())
					{
						if (editor.getSelection().getSelectedElement().is('img'))
						{
							var source = editor.getSelection().getSelectedElement().getAttribute('src');

							if (editor.getSelection().getSelectedElement().hasAttribute('data-original'))
							{
								source = editor.getSelection().getSelectedElement().getAttribute('data-original');
							}

							$desktop.component('cropper').edit(source, function(response)
							{
								editor.getSelection().getSelectedElement().setAttribute('src', '/upload/' + response.file);
								editor.getSelection().getSelectedElement().removeAttribute('data-original');

								return false;
							});
						}
					}
				}
			}});

			area.ckeditor.addCommand('cmd-upload-image', {exec: function(editor)
			{
				var width, height, resolution, linkable, files, i, html;

				var modal = $desktop.module('modal').create({
					icon: 'upload', title: 'Загрузка изображений',
				}).open(400, 400).block();

				$bugaboo.load(self.root + '/views/upload-image.tpl', function(tpl)
				{
					modal.unblock().content(tpl.format()).submit(function(event, form, params)
					{
						modal.block();

						width = Math.abs(params.get('width')) || 0;
						height = Math.abs(params.get('height')) || 0;

						resolution = (width + height) > 0 ? (width + 'x' + height) : null;

						linkable = form.querySelector('input[name=linkable]').checked ? true : false;

						files = form.querySelector('input[name=files]').files;

						if (files.length > 0)
						{
							for (i = 0; i < files.length; i++)
							{
								$desktop.module('request').put('/user/api/upload-image/', files[i], {repeat: true, success: function(response)
								{
									html = '<img src="/upload' + (resolution ? ('/' + resolution + '/') : '/') + response.file + '" data-original="/upload/' + response.file + '" />';

									if (linkable) {
										html = '<a data-fancybox="group" href="/upload/' + response.file + '">' + html + '</a>';
									}

									editor.insertElement(CKEDITOR.dom.element.createFromHtml(html));
									modal.close();

								}}).complete(function() {
									modal.unblock();
								});
							}
						}
					});
				});
			}});

			area.ckeditor.addCommand('cmd-upload-pdf', {exec: function(editor)
			{
				var width, height, resolution, files, html;

				var modal = $desktop.module('modal').create({
					icon: 'upload', title: 'Загрузка PDF файла',
				}).open(400, 400).block();

				$bugaboo.load(self.root + '/views/upload-pdf.tpl', function(tpl)
				{
					modal.unblock().content(tpl.format()).submit(function(event, form, params)
					{
						modal.block();

						width = Math.abs(params.get('width')) || 0;
						height = Math.abs(params.get('height')) || 0;

						resolution = (width + height) > 0 ? (width + 'x' + height) : null;

						files = form.querySelector('input[name=files]').files;

						if (files instanceof FileList)
						{
							if (files.length > 0)
							{
								$desktop.module('request').put('/user/api/upload-pdf/', files[0], {repeat: true, success: function(response)
								{
									html = '<img src="/upload' + (resolution ? ('/' + resolution + '/') : '/') + response.cover + '" />';
									html = '<a href="/upload/' + response.file + '" target="_blank">' + html + '</a>';

									editor.insertElement(CKEDITOR.dom.element.createFromHtml(html));
									modal.close();

								}}).complete(function() {
									modal.unblock();
								});
							}
						}
					});
				});
			}});

			area.form.addEventListener('submit', function(event)
			{
				area.value = area.ckeditor.getData();
			});
		});

		return area.ckeditor;
	};

	/**
	 * Инициализация редактора
	 */
	$component.prototype.init = function(area)
	{
		return new $ckeditor(area);
	};

	/**
	 * Регистрация компонента на рабочем столе
	 */
	$desktop.regcom('ckeditor', $component);

})(window['CKEDITOR']);
