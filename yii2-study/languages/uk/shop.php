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

/*¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯\
|  __     __     ______        ______     ______     ______     ______    |   
| /\ \  _ \ \   /\  ___\      /\  ___\   /\  __ \   /\  == \   /\__  _\   |
| \ \ \/ ".\ \  \ \___  \     \ \ \____  \ \  __ \  \ \  __<   \/_/\ \/   |
|  \ \__/".~\_\  \/\_____\     \ \_____\  \ \_\ \_\  \ \_\ \_\    \ \_\   |
|   \/_/   \/_/   \/_____/      \/_____/   \/_/\/_/   \/_/ /_/     \/_/   |
|                                                                         |
|                              version 2.0                                |
|                                                                         |
|                        Code by: Trex und Phil                           |
|                          CLANWORLD-CMS.net                              |
|                     webspell adaption by eGGzy                          |
|                         WWW.KODE-DESIGNS.COM                            |
\________________________________________________________________________*/

$language_array = Array(

/* do not edit above this line */

	'img_format'=>'Image format is incorrect, please use *.gif, *.jpg oder *.png Format only.',
	'successful'=>'Successful',
	'noaccess'=>'Access denied!',
	'nocat'=>'You need to create category first!<br /> <a href="admin/admincenter.php?site=shop-categories" target="_blank">Administrtion</a>',
	'nocategories'=>'No categories available',
	'choose'=>'Please choose',
	'newp'=>'New product',
	'shop'=>'Shop',
	'cart'=>'Cart',
	'edit'=>'Edit',
	'delete'=>'Delete',
	'confirm_delete'=>'Are you sure you want to delete this product?',
	'add_cart'=>'Add to cart',
	'no_items'=>'No items in this category!',
	'nocatid'=>'No category with ID',
	'no_description'=>'No description available!',
	'available'=>'Available',
  	'in_cart'=>'In cart',
	'no_available'=>'Not available',
	'empty_cart'=>'Your cart is empty',
	'already_cart'=>'This product is already in cart.',
	'added_cart'=>'Successful.<br />Product is added to your cart.',
	'no_stock'=>'Not enough units in our stock. Your cart is maxed!',
	'stock_updated'=>'Cart quantity updated.',
	'no_cart'=>'No cart available',
	'cart_removed'=>'Successful.<br />Product is removed from your cart.',
	'subtotal'=>'Subtotal',
	'neto'=>'NETO',
	'vat'=>'TAX',
	'total_price'=>'Total price',
	'nasur'=>'Name / Surname',
	'company'=>'Company:',
	'adress'=>'Adress:',
  	'country'=>'Country',
	'quantity'=>'Quantity',
	'product'=>'Product',
	'unit_price'=>'Unit price',
	'price'=>'Price',
	'stock'=>'Stock:',
	'delivery'=>'Delivery',
	'description'=>'Description:',
	'product_number'=>'Product number:',
	'category'=>'Category',
	'name'=>'Name',
	'item'=>'Item',
	'order_succes'=>'Thank you for your order.<br />You will receive order confirmation email!',
	'email_error1'=>'Error encountered! Email could not be sent.<br />Please contact webmaster!',
	'no_entry'=>'No data',
	'no_categories'=>'No available categories!',
	'no_item_cart'=>'You have no item in cart!',
	'postcode'=>'Postcode',
	'city'=>'City',
	'street'=>'Street',
	'housenum'=>'House number',
	'phone'=>'Phone',
	'product_not_in_stock'=>'Item currently not in stock!',
	'picture'=>'Picture',
	'add_product'=>'Add product',
	'edit_product'=>'Edit product',
	'item_num'=>'Item code',
	'days'=>'Days',
	'checkout'=>'Checkout',
	'accept_agb'=>'Accept terms!',
	'read_accept'=>' I have read and accept',
	'tic'=>'Terms & Conditions',
	'no_agb'=>'You need to input correct terms & conditions!',
	'current_pic'=>'Current',
	/* email strings */
	'order_confirm_mail'=>'Order confirmation mail', /* email subject */
	'new_order_mail'=>'You have a new order!', /* email subject for admin */
	/* email strings for admin new order notice */
	'order_mail'=>'You received a new order!',
	'contact_data'=>'Contact information',
	'ship_adress'=>'Shipping adress',
	'notice'=>'Notice',
	'what_ordered'=>'Following products are ordered',
	'order_num'=>'Order number',
	'category'=>'Category',
	'bank_name'=>'Bank name',
	'bank_account'=>'Bank account',
	/* email strings for order confirmation notice */
	'order_confirm'=>'Oder confirmation',
	'plz_read'=>'PLEASE READ THIS EMAIL IN FULL AND PRINT IT FOR YOUR RECORDS',
	'your_info'=>'Your information',
	'tnx_order'=>'Thank you for your order!',
	'transfer_notice'=>'Please transfer your payment, including order number on our account.',
	'process_order'=>'We will process your order when we receive your payment.',
	'outside_order'=>'For delivery outside our country, please contact administrator.',
	'sincerely'=>'Sincerely,',
	/* v2 */
	/* comments */
	'comments'=>'Comments',
	'no_comments'=>'Disable comments',
	'user_comments'=>'Enable user comments',
	'visitor_comments'=>'Enable visitor comments',
	'plus_tax'=>'plus TAX',
	'bbcode'=>'BBCode ON | HTML OFF',
	'inc_tax'=>'Including tax',
	'brand'=>'Brand',
	'weight'=>'Weight',
	'weight_format'=>'lbs',
	'login_to_buy'=>'Please login or register to buy!',
	/* v3 */
	'enbl_share'=>'Enable share',
	'enable'=>'Enable',
	'your_infos'=>'Your information',
	'disable'=>'Disable',
	/* v3.2 */
	'submit_order'=>'Submit order',
	'enter_firstname'=>'You forgot to enter your firstname!',
	'enter_lastname'=>'You forgot to enter your lastname!',
	'enter_mail'=>'You forgot to enter your mail adress!',
	'enter_postcode'=>'You forgot to enter your postcode!',
	'enter_town'=>'You forgot to enter your town!',
	'enter_street'=>'You forgot to enter your street!',
	'enter_housenum'=>'You forgot to enter your house number!',
	'enter_phone'=>'You forgot to enter your phone!',
	'req_field'=>'Fields marked with * are mandatory'
);
?>