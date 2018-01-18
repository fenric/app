<?php

namespace Fenric\Events;

class ModelUserTokenCreate
{
	public function __invoke($model)
	{
		$url = sprintf('%s%s/user/login/%s/',
			fenric('request')->origin(),
			fenric('request')->root(),
			$model->getAuthenticationToken()
		);

		$mail = fenric('mail');

		$mail->addAddress($model->getEmail());

		$mail->Subject = __('user', 'email.authentication.token.subject', [
			'host' => fenric('request')->host(),
		]);

		$mail->Body = fenric('view::mails/user.authentication.token')->render([
			'url' => $url,
			'user' => $model,
		]);

		$mail->send();
	}
}
