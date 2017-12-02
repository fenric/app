<?php

$messages = [];

$messages['role.administrator.name']                              = 'Администратор';
$messages['role.redactor.name']                                   = 'Редактор';
$messages['role.moderator.name']                                  = 'Модератор';
$messages['role.user.name']                                       = 'Пользователь';

$messages['authentication.error.session.unstarted']               = 'Механизм сессий не запущен.';
$messages['authentication.error.username.incorrect']              = 'Имя учётной записи должно быть строкой длинной от {minLength} до {maxLength} символов и состоять только из букв английского алфавита и арабских цифр.';
$messages['authentication.error.password.incorrect']              = 'Пароль от учётной записи должен быть строкой длинной от {minLength} до {maxLength} символов.';
$messages['authentication.error.username.undefined']              = 'Учётная запись не найдена.';
$messages['authentication.error.unsuccessful.attempts']           = 'Похоже вашу учетную запись пытались взломать, в целях безопасности она была заблокирована. ';
$messages['authentication.error.unsuccessful.attempts']          .= 'Для того, чтобы разблокировать доступ к своей учетной записи, воспользуйтесь восстановлением доступа к ней.';
$messages['authentication.error.password.unverified']             = 'Неверный пароль от учётной записи.';
$messages['authentication.error.account.unverified']              = 'Ожидается подтверждение регистрации.';
$messages['authentication.error.account.blocked']                 = 'Учетная запись заблокирована до {until} по причине: {reason}.';
$messages['authentication.error.save']                            = 'Технический сбой.';

$messages['authentication.token.create.error.email.undefined']    = 'Не удалось идентифицировать учетную запись по электронному адресу.';
$messages['authentication.token.create.error.account.unverified'] = 'Учетная запись не активна, ожидается подтверждение регистрации.';
$messages['authentication.token.create.error.account.blocked']    = 'Учетная запись заблокирована, создание аутентификационного токена не возможно.';
$messages['authentication.token.create.error.save']               = 'Произошел технический сбой при создании аутентификационного токена.';

$messages['authentication.by.token.error.unknown.token']          = 'Не удалось идентифицировать аутентификационный токен.';
$messages['authentication.by.token.error.account.unverified']     = 'Учетная запись неактивна, ожидается подтверждение регистрации.';
$messages['authentication.by.token.error.account.blocked']        = 'Учетная запись заблокирована, аутентификация по токену невозможна.';
$messages['authentication.by.token.error.date.token']             = 'Аутентификационный токен устарел.';
$messages['authentication.by.token.error.ip.token']               = 'Аутентификационный токен привязан к другому IP адресу.';
$messages['authentication.by.token.error.save']                   = 'Произошел технический сбой при аутентификации по токену.';

$messages['registration.confirm.error.unknown.code']              = 'Код подтверждения регистрации недействительный или устарел.';
$messages['registration.confirm.error.save']                      = 'Произошел технический сбой при подтверждении регистрации.';
$messages['registration.confirm.success']                         = 'Регистрация успешно подтверждена, вы можете воспользоваться своими логином и паролем, чтобы пройти аутентификацию.';

$messages['registration.error.rules']                             = 'Вы должны согласиться с правилами сайта если хотите пройти регистрацию.';
$messages['registration.error.save']                              = 'Произошел технический сбой при создании учетной записи.';

$messages['validation.error.role.permission']                     = 'Нельзя менять роль самому себе.';
$messages['validation.error.role.unknown']                        = 'Неизвестная роль.';
$messages['validation.error.password.have.in.email']              = 'Нельзя использовать имя учетной записи электронной почты в пароли.';
$messages['validation.error.password.have.in.username']           = 'Нельзя использовать имя учетной записи в пароли.';
$messages['validation.error.password.comparison']                 = 'Пароли не совпадают.';
$messages['validation.error.gender.invalid']                      = 'Некорректная половая принадлежность.';
$messages['validation.error.firstname.length']                    = 'Максимально допустимая длина имени 64 символа.';
$messages['validation.error.firstname.characters']                = 'Имя должно состоять только из букв.';
$messages['validation.error.lastname.length']                     = 'Максимально допустимая длина фамилии 64 символа.';
$messages['validation.error.lastname.characters']                 = 'Фамилия должна состоять только из букв.';
$messages['validation.error.ban.permission']                      = 'Нельзя заблокировать свою учетную запись.';

$messages['email.registration.subject']                           = 'Регистрация на сайте {host}';
$messages['email.authentication.token.subject']                   = 'Аутентификационный токен для сайта {host}';

return $messages;
