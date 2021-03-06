<?php
/**
* $Id: mysms.provider.mobilenl.php 184 2009-12-11 17:06:40Z axel $
*
* @author Axel Sauerhöfer 
* @copyright Copyright &copy; 2008, Axel Sauerhöfer
* @version 1.5.6
* @email mysms[at]quelloffen.com
* @package MySMS
*
* All rights reserved.  MySMS Component for Joomla!
*
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* MySMS! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
**/
//check if joomla call us
defined( '_JEXEC' ) or die( 'Restricted access' );

if( defined( 'MYSMS_PROVIDER_MOBILENL_PHP' ) == true )
{
  return;
}

/**
 * Define our class constant to precent multipe definition
 */
define( 'MYSMS_PROVIDER_MOBILENL_PHP', 1 );


/**
 * require our base class
 */
require_once('provider.php');

/**
*  Mobile.nl is a sms gateway connection implementation (https://www.mobile.nl)
*
* @package MySMS
* @subpackage Provider
**/

class MOBILENL extends Provider
{

   /**
   *  Constructor, setting up name, file and parameters
   */
      function MOBILENL()
      {
        Provider::Provider();   //call base class constructor
        $this->_name = 'MOBILENL';
        $this->_file = basename( __FILE__ );

        $this->_params['username']	=  'test';            //default params
        $this->_params['password'] 	=  'test';            //default params
      }

   /**
   *  The sendSMS is for sending a sms, this function must be reimplemented in all dirved classes
   *  @param string $text
   *  @param string $from
   *  @param string $to
   */
      function sendSms( $text, $from, $to, &$errMsg)
      {

        $user 	=  &$this->_params['username'];
        $pw 	=  &$this->_params['password'];

        $url  = 'http://www.mollie.nl/xml/sms/?';

        $url .= $this->buildQuery( array( 'username'   => $user,
        								  'password'   => $pw,
        								  'originator' => $from,
        								  'recipients' => $to,
        								  'message'	   => $text ) );

		$response = file_get_contents( $url );

		//xml
		{
			$x = new SimpleXMLElement( $response );
			if( $x->item->success == 'false' )
			{
				$errMsg = $x->item->resultmessage;
				return false;
			}
		}

		return true;
  }//end send sms
} //end class aspsms
?>