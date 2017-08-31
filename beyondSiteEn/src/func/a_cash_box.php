<?php
/*
##########################################################################
#                                                                        #
#           Version 4       /                        /   /               #
#          -----------__---/__---__------__----__---/---/-               #
#           | /| /  /___) /   ) (_ `   /   ) /___) /   /                 #
#          _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/___               #
#                       Free Content / Management System                 #
#                                   /                                    #
#                                                                        #
#                                                                        #
#   Copyright 2005-2010 by webspell.org                                  #
#                                                                        #
#   visit webSPELL.org, webspell.info to get webSPELL for free           #
#   - Script runs under the GNU GENERAL PUBLIC LICENSE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
#   Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at),   #
#   Far Development by Development Team - webspell.org                   #
#                                                                        #
#   visit webspell.org                                                   #
#                                                                        #
##########################################################################
*/
/*
##########################################################################
#                                                                        #
#   ALMIGHTY CASH BOX                                                    #
#                                                                        #
#   Copyright 2007-2010 by Anton 'iflow' Jungwirth                       #
#                                                                        #
#   Version: 2.0                                                         #
#                                                                        #
#   - Script runs under the GNU GENERAL PUBLIC LICENSE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#                                                                        #
#   Support: webSPELL.org, iflow.anju-web.com                            #
##########################################################################
*/

/************************************************************************/
/* BEGIN OF GENERAL SETTINGS                                            */
/************************************************************************/
define('ACB_AMOUNT_REGEX', "/^[0-9]{1,10}([.|,][0-9]{1,2})?$/"); //Remember to change also javascript var filter in function checkAmount(amount);
define('ACB_FUTURE_RECURRENCES', 10); //Number of future recurrences saved to your database
define('ACB_MAX_FUTURE_PAYMENTS', 10); //ACB_MAX_FUTURE_PAYMENTS should be equal or lesser than ACB_FUTURE_RECURRENCES
define('ACB_CASHBOOK_STARTYEAR', 2007); //used in cash book
define('ACB_DATE_FORMAT', 'd.m.Y'); //use php date() parameters
/************************************************************************/
/* END OF GENERAL SETTINGS                                              */
/************************************************************************/

$res_s = mysql_query("SHOW TABLE STATUS LIKE '".PREFIX."a_cash_box_settings'");
$res_c = mysql_query("SHOW TABLE STATUS LIKE '".PREFIX."a_cash_box_currencies'");

//only proceed, if cash box settings and currencies available
if(mysql_num_rows($res_s) && mysql_num_rows($res_c)) {
	$res_set = safe_query("SELECT curID FROM ".PREFIX."a_cash_box_settings");

	//get currency:
	if(mysql_num_rows($res_set)) {
		$row_set = mysql_fetch_row($res_set);

		$row_cur = mysql_fetch_array(safe_query("SELECT currency, shortcut, symbol FROM ".PREFIX."a_cash_box_currencies WHERE curID=".$row_set[0]));

		define('ACB_CURRENCY', getinput($row_cur['currency']));
		define('ACB_CURRENCY_SHORTCUT', getinput($row_cur['shortcut']));
		define('ACB_CURRENCY_SYMBOL', getinput($row_cur['symbol']));

		unset($row_set, $row_cur);
	} else {
		define('ACB_CURRENCY', 'NOT AVAILABLE');
		define('ACB_CURRENCY_SHORTCUT', 'NOT AVAILABLE');
		define('ACB_CURRENCY_SYMBOL', 'NOT AVAILABLE');
	}
	unset($res_set, $res_s, $res_c);
	
	//check running recurrences
    checkRunningRecurrences();
	
	//check notifications of running member contributions and may send messages
	manageOutstandingNotifications();
} else {
    if(!strstr($_SERVER['PHP_SELF'], 'install_acb')) {
        if(DEBUG == 'ON') {
            echo 'ERROR: MySQL database table \'a_cash_box_settings\' does not exist (src/func/a_cash_box.php)!<br />Solution: Run ALMIGHTY CASH BOX Installation or repair your database.';
        }
        exit();
    }
}

/*----------------------------------------------------------------------------------*/
/* checks running recurrences and may insert new cash box entries                   */
/*----------------------------------------------------------------------------------*/

function checkRunningRecurrences() {
    $res_rec = safe_query("SELECT recID, repID, userID, catID, title, info, amount, amountMember, memberPayment, message, userIDs FROM ".PREFIX."a_cash_box_recurrences WHERE recurrences=-1");
	while($row_rec = mysql_fetch_array($res_rec)) {
		$row_cb = mysql_fetch_array(safe_query("SELECT timestamp FROM ".PREFIX."a_cash_box WHERE recID = ".$row_rec['recID']." ORDER BY timestamp DESC LIMIT 0,1"));

		//add new cash box payments
		if($row_cb['timestamp'] <= time() && $row_cb['timestamp'] != 0) {

			//use last cash box payment timestamp to calculate next date
			$date = getACBNextDate($row_rec['repID'], $row_cb['timestamp']);
			$col_amount = 'income';
			if($row_rec['amount']<0) {
				$col_amount = 'expense';
			}
			$counter = 1;

			while($counter <= ACB_FUTURE_RECURRENCES) {
				if(date('Y',$date) > 2037) break;

				//insert member payment information
				if($row_rec['memberPayment']) {
					safe_query("INSERT INTO ".PREFIX."a_cash_box (recID, catID, userID, timestamp, title, info, income, memberPayment, message)
						VALUES (".$row_rec['recID'].", ".$row_rec['catID'].", ".$row_rec['userID'].", ".$date.", '".$row_rec['title']."', '".$row_rec['info']."', '".$row_rec['amount']."', 1, '".$row_rec['message']."')");
					$cbID = mysql_insert_id();
					if($row_rec['userIDs']) {
						$userIDs = explode(";", $row_rec['userIDs']);
					} else {
						$userIDS = array();
					}
					foreach($userIDs as $key => $uID) {
						safe_query("INSERT INTO ".PREFIX."a_cash_box_paid (cbID, userID, amount)
								VALUES (".$cbID.", ".$uID.", ".$row_rec['amountMember'].")");
					}
				//insert normal payment information
				} else {
					safe_query("INSERT INTO ".PREFIX."a_cash_box (recID, catID, userID, timestamp, title, info, ".$col_amount.")
						VALUES (".$row_rec['recID'].", ".$row_rec['catID'].", ".$row_rec['userID'].", ".$date.", '".$row_rec['title']."', '".$row_rec['info']."', '".$row_rec['amount']."')");
				}

				$date = getACBNextDate($row_rec['repID'], $date);
				$counter ++;
			}
		}
	}
}

/*----------------------------------------------------------------------------------*/
/* checks notifications of running member contributions and may send messages       */
/*----------------------------------------------------------------------------------*/

function manageOutstandingNotifications() {
    $res_cb = safe_query("SELECT cbID, title FROM ".PREFIX."a_cash_box WHERE memberPayment = 1 AND message = 1 AND messageSent = 0 AND timestamp <= ".time());
	$_language_tmp = new Language;
	while($row_cb = mysql_fetch_array($res_cb)) {
		$res_cbp = safe_query("SELECT userID FROM ".PREFIX."a_cash_box_paid WHERE cbID = ".$row_cb['cbID']);
		while($row_cbp = mysql_fetch_row($res_cbp)) {

            sendACBMessage($row_cb['title'], $row_cbp[0], false);
		}
		safe_query("UPDATE ".PREFIX."a_cash_box SET messageSent = 1 WHERE cbID = ".$row_cb['cbID']);
	}
}

/*----------------------------------------------------------------------------------*/
/* sends message about new or changed payments in user's language                   */
/* $title:  message title                                                           */
/* $uID: send message to user of given id                                           */
/* $paymentChanged: boolean. true if "payment changed message" should be sent       */
/*----------------------------------------------------------------------------------*/

function sendACBMessage($title, $uID, $paymentChanged) {
	$_language_tmp = new Language;
    $title = clearfromtags($title);
    $ds = mysql_fetch_array(safe_query("SELECT language FROM ".PREFIX."user WHERE userID='".$uID."'"));
    $_language_tmp->set_language($ds['language']);
    $_language_tmp->read_module('almighty_cash_box');
    if($paymentChanged) {
        $message = str_replace("%title%",$title,$_language_tmp->module['acb_message_changed']);
        sendmessage($uID,$_language_tmp->module['acb_message_title_changed'],$message);
    } else {
        $message = str_replace("%title%",$title,$_language_tmp->module['acb_message']);
        sendmessage($uID,$_language_tmp->module['acb_message_title'],$message);
    }
}

/*----------------------------------------------------------------------------------*/
/* returns next recurrence date                                                     */
/*----------------------------------------------------------------------------------*/	
	
function getACBNextDate($repeatType, $date) {
	switch($repeatType) {
		//daily
		case 1: $date = strtotime("+1 day", $date);
				break;
		//weekly
		case 2: $date = strtotime("+1 week", $date);
				break;
		//every second week
		case 3: $date = strtotime("+2 week", $date);
				break;
		//monthly
		case 4: $date = strtotime("+1 month", $date);
				break;
		//yearly
		case 5: $date = strtotime("+1 year", $date);
				break;
        default:
            if(DEBUG == 'ON') {
               echo 'ERROR: Repeat type does not exist! (src/func/a_cash_box.php)';
            }
            exit();
	}
	return $date;
}

?>