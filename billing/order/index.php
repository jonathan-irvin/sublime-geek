<?php
/*
*************************************************************************
*                                                                       *
* WHMCS - Open Source Ajax Order Form                                   *
* Copyright (c) WHMCS Ltd. All Rights Reserved,                         *
* Release Date: 4th August 2010                                         *
* Version 1.0                                                           *
*                                                                       *
*************************************************************************
*                                                                       *
* This software is furnished under a license and may be used and copied *
* only  in  accordance  with  the  terms  of such  license and with the *
* inclusion of the above copyright notice.  This software  or any other *
* copies thereof may not be provided or otherwise made available to any *
* other person.  No title to and  ownership of the  software is  hereby *
* transferred.                                                          *
*                                                                       *
* Please see the EULA file for the full End User License Agreement.     *
*                                                                       *
*************************************************************************
*/

$owndir = "order/";
$tempsdir = $owndir."templates/";
define("ROOTDIR",dirname(__FILE__)."/../");
define("CLIENTAREA",true);
define("FORCESSL",true);

require(ROOTDIR."dbconnect.php");
require(ROOTDIR."includes/functions.php");
require(ROOTDIR."includes/clientfunctions.php");
require(ROOTDIR."includes/clientareafunctions.php");
require(ROOTDIR."includes/orderfunctions.php");
require(ROOTDIR."includes/invoicefunctions.php");
require(ROOTDIR."includes/gatewayfunctions.php");
require(ROOTDIR."includes/configoptionsfunctions.php");
require(ROOTDIR."includes/customfieldfunctions.php");
require(ROOTDIR."includes/domainfunctions.php");
require(ROOTDIR."includes/whoisfunctions.php");
require(ROOTDIR."includes/countries.php");

$pagetitle =  $_LANG['orderformtitle'];
$breadcrumbnav = "<a href=\"index.php\">".$_LANG['globalsystemname']."</a> > <a href=\"".$_SERVER['PHP_SELF']."\">".$pagetitle."</a>";

initialiseClientArea($pagetitle,'',$breadcrumbnav);

$a = $_REQUEST['a'];
$gid = ($_REQUEST['gid']) ? (int)$_REQUEST['gid'] : '';
$pid = ($_REQUEST['pid']) ? (int)$_REQUEST['pid'] : '';
$initial = $_REQUEST['initial'];
$domainoption = $_REQUEST['domainoption'];
$domain = $_REQUEST['domain'];
$regperiod = $_REQUEST['regperiod'];
$displaynum = $_REQUEST['displaynum'];
$billingcycle = $_REQUEST['billingcycle'];
$configoption = $_REQUEST['configoption'];
$customfield = $_REQUEST['customfield'];
$addon = (is_array($_REQUEST['addon'])) ? array_keys($_REQUEST['addon']) : '';
$hostname = $_REQUEST['hostname'];
$ns1prefix = $_REQUEST['ns1prefix'];
$ns2prefix = $_REQUEST['ns2prefix'];
$rootpw = $_REQUEST['rootpw'];
$promocode = $_REQUEST['promocode'];
$agreetos = $_REQUEST['agreetos'];
$currency = getCurrency();

if ($a) {
    if ($a=="getloading") {
        $templatevars = array();
        echo processSingleTemplate($tempsdir."loading.tpl",$templatevars);
    }
    if ($a=="getproducts") {
        $products = getProducts($gid);
        $templatevars = array();
        $templatevars['products'] = $products;
        echo processSingleTemplate($tempsdir."products.tpl",$templatevars);
    }
    if (($a=="getproduct")OR($a=="cartsummary")) {
        $currency = getCurrency($_SESSION["uid"],$_SESSION["currency"]);
        $result = select_query("tblproducts","showdomainoptions",array("id"=>$pid));
		$data = mysql_fetch_array($result);
		$showdomainoptions = $data['showdomainoptions'];
        if (($showdomainoptions)AND($displaynum=="1")) {
            $templatevars = array();
            echo processSingleTemplate($tempsdir."domainconfig.tpl",$templatevars);
        } else {
            $productinfo = getProductInfo($pid);
            $productpricing = getPricingInfo($pid);
            if ((!$billingcycle)OR($billingcycle=="undefined")) {
                if ($productpricing['type']=='freeaccount') $billingcycle='freeaccount';
                elseif ($productpricing['type']=='onetime') $billingcycle='onetime';
                else {
                    if ($productpricing['rawpricing']['monthly']>=0) $billingcycle='monthly';
                    elseif ($productpricing['rawpricing']['quarterly']>=0) $billingcycle='quarterly';
                    elseif ($productpricing['rawpricing']['semiannually']>=0) $billingcycle='semiannually';
                    elseif ($productpricing['rawpricing']['annually']>=0) $billingcycle='annually';
                    elseif ($productpricing['rawpricing']['biennially']>=0) $billingcycle='biennially';
                    elseif ($productpricing['rawpricing']['triennially']>=0) $billingcycle='triennially';
                }
            }
            $_SESSION["cart"]["products"] = $_SESSION["cart"]["domains"] = array();
            $_SESSION["cart"]["products"][0] = array(
                "pid" => $pid,
                "domain" => $domain,
                "billingcycle" => $billingcycle,
                "configoptions" => $configoption,
                "customfields" => $customfield,
                "addons" => $addon,
                "server" => array("hostname"=>$hostname,"ns1prefix"=>$ns1prefix,"ns2prefix"=>$ns2prefix,"rootpw"=>$rootpw),
            );
            if (($domainoption=="register")OR($domainoption=="transfer")) {
                $_SESSION["cart"]["domains"][0] = array(
                    "type" => $domainoption,
                    "domain" => $domain,
                    "regperiod" => $regperiod,
                );
            }
            $configoptions = getCartConfigOptions($pid,$configoption,$billingcycle);
            $customfields = getCustomFields("product",$pid,"","","on",$customfield);
            $addons = getAddons($pid,$addon);
            $templatevars = array();
            $templatevars['currency'] = $currency;
            $templatevars['productinfo'] = $productinfo;
            $templatevars['billingcycle'] = $billingcycle;
            $templatevars['getproduct'] = $getproduct;
            $templatevars['pricing'] = $productpricing;
            $templatevars['configoptions'] = $configoptions;
            $templatevars['addons'] = $addons;
            $templatevars['customfields'] = $customfields;
            $availablegateways = getAvailableOrderPaymentGateways();
        	$templatevars['gateways'] = $availablegateways;
        	$templatevars['selectedgateway'] = $availablegateways[0]["sysname"];
            $templatevars['countrydropdown'] = getCountriesDropDown();
            $templatevars["accepttos"] = $CONFIG["EnableTOSAccept"];
	        $templatevars["tosurl"] = $CONFIG["TermsOfService"];
            if ($a=="cartsummary") {
                if (!$_SESSION["uid"]) {
                    $_SESSION['cart']['user']['country'] = (isset($_POST['country'])) ? $_POST['country'] : $CONFIG['DefaultCountry'];
                    if (isset($_POST['state'])) $_SESSION['cart']['user']['state'] = $_POST['state'];
                }
                $ordertotals = calcCartTotals();
                $ordertotals["promotioncode"] = $_SESSION["cart"]["promo"];
                $templatevars = array_merge($templatevars,$ordertotals);
                echo processSingleTemplate($tempsdir."cartsummary.tpl",$templatevars);
                exit;
            }
            echo processSingleTemplate($tempsdir."productconfig.tpl",$templatevars);
            $templatevars['ipaddress'] = $remote_ip;
            echo processSingleTemplate($tempsdir."signup.tpl",$templatevars);
        }
    }
    if ($a=="getdomainoptions") {
        $domainparts = explode(".",$domain,2);
        $sld = $domainparts[0];
        $tld = $domainparts[1];
        if ($tld) $tld = ".$tld";
        $templatevars = array();
        if (checkDomainisValid($sld,$tld)) {
            $whoislookup = lookupDomain($sld,$tld);
            $domainstatus = $whoislookup['result'];
            $templatevars['status'] = $domainstatus;
            $regoptions = getTLDPriceList($tld,true);
            $templatevars['regoptionscount'] = count($regoptions);
            $templatevars['regoptions'] = $regoptions;
        }
        echo processSingleTemplate($tempsdir."domainoptions.tpl",$templatevars);
    }
    if ($a=="applypromo") {
        $promoerrormessage = SetPromoCode($promocode);
        echo $promoerrormessage;
        exit;
    }
    if ($a=="removepromo") {
        $_SESSION["cart"]["promo"] = "";
        exit;
    }
    if ($a=="validatecheckout") {
        $errormessage = '';
        $productinfo = getProductInfo($pid);
        if ($productinfo['type']=='server') {
            if (!$hostname) $errormessage .= "<li>".$_LANG['ordererrorservernohostname'];
            else {
                $result = select_query("tblhosting","COUNT(*)",array("domain"=>$hostname.'.'.$domain,"domainstatus"=>array("sqltype"=>"NEQ","value"=>"Cancelled"),"domainstatus"=>array("sqltype"=>"NEQ","value"=>"Terminated"),"domainstatus"=>array("sqltype"=>"NEQ","value"=>"Fraud")));
                $data = mysql_fetch_array($result);
                $existingcount = $data[0];
                if ($existingcount) $errormessage .= "<li>".$_LANG['ordererrorserverhostnameinuse'];
            }
			if ((!$ns1prefix)OR(!$ns2prefix)) $errormessage .= "<li>".$_LANG['ordererrorservernonameservers'];
			if (!$rootpw) $errormessage .= "<li>".$_LANG['ordererrorservernorootpw'];

        }
        if (is_array($configoption)) {
    		foreach ($configoption AS $opid=>$opid2) {
                $result = select_query("tblproductconfigoptions","",array("id"=>$opid));
                $data = mysql_fetch_array($result);
                $optionname = $data["optionname"];
                $optiontype = $data["optiontype"];
                $qtyminimum = $data["qtyminimum"];
                $qtymaximum = $data["qtymaximum"];
                if ($optiontype==4) {
                    $opid2 = (int)$opid2;
                    if ($opid2<0) $opid2=0;
                    if ((($qtyminimum)OR($qtymaximum))AND(($opid2<$qtyminimum)OR($opid2>$qtymaximum))) {
                        $errormessage .= "<li>".sprintf($_LANG['configoptionqtyminmax'],$optionname,$qtyminimum,$qtymaximum);
                        $opid2=0;
                    }
                }
    		}
		}
        $errormessage .= checkCustomFields($customfield);
        if (!$_SESSION['uid']) {
            if ($_REQUEST['signuptype']=="new") {
                $firstname = $_REQUEST['firstname'];
                $lastname = $_REQUEST['lastname'];
                $companyname = $_REQUEST['companyname'];
                $email = $_REQUEST['email'];
                $address1 = $_REQUEST['address1'];
                $address2 = $_REQUEST['address2'];
                $city = $_REQUEST['city'];
                $state = $_REQUEST['state'];
                $postcode = $_REQUEST['postcode'];
                $country = $_REQUEST['country'];
                $phonenumber = $_REQUEST['phonenumber'];
                $password1 = $_REQUEST['password1'];
                $password2 = $_REQUEST['password2'];
                $temperrormsg = $errormessage;
                $errormessage = $temperrormsg.checkDetailsareValid($firstname,$lastname,$email,$address1,$city,$state,$postcode,$phonenumber,$password1,$password2);
                $errormessage .= checkPasswordStrength($password1);
            } else {
                $username = $_REQUEST['username'];
                $password = $_REQUEST['password'];
                if (!validateClientLogin($username,$password)) $errormessage .= "<li>".$_LANG['loginincorrect'];
            }
        }
        if (($CONFIG['EnableTOSAccept'])AND(!$_REQUEST['accepttos'])) $errormessage .= "<li>".$_LANG['ordererrortermsofservice'];
        $_SESSION['cart']['paymentmethod'] = $_REQUEST['paymentmethod'];
        if ($errormessage) echo $_LANG['ordererrorsoccurred']."<br /><ul>".$errormessage."</ul>";
        else {
            if ($_REQUEST['signuptype']=="new") {
                $userid = addClient($firstname,$lastname,$companyname,$email,$address1,$address2,$city,$state,$postcode,$country,$phonenumber,$password1);
            }
        }
    }
    exit;
}

$templatevars = array();
$productgroups = getProductGroups();
$templatevars['groups'] = $productgroups;
if ($pid) {
    $result = select_query("tblproducts","gid",array("id"=>$pid));
	$data = mysql_fetch_array($result);
	$gid = $data['gid'];
    $templatevars['pid'] = $pid;
    if ($skip) $templatevars['skip'] = true;
}
$templatevars['gid'] = $gid;
echo processSingleTemplate($tempsdir."master.tpl",$templatevars);

?>