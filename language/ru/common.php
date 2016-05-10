<?php
/**
 *
 * @package phpBB Extension - tas2580 AJAX Notifications
 * @copyright (c) 2016 tas2580 (https://tas2580.net)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_AJAXNOTIFICATION_TIMEOUT'				=> 'Задержка между AJAX-запросами новых уведомлений',
	'ACP_AJAXNOTIFICATION_TIMEOUT_EXPLAIN'		=> 'С какой частотой, в секундах, запрашивать новые уведомления. Обратите внимание, что слишком маленькая задержка увеличит нагрузку на сервер при большом количестве зарегистрированных пользователей онлайн.',
));
