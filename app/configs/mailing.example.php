<?php

/**
 * @link https://github.com/PHPMailer/PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/tree/master/examples
 */

$senders = [];

$senders['default'] = function() : void
{
	$this->setFrom('root@localhost', fenric('request')->host());
	$this->addReplyTo('root@localhost', fenric('request')->host());

	$this->isHTML(true);
};

return $senders;
