<?php 

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
 * DCA Config, overwrite label_callback
 */
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
		    $status = sprintf('<img src="%ssystem/themes/%s/images/invisible.gif" width="16" height="16" alt="Offline" style="padding-left: 18px;">', TL_ASSETS_URL, $this->getTheme());
		} 
		else 
		{
		    //online
		    $status = sprintf('<img src="%ssystem/themes/%s/images/visible.gif" width="16" height="16" alt="Online" style="padding-left: 18px;">', TL_ASSETS_URL, $this->getTheme());
		}

		$args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/images/%s.gif\'); width: 34px;">%s</div>', TL_ASSETS_URL, $this->getTheme(), $image, $status);
		return $args;
	}

}
