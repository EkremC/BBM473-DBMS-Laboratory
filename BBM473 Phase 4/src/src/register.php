<?php
include 'DB.php';
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = $_POST['username'];
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    $first_name = $_POST['first-name'];
    $last_name =  $_POST['last-name'];
    $street =  $_POST['shipping']['address'];
    $apt_no =  $_POST['shipping']['address-2'];
    $state =  $_POST['state'];
    $country =  $_POST['country'];
    $ccard_type =  $_POST['card']['type'];
    $ccard_no =  $_POST['card']['number'];
    $ccard_cvc =  $_POST['card']['cvc'];
    $ccard_month =  $_POST['card']['expire-month'];
    $ccard_year =  $_POST['card']['expire-year'];
    $hashed_password = sha1($password);

    $address = 'STREET: ' . $street . ' APT NO: ' . $apt_no . ' STATE: ' . $state . 'COUNTRY: ' . $country;
    $expire_date = $ccard_year . '/' . $ccard_month;

    $parameters = array($username, $hashed_password, $first_name, $last_name, $country, 1, $ccard_no, $ccard_cvc, $address, $expire_date);
    $db = new DB();
    $db->executeProcedure($parameters, 'COMMERCIALUSER_INSERT');

}