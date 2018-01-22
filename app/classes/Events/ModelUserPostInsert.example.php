<?php

namespace Fenric\Events;

class ModelUserPostInsert
{
	public function __invoke($model)
	{
		if ($model->isRegistrationConfirmed())
		{
			return;
		}

		$url = sprintf('%s%s/user/registration/%s/',
			fenric('request')->origin(),
			fenric('request')->root(),
			$model->getRegistrationConfirmationCode()
		);

		$mail = fenric('mail');

		$mail->addAddress($model->getEmail());

		$mail->Subject = __('user', 'email.registration.subject', [
			'host' => fenric('request')->host(),
		]);

		$mail->Body = fenric('view::mails/user.registration.confirmation')->render([
			'url' => $url,
			'user' => $model
		]);

		$mail->send();
	}
}
