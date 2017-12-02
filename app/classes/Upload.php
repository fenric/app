<?php

/**
 * Package
 */
namespace Fenric;

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
	 * Тип загружаемого файла
	 */
	protected $type;

	/**
	 * Конструктор класса
	 */
	public function __construct(string $blob)
	{
		$this->blob = $blob;

		$this->size = strlen($blob);

		$this->type = (
			new \finfo(FILEINFO_MIME_TYPE)
		)->buffer($blob);
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
	 * Получение типа загружаемого файла
	 */
	public function getType() : string
	{
		return $this->type;
	}

	/**
	 * Получение расширения загружаемого файла
	 */
	public function getExtension() : ?string
	{
		switch ($this->getType())
		{
			case 'image/gif' :
				return '.gif';
				break;

			case 'image/jpeg' :
				return '.jpeg';
				break;

			case 'image/png' :
				return '.png';
				break;

			case 'audio/mpeg' :
				return '.mp3';
				break;

			case 'video/mp4' :
				return '.mp4';
				break;

			case 'application/pdf' :
				return '.pdf';
				break;
		}

		return null;
	}

	/**
	 * Является ли загружаемый файл изображением
	 */
	public function isImage() : bool
	{
		$allow = ['image/gif', 'image/jpeg', 'image/png'];

		return in_array($this->getType(), $allow, true);
	}

	/**
	 * Является ли загружаемый файл аудиофайлом
	 */
	public function isAudio() : bool
	{
		$allow = ['audio/mpeg'];

		return in_array($this->getType(), $allow, true);
	}

	/**
	 * Является ли загружаемый файл видеофайлом
	 */
	public function isVideo() : bool
	{
		$allow = ['video/mp4'];

		return in_array($this->getType(), $allow, true);
	}

	/**
	 * Является ли загружаемый файл PDF документом
	 */
	public function isPdf() : bool
	{
		$allow = ['application/pdf'];

		return in_array($this->getType(), $allow, true);
	}

	/**
	 * Сохранение файла как изображения
	 *
	 * @throws  \RuntimeException
	 */
	public function asImage() : array
	{
		$file['filename'] = md5(uniqid($this->getBlob(), true));

		$file['basename'] = $file['filename'] . $this->getExtension();

		$file['location'] = self::path($file['basename']);

		if ($this->isImage())
		{
			$this->save($file['location']);

			return $file;
		}

		if ($this->isAudio())
		{
			$this->save($file['location']);

			$file['source'] = $file['location'];

			$file['location'] = $this->getCover($file['source']);

			return $file;
		}

		if ($this->isVideo())
		{
			$this->save($file['location']);

			$file['source'] = $file['location'];

			$file['location'] = $this->getCover($file['source']);

			return $file;
		}

		if ($this->isPdf())
		{
			$this->save($file['location']);

			$file['source'] = $file['location'];

			$file['location'] = $this->getCover($file['source']);

			return $file;
		}

		throw new \RuntimeException(sprintf('Загружаемый файл не поддерживается (%s).', $this->getType()), 400);
	}

	/**
	 * Сохранение файла как аудиофайла
	 *
	 * @throws  \RuntimeException
	 */
	public function asAudio() : array
	{
		$file['filename'] = md5(uniqid($this->getBlob(), true));

		$file['basename'] = $file['filename'] . $this->getExtension();

		$file['location'] = self::path($file['basename']);

		if ($this->isAudio())
		{
			$this->save($file['location']);

			$file['cover'] = $this->getCover($file['location']);

			return $file;
		}

		throw new \RuntimeException('Загружаемый файл не поддерживается.', 400);
	}

	/**
	 * Сохранение файла как видеофайла
	 *
	 * @throws  \RuntimeException
	 */
	public function asVideo() : array
	{
		$file['filename'] = md5(uniqid($this->getBlob(), true));

		$file['basename'] = $file['filename'] . $this->getExtension();

		$file['location'] = self::path($file['basename']);

		if ($this->isVideo())
		{
			$this->save($file['location']);

			$file['cover'] = $this->getCover($file['location']);

			return $file;
		}

		throw new \RuntimeException('Загружаемый файл не поддерживается.', 400);
	}

	/**
	 * Сохранение файла как PDF документа
	 *
	 * @throws  RuntimeException
	 */
	public function asPdf() : array
	{
		$file['filename'] = md5(uniqid($this->getBlob(), true));

		$file['basename'] = $file['filename'] . $this->getExtension();

		$file['location'] = self::path($file['basename']);

		if ($this->isPdf())
		{
			$this->save($file['location']);

			$file['cover'] = $this->getCover($file['location']);

			return $file;
		}

		throw new \RuntimeException('Загружаемый файл не поддерживается.', 400);
	}

	/**
	 * Получение обложки из медиафайла
	 *
	 * @throws  \RuntimeException
	 */
	protected function getCover(string $source) : string
	{
		$folder = pathinfo($source, PATHINFO_DIRNAME);

		$filename = pathinfo($source, PATHINFO_FILENAME);

		$target = $folder . DIRECTORY_SEPARATOR . $filename . '.png';

		if ($this->isAudio())
		{
			if (fenric('config::environments')->exists('ffmpeg'))
			{
				if (is_file(fenric('config::environments')->get('ffmpeg')))
				{
					if (is_executable(fenric('config::environments')->get('ffmpeg')))
					{
						$cmd = fenric('config::environments')->get('ffmpeg');

						exec(sprintf('%s -i "%s" "%s"', $cmd, $source, $target));
					}
				}
			}
		}

		if ($this->isVideo())
		{
			if (fenric('config::environments')->exists('ffmpegthumbnailer'))
			{
				if (is_file(fenric('config::environments')->get('ffmpegthumbnailer')))
				{
					if (is_executable(fenric('config::environments')->get('ffmpegthumbnailer')))
					{
						$cmd = fenric('config::environments')->get('ffmpegthumbnailer');

						exec(sprintf('%s -i "%s" -o "%s" -s 0 -t 15 -q 10', $cmd, $source, $target));
					}
				}
			}
		}

		if ($this->isPdf())
		{
			if (fenric('config::environments')->exists('imagemagick'))
			{
				if (is_file(fenric('config::environments')->get('imagemagick')))
				{
					if (is_executable(fenric('config::environments')->get('imagemagick')))
					{
						$cmd = fenric('config::environments')->get('imagemagick');

						exec(sprintf('%s -density 300 "%s[0]" "%s"', $cmd, $source, $target));
					}
				}
			}
		}

		if (is_file($target))
		{
			if (is_readable($target))
			{
				return $target;
			}
		}

		throw new \RuntimeException('Не удалось извлечь обложку из медиафайла.', 503);
	}

	/**
	 * Сохранение файла на диске
	 *
	 * @throws  \RuntimeException
	 */
	public function save(string $target) : bool
	{
		$folder = pathinfo($target, PATHINFO_DIRNAME);

		if (is_dir($folder) || mkdir($folder, 0755, true))
		{
			if (file_put_contents($target, $this->getBlob(), LOCK_EX))
			{
				return true;
			}
		}

		throw new \RuntimeException('Не удалось сохранить файл на диске.', 503);
	}

	/**
	 * Получение абсолютного пути загруженного файла
	 */
	public static function path(string $basename) : string
	{
		return fenric()->path('upload',
			substr($basename, 0, 2),
			substr($basename, 2, 2),
			substr($basename, 4, 2),
			$basename
		);
	}
}
