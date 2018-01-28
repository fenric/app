<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Update
 */
class Update extends Abstractable
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		set_time_limit(0);

		$content = '';

		if (is_executable(fenric('config::environments')->get('git'))) {
			$content .= $this->execute(fenric('/'), fenric('config::environments')->get('git') . ' pull https://github.com/fenric/cms.git stable');
			$content .= PHP_EOL . '--------------------' . PHP_EOL . PHP_EOL;
		}

		if (is_executable(fenric('config::environments')->get('git'))) {
			if (fenric('config::app')->exists('repository')) {
				$content .= $this->execute(fenric('/'), fenric('config::environments')->get('git') . ' pull ' . fenric('config::app')->get('repository') . ' ' . fenric('config::app')->get('branch', 'master'));
				$content .= PHP_EOL . '--------------------' . PHP_EOL . PHP_EOL;
			}
		}

		if (is_executable(fenric('config::environments')->get('composer'))) {
			$content .= $this->execute(fenric('/'), fenric('config::environments')->get('composer') . ' update');
			$content .= PHP_EOL . '--------------------' . PHP_EOL . PHP_EOL;
		}

		if (is_executable(fenric('config::environments')->get('php'))) {
			$content .= $this->execute(fenric('/vendor/bin'), fenric('config::environments')->get('php') . ' propel migrate');
			$content .= PHP_EOL . '--------------------' . PHP_EOL . PHP_EOL;
		}

		if (is_executable(fenric('config::environments')->get('bower'))) {
			$content .= $this->execute(fenric('/public'), fenric('config::environments')->get('bower') . ' update');
			$content .= PHP_EOL . '--------------------' . PHP_EOL . PHP_EOL;
		}

		$content .= 'Done.';

		$this->response->header('Content-Type', 'text/plain; charset=UTF-8');
		$this->response->content($content);
	}

	/**
	 * Выполнение команды
	 */
	protected function execute(string $folder, string $command) : string
	{
		$result = '$' . $command . PHP_EOL . PHP_EOL;

		$process = proc_open($command . ' 2>&1', [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipes, $folder);

		if (is_resource($process))
		{
			if (is_resource($pipes[1]))
			{
				$stdout = stream_get_contents($pipes[1]);

				if (strlen($stdout = trim($stdout)) > 0)
				{
					$result .= $stdout . PHP_EOL;
				}

				fclose($pipes[1]);
			}

			if (is_resource($pipes[2]))
			{
				$stderr = stream_get_contents($pipes[2]);

				if (strlen($stderr = trim($stderr)) > 0)
				{
					$result .= $stderr . PHP_EOL;
				}

				fclose($pipes[2]);
			}

			proc_close($process);
		}

		return $result;
	}
}
