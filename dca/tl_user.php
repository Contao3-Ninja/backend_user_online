<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * 
 * Module Backend User Online
 * 
 * PHP version 5
 * @copyright  Glen Langer 2009..2012 
 * @author     Glen Langer 
 * @package    BackendUserOnline 
 * @license    LGPL 
 */


/**
 * DCA Config
 */
$GLOBALS['TL_DCA']['tl_user']['list']['label']['fields'] = array('icon', 'name', 'username', 'dateAdded', 'currentLogin');
//unset($GLOBALS['TL_DCA']['tl_user']['fields']['lastLogin']);
$GLOBALS['TL_DCA']['tl_user']['fields']['currentLogin'] = array
(
    'label'   => &$GLOBALS['TL_LANG']['MSC']['tl_user_onlineicon']['lastlogin'],
    'sorting' => true,
    'flag'    => 6,
    'eval'    => array('rgxp'=>'datim')
);
$GLOBALS['TL_DCA']['tl_user']['list']['label']['label_callback'] = array('tl_user_onlineicon','addIcon');

/**
 * Class tl_user_onlineicon 
 *
 * @copyright  Glen Langer 2009..2012
 * @author     Glen Langer 
 * @package    BackendUserOnline
 */
class tl_user_onlineicon extends Backend
{
	
    /**
	 * Add an image to each record
	 * @param array
	 * @param string
	 * @param DataContainer
	 * @param array
	 * @return string
	 */
	public function addIcon($row, $label, DataContainer $dc, $args)
	{
		$image = $row['admin'] ? 'admin' :  'user';

		if ($row['disable'] || strlen($row['start']) && $row['start'] > time() || strlen($row['stop']) && $row['stop'] < time())
		{
			$image .= '_';
		}
		
		$objUsers = $this->Database->prepare("SELECT tlu.id"
                    		        . " FROM tl_user tlu, tl_session tls"
                    		        . " WHERE tlu.id = tls.pid AND tlu.id=? AND tls.tstamp>? AND tls.name=?")
                    		       ->execute($row['id'],time()-600,'BE_USER_AUTH');
		if ($objUsers->numRows < 1) 
		{
		    //offline
		    $status = sprintf('<img src="%ssystem/themes/%s/images/invisible.gif" width="16" height="16" alt="Offline" style="padding-left: 18px;">', TL_SCRIPT_URL, $this->getTheme());
		} 
		else 
		{
		    //online
		    $status = sprintf('<img src="%ssystem/themes/%s/images/visible.gif" width="16" height="16" alt="Online" style="padding-left: 18px;">', TL_SCRIPT_URL, $this->getTheme());
		}
		if ($row['currentLogin'] == 0)
		{
		    $args[4] = $GLOBALS['TL_LANG']['MSC']['tl_member_onlineicon']['lastlogin_never'];
		}
		
		$args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/images/%s.gif\'); width: 34px;">%s</div>', TL_SCRIPT_URL, $this->getTheme(), $image, $status);
		return $args;
	}
	
	
}

?>