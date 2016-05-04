<?php
/**
 *
 * @package phpBB Extension - tas2580 AJAX Notifications
 * @copyright (c) 2016 tas2580 (https://tas2580.net)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace tas2580\ajaxnotification\controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\Container;

class main
{
	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var Container */
	protected $phpbb_container;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\path_helper	$path_helper
	 * @param Container			$phpbb_container
	 * @param \phpbb\user			$user

	 */
	public function __construct(\phpbb\path_helper $path_helper, Container $phpbb_container, \phpbb\user $user)
	{
		$this->path_helper = $path_helper;
		$this->phpbb_container = $phpbb_container;
		$this->user = $user;
	}

	public function query()
	{
		$phpbb_notifications = $this->phpbb_container->get('notification_manager');
		$notifications = $phpbb_notifications->load_notifications(array(
			'user_id'		=> $this->user->data['user_id'],
			'all_unread'	=> true,
			'limit'			=> 5,
		));

		$result = array();
		foreach ($notifications['notifications'] as $notification)
		{
			$data = $notification->prepare_for_display();
			$data['U_MARK_READ'] = $this->path_helper->update_web_root_path($data['U_MARK_READ']);
			$data['URL'] = $this->path_helper->update_web_root_path($data['URL']);
			$data['L_MARK_READ'] = $this->user->lang['MARK_READ'];
			$result[] =$data;
		}

		return new JsonResponse($result);
	}
}
