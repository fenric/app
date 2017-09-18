<?php

function content(Closure $renderer) : string
{
	ob_start();

	$renderer();

	return ob_get_clean();
}

if ($requestPathname = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
{
	$regularExpression = '#^/upload/(0|\d{2,4})x(0|\d{2,4})/(([a-z0-9]{2})([a-z0-9]{2})([a-z0-9]{2})([a-z0-9]{26}))\.(jpe?g|png|gif)$#';

	if (preg_match($regularExpression, $requestPathname, $matches))
	{
		if (($matches[1] > 0 || 0 < $matches[2]) && $matches[1] >= 16 && $matches[2] <= 1200)
		{
			$absolutePathname = __DIR__ . preg_replace($regularExpression, '/$4/$5/$6/$3.$8', $requestPathname);
			$absoluteAliasname = __DIR__ . preg_replace($regularExpression, '/$4/$5/$6/$3.$1x$2.$8', $requestPathname);

			if (is_file($absolutePathname))
			{
				if (is_readable($absolutePathname))
				{
					if ($src = getimagesize($absolutePathname))
					{
						$src['width'] = $src[0];
						$src['height'] = $src[1];

						$dst['width'] = $matches[1];
						$dst['height'] = $matches[2];

						if (strcmp($dst['width'], '0') === 0) {
							$dst['width'] = $dst['height'] / ($src['height'] / $src['width']);
						}
						if (strcmp($dst['height'], '0') === 0) {
							$dst['height'] = $dst['width'] / ($src['width'] / $src['height']);
						}

						$src['x'] = 0;
						$src['y'] = 0;

						$crop['width'] = $src['height'] * ($dst['width'] / $dst['height']);
						$crop['height'] = $src['width'] * ($dst['height'] / $dst['width']);

						if ($crop['width'] < $src['width']) {
							$src['x'] = ($src['width'] - $crop['width']) / 2;
							$src['width'] = $crop['width'];
						}
						if ($crop['width'] > $src['width']) {
							$src['y'] = ($src['height'] - $crop['height']) / 2;
							$src['height'] = $crop['height'];
						}

						if ($img = imagecreatetruecolor($dst['width'], $dst['height']))
						{
							switch ($src[2])
							{
								case IMAGETYPE_JPEG :
									$res = imagecreatefromjpeg($absolutePathname);

									imagecopyresampled($img, $res, 0, 0, $src['x'], $src['y'], $dst['width'], $dst['height'], $src['width'], $src['height']);

									$content = content(function() use($img) {
										imagejpeg($img, null, 90);
									});

									$contentType = 'image/jpeg';
									break;

								case IMAGETYPE_PNG :
									imagesavealpha($img, true);
									imagealphablending($img, false);

									$res = imagecreatefrompng($absolutePathname);

									imagecopyresampled($img, $res, 0, 0, $src['x'], $src['y'], $dst['width'], $dst['height'], $src['width'], $src['height']);

									$content = content(function() use($img) {
										imagepng($img, null, 9);
									});

									$contentType = 'image/png';
									break;

								case IMAGETYPE_GIF :
									imagesavealpha($img, true);
									imagealphablending($img, false);

									$res = imagecreatefromgif($absolutePathname);

									imagecopyresampled($img, $res, 0, 0, $src['x'], $src['y'], $dst['width'], $dst['height'], $src['width'], $src['height']);

									$content = content(function() use($img) {
										imagegif($img, null);
									});

									$contentType = 'image/gif';
									break;
							}

							imagedestroy($res);
							imagedestroy($img);

							header(sprintf('Content-Type: %s', $contentType), true, 200);

							echo $content;

							if (function_exists('fastcgi_finish_request')) {
								fastcgi_finish_request();
							}

							file_put_contents($absoluteAliasname, $content, LOCK_EX);

							exit(0);
						}
					}

					http_response_code(503);
					exit(0);
				}
			}

			http_response_code(404);
			exit(0);
		}
	}
}

http_response_code(400);
exit(1);
