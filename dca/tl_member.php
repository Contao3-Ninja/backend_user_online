<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
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
$GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'] = array('icon', 'firstname', 'lastname', 'username', 'dateAdded', 'currentLogin');
//unset($GLOBALS['TL_DCA']['tl_member']['fields']['lastLogin']);
$GLOBALS['TL_DCA']['tl_member']['fields']['currentLogin'] = array
(
	'label'   => &$GLOBALS['TL_LANG']['MSC']['tl_member_onlineicon']['lastlogin'],
	'sorting' => true,
	'flag'    => 6,
	'eval'    => array('rgxp'=>'datim')
);
$GLOBALS['TL_DCA']['tl_member']['list']['label']['label_callback'] = array('tl_member_onlineicon','addIcon');

/**
 * Class tl_member_onlineicon
 *
 * @copyright  Glen Langer 2009..2012 
 * @author     Glen Langer 
 * @package    BackendUserOnline
 */
class tl_member_onlineicon extends Backend
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
		$image = 'member';

		if ($row['disable'] || strlen($row['start']) && $row['start'] > time() || strlen($row['stop']) && $row['stop'] < time())
		{
			$image .= '_';
		}
		
		$objUsers = $this->Database->prepare("SELECT tlm.id"
		                                  . " FROM tl_member tlm, tl_session tls"
		                                  . " WHERE tlm.id = tls.pid AND tlm.id=? AND tls.tstamp>? AND tls.name=?")
			     				   ->execute($row['id'],time()-300,'FE_USER_AUTH');
		if ($objUsers->numRows < 1) {
			//offline
			$status = sprintf('<img src="%ssystem/themes/%s/images/invisible.gif" width="16" height="16" alt="Offline" style="padding-left: 18px;">', TL_SCRIPT_URL, $this->getTheme());
		} else {
			//online
			$status = sprintf('<img src="%ssystem/themes/%s/images/visible.gif" width="16" height="16" alt="Online" style="padding-left: 18px;">', TL_SCRIPT_URL, $this->getTheme());
		}
		if ($row['currentLogin'] == 0)
		{
			$args[5] = $GLOBALS['TL_LANG']['MSC']['tl_member_onlineicon']['lastlogin_never'];
		}
		
		$args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/images/%s.gif\'); width: 34px;">%s</div>', TL_SCRIPT_URL, $this->getTheme(), $image, $status);
		return $args;
	}
	
}
