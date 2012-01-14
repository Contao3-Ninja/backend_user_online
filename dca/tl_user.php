<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2011 
 * @author     Glen Langer 
 * @package    BackendUserOnline 
 * @license    LGPL 
 * @version    $Id: tl_user.php 97 2010-06-16 19:15:46Z bibo $
 */


/**
 * Listing
 */
$GLOBALS['TL_DCA']['tl_user']['list']['label']['label_callback'] = array('tl_user_onlineicon','addIcon');

/**
 * Class tl_user_onlineicon 
 *
 * @copyright  Glen Langer 2009..2011
 * @author     Glen Langer 
 * @package    BackendUserOnline
 */
class tl_user_onlineicon extends Backend
{
	
	public function addIcon($row, $label)
	{
		//Original
		$image = $row['admin'] ? 'admin' :  'user';

		if ($row['disable'] || strlen($row['start']) && $row['start'] > time() || strlen($row['stop']) && $row['stop'] < time())
		{
			$image .= '_';
		}
		//addon
		if(version_compare(VERSION . '.' . BUILD, '2.8.0', '<'))
		{
		    // Code für Versionen < 2.8.0
			$lastLogin = '';
		}
		else
		{
			// Code für Versionen ab 2.8.0
			$lastLogin = '<span style="float: right; color: #B3B3B3;">['.$GLOBALS['TL_LANG']['MSC']['tl_user_onlineicon']['lastlogin'].': '.$GLOBALS['TL_LANG']['MSC']['tl_user_onlineicon']['lastlogin_never'].']</span>';
		}
		$objUsers = $this->Database->prepare("SELECT tlu.id"
		                                  . " FROM tl_user tlu, tl_session tls"
		                                  . " WHERE tlu.id = tls.pid AND tlu.id=? AND tls.tstamp>? AND tls.name=?")
			     				   ->execute($row['id'],time()-600,'BE_USER_AUTH');
		if ($objUsers->numRows < 1) {
			//offline
			$status = sprintf('<img src="system/themes/%s/images/invisible.gif" width="16" height="16" alt="Offline" />', $this->getTheme());
			if(version_compare(VERSION . '.' . BUILD, '2.7.6', '>'))
			{
				if ($row['currentLogin'] >0 ) {
					$lastLogin = '<span style="float: right; color: #B3B3B3;">['.$GLOBALS['TL_LANG']['MSC']['tl_user_onlineicon']['lastlogin'].': '.date($GLOBALS['TL_CONFIG']['datimFormat'], $row['currentLogin']).']</span>';
				}
			}
		} else {
			//online
			$status = sprintf('<img src="system/themes/%s/images/visible.gif" width="16" height="16" alt="Online" />', $this->getTheme());
			if(version_compare(VERSION . '.' . BUILD, '2.7.6', '>'))
			{
				if ($row['currentLogin'] >0 ) {
					$lastLogin = '<span style="float: right; color: #B3B3B3;">['.$GLOBALS['TL_LANG']['MSC']['tl_user_onlineicon']['lastlogin'].': '.date($GLOBALS['TL_CONFIG']['datimFormat'], $row['currentLogin']).']</span>';
				}
			}
		}
		//Original
		//return sprintf('<div class="list_icon" style="background-image:url(\'system/themes/%s/images/%s.gif\');">%s</div>', $this->getTheme(), $image, $label);
		//addon
		if(version_compare(VERSION . '.' . BUILD, '2.9.9', '<'))
		{
			return sprintf('<div class="list_icon" style="background-image:url(\'system/themes/%s/images/%s.gif\');">%s %s %s</div>', $this->getTheme(), $image, $status, $label, $lastLogin);
		} else {
			return sprintf('<div class="list_icon" style="background-image:url(\'%ssystem/themes/%s/images/%s.gif\');">%s %s %s</div>', TL_SCRIPT_URL, $this->getTheme(), $image, $status, $label, $lastLogin);
		}
	}
	
	
}

?>