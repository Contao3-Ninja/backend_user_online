<?php 
   
/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Module Backend User Online - runonce
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline 
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/backend_user_online  
 */

/**
 * Class BackendUserOnlineRunonceJob
 * 
 * Because of the unnecessary change in Contao core
 * https://github.com/contao/core/issues/5949
 * 
 * @copyright  Glen Langer 2012..2013
 * @author     Glen Langer
 * @package    Banner
 * @license    LGPL
 */
class BackendUserOnlineRunonceJob extends Controller
{
	public function __construct()
	{
	    parent::__construct();
	}
	
	public function run()
	{
	    // Backend User Online Issues #6
	    $a = $this->Session->get('sorting');
	    $a['tl_user']   = 'currentLogin DESC';
	    $a['tl_member'] = 'currentLogin DESC';
	    $this->Session->set('sorting',$a);
	}
}

$objBackendUserOnlineRunonceJob = new BackendUserOnlineRunonceJob();
$objBackendUserOnlineRunonceJob->run();

