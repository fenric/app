<?php

/**
 * Package
 */
namespace Fenric;

/**
 * Import classes
 */
use finfo;
use Imagick;
use RuntimeException;

/**
 * Upload
 */
class Upload
{

	/**
	 * Содержимое загружаемого файла
	 */
	protected $blob;

	/**
	 * Размер загружаемого файла
	 */
	protected $size;

	/**
	 * Конструктор класса
	 */
	public function __construct(string $blob)
	{
		$this->blob = $blob;

		$this->size = strlen($blob);
	}

	/**
	 * Получение содержимого загружаемого файла
	 */
	public function getBlob() : string
	{
		return $this->blob;
	}

	/**
	 * Получение размера загружаемого файла
	 */
	public function getSize() : int
	{
		return $this->size;
	}

	/**
	 * Загрузка файла как изображения
	 */
	public function asImage() : array
	{
		if ($this->getSize() > 0)
		{
			$info = new finfo(FILEINFO_MIME_TYPE);

			if ($mime = $info->buffer($this->getBlob()))
			{
				if (in_array($mime, ['image/gif', 'image/jpeg', 'image/png']))
				{
					$file['name'] = hash('md5', uniqid($this->getBlob(), true));

					$file['folder'] = fenric()->path('upload',
						substr($file['name'], 0, 2),
						substr($file['name'], 2, 2),
						substr($file['name'], 4, 2)
					);

					$file['extension'] = pathinfo($mime, PATHINFO_BASENAME);

					$file['location'] = "{$file['folder']}/{$file['name']}.{$file['extension']}";

					if (is_dir($file['folder']) || mkdir($file['folder'], 0755, true))
					{
						if (file_put_contents($file['location'], $this->getBlob(), LOCK_EX))
						{
							return $file;
						}
						else throw new RuntimeException('Не удалось сохранить изображение на диске.', 2);
					}
					else throw new RuntimeException('Не удалось создать директорию для загрузки изображения.', 2);
				}
				else throw new RuntimeException('Файл не является изображением (finfo).', 1);
			}
			else throw new RuntimeException('Не удалось прочитать файл (finfo).', 2);
		}
		else throw new RuntimeException('Файл пустой.', 1);
	}

	/**
	 * Загрузка файла как PDF документа
	 */
	public function asPDF() : array
	{
		if ($this->getSize() > 0)
		{
			$info = new finfo(FILEINFO_MIME_TYPE);

			if ($mime = $info->buffer($this->getBlob()))
			{
				if (in_array($mime, ['application/pdf']))
				{
					$file['name'] = hash('md5', uniqid($this->getBlob(), true));

					$file['folder'] = fenric()->path('upload',
						substr($file['name'], 0, 2),
						substr($file['name'], 2, 2),
						substr($file['name'], 4, 2)
					);

					$file['location'] = "{$file['folder']}/{$file['name']}.pdf";

					$file['cover'] = "{$file['folder']}/{$file['name']}.png";

					if (is_dir($file['folder']) || mkdir($file['folder'], 0755, true))
					{
						if (file_put_contents($file['location'], $this->getBlob(), LOCK_EX))
						{
							$imagick = new Imagick("{$file['location']}[0]");

							$imagick->setResolution(300, 300);
							$imagick->setImageFormat('png');

							if (file_put_contents($file['cover'], $imagick->getImageBlob(), LOCK_EX))
							{
								return $file;
							}
							else throw new RuntimeException('Не удалось сохранить обложку PDF документа на диске.', 2);
						}
						else throw new RuntimeException('Не удалось сохранить PDF документ на диске.', 2);
					}
					else throw new RuntimeException('Не удалось создать директорию для загрузки PDF документа.', 2);
				}
				else throw new RuntimeException('Файл не является PDF документом (finfo).', 1);
			}
			else throw new RuntimeException('Не удалось прочитать файл (finfo).', 2);
		}
		else throw new RuntimeException('Файл пустой.', 1);
	}

	/**
	 * Получение абсолютного пути загруженного файла
	 */
	public static function path(string $filename) : string
	{
		return fenric()->path('upload',
			substr($filename, 0, 2),
			substr($filename, 2, 2),
			substr($filename, 4, 2),
			$filename
		);
	}
}
