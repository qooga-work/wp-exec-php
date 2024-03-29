<?php

require_once(dirname(__FILE__).'/const.php');

// -----------------------------------------------------------------------------
// the ExecPhp_UserMeta class handles the loading and storing of the
// plugin settings for each individual article including all needed conversion
// routines
// -----------------------------------------------------------------------------

if (!class_exists('ExecPhp_UserMeta')) :

define('ExecPhp_META_WYSIWYG_WARNING', 'execphp_wysiwyg_warning');

class ExecPhp_UserMeta
{
	var $m_user_id = -1;
	var $m_hide_wysiwyg_warning = false;

	// ---------------------------------------------------------------------------
	// init
	// ---------------------------------------------------------------------------

	function __construct($user_id)
	{
		$this->m_user_id = $user_id;
		$this->load();
	}

	function uninstall()
	{
		delete_user_meta($this->m_user_id, ExecPhp_META_WYSIWYG_WARNING);
		$user = new WP_User($this->m_user_id);
		$user->remove_cap(ExecPhp_CAPABILITY_EXECUTE_ARTICLES);
		$user->remove_cap(ExecPhp_CAPABILITY_EDIT_OTHERS_PHP);
	}

	function save()
	{
		update_user_meta($this->m_user_id, ExecPhp_META_WYSIWYG_WARNING,
			$this->m_hide_wysiwyg_warning);
	}

	function load()
	{
		if ($this->m_user_id > 0)
		{
			$this->m_hide_wysiwyg_warning =
				get_user_meta($this->m_user_id, ExecPhp_META_WYSIWYG_WARNING);
		}
	}

	// ---------------------------------------------------------------------------
	// access
	// ---------------------------------------------------------------------------

	function set_from_POST()
	{
		$this->m_hide_wysiwyg_warning
			= isset($_POST[ExecPhp_POST_WYSIWYG_WARNING]);
	}

	function hide_wysiwyg_warning()
	{
		return $this->m_hide_wysiwyg_warning;
	}
}
endif;

?>