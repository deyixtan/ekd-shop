<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';

class StatusMessageController {
	
	static function GetCleanRedirectURL() {
		$redirectURL = $_SERVER['HTTP_REFERER'];
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'loginStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'modifyAccountStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'addItemStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'modifyItemStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'removeItemStatus');
		$redirectURL = StringHandlerController::RemoveQueryParam($redirectURL, 'updateOrderStatus');
		return $redirectURL;
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
	
	static function GetAddItemMessage($addItemStatus) {
		switch ($addItemStatus)	{
			case 0:
				self::DisplaySuccess('Item added successfully!');
				break;
		}
	}
	
	static function GetModifyItemMessage($modifyItemStatus) {
		switch ($modifyItemStatus)	{
			case 0:
				self::DisplaySuccess('Item modified successfully!');
				break;
		}
	}
	
	static function GetRemoveItemMessage($removeItemStatus) {
		switch ($removeItemStatus)	{
			case 0:
				self::DisplaySuccess('Item removed successfully!');
				break;
		}
	}
	
	static function GetUpdateOrderMessage($updateOrderStatus) {
		switch ($updateOrderStatus)	{
			case 0:
				self::DisplaySuccess('Update order successfully!');
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