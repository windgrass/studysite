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
#   Copyright 2005-2009 by webspell.org                                  #
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

$language_array = Array(

/* do not edit above this line */

	'acb_actions'=>'Actions',
	'acb_activate_payment'=>'Activate payment',
	'acb_add_new_member_contribution'=>'Add new member contribution',
	'acb_add_new_payment'=>'Add new payment (expense or income)',
	'acb_amount'=>'Amount',
	'acb_amount_member'=>'amount/member',
    'acb_cancel'=>'Cancel',
	'acb_category'=>'Category',
	'acb_cash_book'=>'Cash book',
	'acb_cash_box'=>'Almighty cash box',
	'acb_check_all'=>'Check all',
	'acb_date'=>'Date',
	'acb_delete'=>'delete',
    'acb_delete_all'=>'Delete all occurrences',
    'acb_delete_just_this'=>'Delete just this occurrence',
    'acb_delete_question'=>'Do you want to delete just this occurrence or all occurences?',
	'acb_edit'=>'edit',
    'acb_edit_just_this'=>'Edit just this occurrence',
    'acb_edit_all'=>'Edit all occurrences',
	'acb_edit_member_contribution'=>'Edit member contribution',
	'acb_edit_payment'=>'Edit payment',
    'acb_edit_question'=>'Do you want to edit just this occurrence or all occurences?',
	'acb_end_date'=>'end date',
	'acb_end_repeat'=>'End repeat',
	'acb_error_amount'=>'You have to enter an amount!',
	'acb_error_amount_corrupt'=>'Your amount is not valid! \\\nAllowed characters: 0 1 2 3 4 5 6 7 8 9 . , \\\ne.g. 12,45 or 100.3 \\\nMax value: 9999999999.99',
	'acb_error_amount_positive'=>'Amount must be greater than zero!',
	'acb_error_amount_member'=>'You have to enter an amount per member!',
	'acb_error_amount_member_corrupt'=>'Your amount per member is not valid! \\\nAllowed characters: 0 1 2 3 4 5 6 7 8 9 . , \\\ne.g. 12,45 or 100.3 \\\nMax value: 9999999999.99',
	'acb_error_amount_member_positive'=>'Amount per member must be greater than zero!',	
	'acb_error_cat'=>'ERROR: Category is not valid.',
	'acb_error_date'=>'ERROR: Date is not valid.',
	'acb_error_end_date'=>'Your specified end date is not valid.',
	'acb_error_on_date'=>'Your specified activation date is not valid.',
	'acb_error_recurrences'=>'Your specified number of recurrences is not valid (allowed: 1-999)!',
	'acb_error_select_member'=>'Please select at least one clanmember.',
	'acb_error_set_activate'=>'Please set an activation option.',
	'acb_error_set_recurrence'=>'Please set an end option for your recurrence.',
	'acb_error_start_date'=>'Your specified start date is not valid.',
	'acb_error_start_date_before_end_date'=>'Your specified end date can not occur before start date.',
	'acb_error_title'=>'You have to enter a title/reason (at least 3 characters)!',
	'acb_errors_there'=>'Some errors occured',
	'acb_expense'=>'expense',
	'acb_future_payments'=>'Future payments',
    'acb_gaming_squads'=>'Gaming squads',
	'acb_go'=>'Go',
    'acb_grouped_by_rec'=>'grouped by repeating payments',
	'acb_h_activate_payment'=>'There you can set the desired date of payment execution. 
								<br />Payment will be added to your cash book <strong>now</strong>, <strong>on</strong> a specified date 
								<br />or iterative automatically on given <strong>recurrence</strong>.',
	'acb_h_amount'=>'Enter a value for your payment. <br />Allowed characters: <strong>0 1 2 3 4 5 6 7 8 9 . ,</strong> <br />e.g. 12,45 or 100.3 <br />Max value: 9999999999.99',
	'acb_h_category'=>'There you may select a category (e.g. server costs). <br />You can add/edit/delete categories in your admincenter.',
	'acb_h_info'=>'There you can enter a text, <br />containing additional information about the payment.',
	'acb_h_member_selection'=>'There you can select clan/squad members. <br />You must select at least one member.',
	'acb_h_notification'=>'Notify selected members about this payment. 
							<br />You can change notification text in: 
							<br />languages &gt; xx &gt; almighty_cash_box.php &gt; acb_message
							<br />Current message text:<br /> %acb_message%',
	'acb_h_payment_type'=>'Choose payment type, <br />expense (e.g. server costs,..) or income (e.g. sponsor).',
	'acb_h_title'=>'Enter a reason/title for this payment <br />(at least 3 characters).',
	'acb_help'=>'Help',
	'acb_info'=>'Information',
	'acb_income'=>'income',
	'acb_nickname'=>'Nickname',
	'acb_no_access'=>'No access',
	'acb_on'=>'on',
	'acb_overview'=>'Overview',
	'acb_member'=>'Member',
	'acb_member_contribution'=>'Member contribution',
	'acb_member_receivables'=>'Member receivables',
	'acb_member_selection'=>'Member selection',
	'acb_message'=>'New payment available. Reason/Title: %title% \n[url=index.php?site=a_cash_box]Click me for more information...[/url]',
    'acb_message_changed'=>'Payment details have changed. Reason/Title: %title% \n[url=index.php?site=a_cash_box]Click me for more information...[/url]',
	'acb_message_title'=>'Cash box - New payment!',
    'acb_message_title_changed'=>'Cash box - Payment has changed!',
	'acb_more_info'=>'more information',
	'acb_need_to_pay'=>'You need to pay %payments% payment(s)',
	'acb_never'=>'never',
	'acb_new_payment'=>'New payment',
	'acb_new_member_contribution'=>'New member contribution',
    'acb_next_payment_orders'=>'Next %payments% payment orders:',
	'acb_non_gaming_squads'=>'Non gaming squads',
	'acb_notification'=>'Notification',
	'acb_now'=>'now',
	'acb_number_of_recurrences'=>'number of recurrences',
	'acb_outstanding'=>'outstanding',
	'acb_paid'=>'Paid',
	'acb_paid_on'=>'Paid on',
	'acb_payment_reason'=>'reason for payment',
	'acb_payment_type'=>'Payment type',
    'acb_quest_title'=>'is a repeating payment',
	'acb_realname'=>'Realname',
	'acb_rec_info'=>'Recurrence info',
	'acb_recurrence'=>'recurrence',
	'acb_recurrences'=>'recurrence(s)',
	'acb_save_payment'=>'Save payment',
	'acb_save_selection'=>'Save selection',
	'acb_select_squads'=>'Select squads',
	'acb_send_message'=>'Send message',
	'acb_show_active'=>'Show active payments',
	'acb_show_all'=>'Show all',
	'acb_show_month_year'=>'Show month/year',
	'acb_show_only_cat'=>'Show only category',
    'acb_shows_future_payments'=>'Shows your future payment orders',
	'acb_start_date'=>'Start date',
	'acb_sum'=>'Sum',
    'acb_sure_cancel'=>'Are you sure you want to cancel?',
	'acb_sure_delete_payment'=>'Are you sure you want to delete this payment?',
	'acb_sure_set_outstanding'=>'Are you sure you want to set this member payment outstanding? \\nPaydate and cash book entry will be deleted!',
	'acb_title'=>'Reason/Title',
	'acb_total'=>'Total',
	'acb_total_amount'=>'total amount',
	'acb_total_cb_amount'=>'Total amount in cash box',
    'acb_total_expenditure'=>'Total expenditure',
    'acb_total_receipts'=>'Total receipts',
	'acb_total_sum'=>'Total sum of',
	'acb_type'=>'Type',
	'acb_uncheck_all'=>'Uncheck all',
    'acb_warning_rec'=>'<strong>Warning!</strong> If you change <strong>recurrence</strong> options, all member payments (includes paydate and cash book entries) will be deleted of these repeating member contributions.',
	'acb_year'=>'Year',
	'acb_yearly_overviews'=>'Yearly overviews'
	);
?>