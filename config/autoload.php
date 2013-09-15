<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package BackendUserOnline
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'BugBuster\BackendUserOnline\DCA_user_onlineicon'   => 'system/modules/backend_user_online/classes/DCA_user_onlineicon.php',
	'BugBuster\BackendUserOnline\DCA_member_onlineicon' => 'system/modules/backend_user_online/classes/DCA_member_onlineicon.php',
));
