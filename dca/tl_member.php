<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Module Backend User Online - DCA 
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline 
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/backend_user_online  
 */

/**
 * DCA Config, overwrite label_callback
 */
$GLOBALS['TL_DCA']['tl_member']['list']['label']['label_callback'] = array('BugBuster\BackendUserOnline\DCA_member_onlineicon','addIcon');

