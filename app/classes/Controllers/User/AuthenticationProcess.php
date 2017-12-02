<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * AuthenticationProcess
 */
class AuthenticationProcess extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (fenric('config::user')->get('authentication.enabled', false)) {
			if (fenric('user')->isGuest()) {
				if (is_string($this->request->post->get('username'))) {
					if (is_string($this->request->post->get('password'))) {
						return true;
					}
				}
			}
		}

		$this->response->setStatus(400);
		return false;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		try
		{
			fenric('user')->signIn(
				$this->request->post->get('username'),
				$this->request->post->get('password')
			);

			fenric('logger::user.authentication.successful')->debug('[{ip}] [{username}]', [
				'ip' => $this->request->environment->get('REMOTE_ADDR', '127.0.0.1'),
				'username' => mb_substr($this->request->post->get('username'), 0, 48, 'UTF-8'),
			]);

			if ($this->request->isAjax()) {
				$this->response->setJsonContent([
					'success' => true,
				]);
				return;
			}

			$this->backward();
		}

		catch (\Throwable $error)
		{
			if (strlen(trim($this->request->post->get('username'))) > 0) {
				if (strlen(trim($this->request->post->get('password'))) > 0) {
					fenric('logger::user.authentication.unsuccessful')->debug('[{ip}] [{username}] {error}', [
						'ip' => $this->request->environment->get('REMOTE_ADDR', '127.0.0.1'),
						'username' => mb_substr(trim($this->request->post->get('username')), 0, 48, 'UTF-8'),
						'error' => $error->getMessage(),
					]);
				}
			}

			if ($this->request->isAjax()) {
				$this->response->setJsonContent([
					'success' => false,
					'message' => $error->getMessage(),
				]);
				return;
			}

			fenric('session')->set('user.authentication.error',
				$error->getMessage()
			);

			fenric('session')->set('user.authentication.username',
				$this->request->post->get('username')
			);

			$this->backward();
		}
	}
}
