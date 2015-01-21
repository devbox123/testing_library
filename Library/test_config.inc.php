<?php
/**
 * #PHPHEADER_OXID_LICENSE_INFORMATION#
 */

// DO NOT TOUCH THIS _ INSTEAD FIX NOTICES - DODGER
error_reporting((E_ALL ^ E_NOTICE) | E_STRICT);
ini_set('display_errors', true);

define ('OXID_PHP_UNIT', true);

$_sOverridenShopBasePath = null;

/**
 * Sets a path to the test shop
 *
 * @deprecated Define OX_BASE_PATH constant instead
 *
 * @param string $sPath New path to shop
 */
function overrideGetShopBasePath($sPath)
{
    //TS2012-06-06
    die("overrideGetShopBasePath() is deprecated use OX_BASE_PATH constant instead. ALWAYS.");
    global $_sOverridenShopBasePath;
    $_sOverridenShopBasePath = $sPath;
}

define('OX_BASE_PATH', isset($_sOverridenShopBasePath) ? $_sOverridenShopBasePath : oxPATH);

function getTestsBasePath()
{
    return realpath(dirname(__FILE__) . '/../');
}

require_once 'test_utils.php';

// Generic utility method file.
require_once OX_BASE_PATH . 'core/oxfunctions.php';

// As in new bootstrap to get db instance.
$oConfigFile = new OxConfigFile(OX_BASE_PATH . "config.inc.php");
OxRegistry::set("OxConfigFile", $oConfigFile);
oxRegistry::set("oxConfig", new oxConfig());
if ($sTestType == 'acceptance') {
    oxRegistry::set("oxConfig", oxNew('oxConfig'));
}

// As in new bootstrap to get db instance.
$oDb = new oxDb();
$oDb->setConfig($oConfigFile);
$oLegacyDb = $oDb->getDb();
OxRegistry::set('OxDb', $oLegacyDb);

oxRegistry::getConfig();

/**
 * Useful for defining custom time
 */
class modOxUtilsDate extends oxUtilsDate
{

    protected $_sTime = null;

    public static function getInstance()
    {
        return oxRegistry::get("oxUtilsDate");
    }

    public function UNITSetTime($sTime)
    {
        $this->_sTime = $sTime;
    }

    public function getTime()
    {
        if (!is_null($this->_sTime)) {
            return $this->_sTime;
        }

        return parent::getTime();
    }
}

// Utility class
require_once getShopBasePath() . 'core/oxutils.php';

// Database managing class.
require_once getShopBasePath() . 'core/adodblite/adodb.inc.php';

// Session managing class.
require_once getShopBasePath() . 'core/oxsession.php';

// Database session managing class.
// included in session file if needed - require_once( getShopBasePath() . 'core/adodb/session/adodb-session.php');

// DB managing class.
//require_once( getShopBasePath() . 'core/adodb/drivers/adodb-mysql.inc.php');
require_once getShopBasePath() . 'core/oxconfig.php';
