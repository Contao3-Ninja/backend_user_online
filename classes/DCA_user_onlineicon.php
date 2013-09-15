<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Module Backend User Online - DCA Helper Class DCA_user_onlineicon
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline 
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/backend_user_online  
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\BackendUserOnline;

/**
 * Class DCA_user_onlineicon 
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline
 */
class DCA_user_onlineicon extends \Backend
{
    /**
	 * Add an image to each record
	 * @param array
	 * @param string
	 * @param DataContainer
	 * @param array
	 * @return string
	 */
	public function addIcon($row, $label, $dc, $args)
	{
		$image = $row['admin'] ? 'admin' :  'user';

		if ($row['disable'] 
            || strlen($row['start']) && $row['start'] > time() 
            || strlen($row['stop'])  && $row['stop']  < time() )
		{
			$image .= '_';
		}
		
		$objUsers = \Database::getInstance()
                            ->prepare("SELECT tlu.id 
                                        FROM 
                                            tl_user tlu, tl_session tls 
                                        WHERE 
                                            tlu.id = tls.pid 
                                        AND tlu.id = ? 
                                        AND tls.tstamp > ? 
                                        AND tls.name = ?")
                            ->execute($row['id'], time()-600, 'BE_USER_AUTH');
		if ($objUsers->numRows < 1) 
		{
		    //offline
		    $status = sprintf('<img src="%ssystem/themes/%s/images/invisible.gif" width="16" height="16" alt="Offline" style="padding-left: 18px;">', TL_ASSETS_URL, \Backend::getTheme() );
		} 
		else 
		{
		    //online
		    $status = sprintf('<img src="%ssystem/themes/%s/images/visible.gif" width="16" height="16" alt="Online" style="padding-left: 18px;">', TL_ASSETS_URL, \Backend::getTheme() );
		}

		$args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/images/%s.gif\'); width: 34px;">%s</div>', TL_ASSETS_URL, \Backend::getTheme(), $image, $status);
		return $args;
	}

}
