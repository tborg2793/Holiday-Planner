<?php
include 'db.php';

function activate($email,$email_code)
{
	$connection = mysql_connect("localhost", "root", "");
	$db = mysql_select_db("holiday", $connection);
	
	$email = sanitize($email);
	$email_code = sanitize($email_code);
	
	if(mysql_result(mysql_query("SELECT COUNT(`ID`) FROM holiday_users WHERE `user_email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"),0)==1)
	{
		mysql_query("UPDATE `holiday_users` SET `active` = 1 WHERE `user_email` = '$email'");
		return true;
		
	} else
	{
		return false;
	}
}

function activate_by_invite($email,$password,$nicename,$email_code)
{
	$connection = mysql_connect("localhost", "root", "");
	$db = mysql_select_db("holiday", $connection);
	
	$email = sanitize($email);
	$password = sanitize($password);
	$nicename = sanitize($nicename);
	$email_code = sanitize($email_code);
	
	$password = md5($password);
	
	if(mysql_result(mysql_query("SELECT COUNT(`ID`) FROM holiday_users WHERE `user_email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"),0)==1)
	{
		mysql_query("UPDATE `holiday_users` SET `user_pass` = '$password', `user_nicename` = '$nicename', `active` = 1 WHERE `user_email` = '$email'");
		return true;
		
	} else
	{
		return false;
	}
}


function user_exists($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`ID`) FROM `holiday_users` WHERE `user_email` = '$username'");
	return(mysql_result($query,0)==1) ? true : false;
}

function user_active($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`ID`) FROM `holiday_users` WHERE `user_email` = '$username' AND `active` = 1");
	return(mysql_result($query,0)==1) ? true : false;
}

function check_if_invited($email,$holiday_id)
{
	$email = sanitize($email);
	$holiday_id = sanitize($holiday_id);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `holiday_user_inter` WHERE `user_id` = '$email' AND `holiday_id` = '$holiday_id'");
	return(mysql_result($query,0)==1) ? true : false;
}

function user_id_from_username($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT `ID` FROM `holiday_users` WHERE `user_email` = '$username'");
	return mysql_result($query,0,'ID');
}



function login($username,$password)
{
	$user_id = user_id_from_username($username);
	
	$username = sanitize($username);
	$password = md5($password);
	
	return (mysql_result(mysql_query("SELECT COUNT(`ID`) FROM `holiday_users` WHERE `user_email` = '$username' AND `user_pass` = '$password'"), 0) == 1) ? $user_id : false;
}


function sanitize($data)
{
	return mysql_real_escape_string($data);
}



function check_txnid($tnxid){
	global $link;
	return true;
	$valid_txnid = true;
	//get result set
	$sql = mysql_query("SELECT * FROM `payments` WHERE txnid = '$tnxid'", $link);
	if ($row = mysql_fetch_array($sql)) {
		$valid_txnid = false;
	}
	return $valid_txnid;
}

function check_price($price, $id){
	$valid_price = false;
	//you could use the below to check whether the correct price has been paid for the product
	
	/*
	$sql = mysql_query("SELECT amount FROM `products` WHERE id = '$id'");
	if (mysql_num_rows($sql) != 0) {
		while ($row = mysql_fetch_array($sql)) {
			$num = (float)$row['amount'];
			if($num == $price){
				$valid_price = true;
			}
		}
	}
	return $valid_price;
	*/
	return true;
}

function updatePayments($data){
	global $link;
	
	if (is_array($data)) {
		$sql = mysql_query("INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES ('".$data['txn_id']."','".$data['payment_amount']."' ,'".$data['payment_status']."','".date("Y-m-d H:i:s")."')", $link);
		return mysql_insert_id($link);
	}
}



