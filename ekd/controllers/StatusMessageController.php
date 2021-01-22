<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';

class StatusMessageController {
	
	static function GetCleanRedirectURL() {
		$redirectURL = $_SERVER['HTTP_REFERER'];
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'timeoutStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'registerStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'loginStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'modifyAccountStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'modifyCreditCardStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'addFeedbackStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'addOrderItemStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'removeOrderItemStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'checkoutOrderStatus');
		return $redirectURL;
	}
	
	static function GetTimeoutMessage($timeoutStatus) {
		switch ($timeoutStatus)	{
			case 0:
				self::DisplayError('You are not a authenticated user!');
				break;			
			case 1:
				self::DisplayError('Session expired due to 15 minutes of inactivity.');
				break;
		}
	}
	
	static function GetRegisterMessage($registerStatus) {
		switch ($registerStatus) {
			case 0:
				self::DisplaySuccess('Registered account successfully!');
				break;
			case 1:
				self::DisplayError('Email does not meet requirements.');
				break;
			case 2:
				self::DisplayError('Passwords does not match.');
				break;
			case 3:
				self::DisplayError('Password does not meet requirements.');
				break;
			case 4:
				self::DisplayError('First Name does not meet requirements.');
				break;
			case 5:
				self::DisplayError('Last Name does not meet requirements.');
				break;
			case 6:
				self::DisplayError('Mobile Number does not meet requirements.');
				break;
			case 7:
				self::DisplayError('Date of Birth does not meet requirements.');
				break;
			case 8:
				self::DisplayError('Address does not meet requirements.');
				break;
			case 9:
				self::DisplayError('Email already exists.');
				break;
			case 10:
				self::DisplayError('Unknown error occurred.');
				break;					
		}
	}
	
	static function GetLoginMessage($loginStatus) {
		switch ($loginStatus) {
			case 0:
				self::DisplaySuccess('Logged in successfully!');
				break;			
			case 1:
				self::DisplayError('Email does not meet requirements.');
				break;
			case 2:
				self::DisplayError('Password does not meet requirements.');
				break;
			case 3:
				self::DisplayError('Invalid captcha.');
				break;
			case 4:
				self::DisplayError('Invalid login crenditials.');
				break;
		}
	}
	
	static function GetModifyAccountMessage($modifyAccountStatus) {
		switch ($modifyAccountStatus)	{
			case 0:
				self::DisplaySuccess('Account details modified successfully!');
				break;
			case 1:
				self::DisplayError('Please fill in all the blanks.');
				break;				
			case 2:
				self::DisplayError('Email does not meet requirements.');
				break;
			case 3:
				self::DisplayError('Passwords does not meet requirements.');
				break;
			case 4:
				self::DisplayError('First Name does not meet requirements.');
				break;
			case 5:
				self::DisplayError('Last Name does not meet requirements.');
				break;
			case 6:
				self::DisplayError('Mobile Number does not meet requirements.');
				break;
			case 7:
				self::DisplayError('Date of Birth does not meet requirements.');
				break;
			case 8:
				self::DisplayError('Address does not meet requirements.');
				break;
			case 9:
				self::DisplayError('Email already exists.');
				break;
		}
	}
	
	static function GetModifyCreditCardMessage($modifyCreditCardStatus) {
		switch ($modifyCreditCardStatus)	{
			case 0:
				self::DisplaySuccess('Credit card details modified successfully!');
				break;
			case 1:
				self::DisplayError('Please fill in all the blanks.');
				break;
			case 2:
				self::DisplayError('Card number does not meet requirements.');
				break;
			case 3:
				self::DisplayError('Card type does not meet requirements.');
				break;
			case 4:
				self::DisplayError('Expiry date does not meet requirements.');
				break;
		}
	}
	
	static function GetAddFeedbackMessage($addFeedbackStatus) {
		switch ($addFeedbackStatus)	{
			case 0:
				self::DisplaySuccess('Successfully added feedback!');
				break;
			case 1:
				self::DisplayError('Either feedback message does not meet the minimum 10 alphabet requirements or it does not contain alphabets.');
				break;
		}
	}
	
	static function GetAddOrderItemMessage($addOrderItemStatus) {
		switch ($addOrderItemStatus) {
			case 0:
				self::DisplaySuccess('Added item to shopping cart successfully!');
				break;
			case 1:
				self::DisplayError('Failed to add item to shopping cart.');
				break;
			case 2:
				self::DisplayError('Illegal values from combobox field. Please try again.');
				break;
			case 3:
				self::DisplayError('Please select a valid quantity.');
				break;
		}
	}
	
	static function GetRemoveOrderItemMessage($removeOrderItemStatus) {
		switch ($removeOrderItemStatus) {
			case 0:
				self::DisplaySuccess('Removed item from shopping cart successfully!');
				break;
			case 1:
				self::DisplayError('Failed to remove item from shopping cart.');
				break;
		}
	}
	
	static function GetCheckoutOrderMessage($checkoutOrderStatus) {
		switch ($checkoutOrderStatus) {
			case 0:
				self::DisplaySuccess('Successfully purchased order!');
				break;
			case 1:
				self::DisplayError('Unable to purchase order.');
				break;
			case 2:
				self::DisplayError('Incorrect billing information. Please verify and change necessary fields at your account/credit card details');
				break;				
			case 3:
				self::DisplayError('Failed to purchase order. Invalid CCV.');
				break;
			case 4:
				self::DisplayInfo('Removed an item on the order list that does not have enough stock.');
				break;				
		}
	}
	
	private function DisplayInfo($text) {
		echo '<div class="alert alert-info">';
		echo '	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Info: </strong>'.$text;
		echo '</div>';
	}
	
	private function DisplaySuccess($text) {
		echo '<div class="alert alert-success">';
		echo '	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success: </strong>'.$text;
		echo '</div>';
	}
	
	private function DisplayError($text) {
		echo '<div class="alert alert-danger">';
		echo '	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error: </strong>'.$text;
		echo '</div>';
	}
}