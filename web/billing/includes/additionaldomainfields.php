<?php

/*
******************************************
***** WHMCS DOMAIN ADDITIONAL FIELDS *****
******************************************
This file defines the additional fields of
data that need to be collected for certain
TLDs.
******************************************
******************************************
*/

## AU DOMAINS REQUIREMENTS ##

$additionaldomainfields[".com.au"][] = array(
"Name" => "Registrant Name",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".com.au"][] = array(
"Name" => "Registrant ID",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".com.au"][] = array(
"Name" => "Registrant ID Type",
"Type" => "dropdown",
"Options" => "ABN,ACN,Business Registration Number",
"Default" => "ABN",
);

$additionaldomainfields[".com.au"][] = array(
"Name" => "Eligibility Name",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => false,
);

$additionaldomainfields[".com.au"][] = array(
"Name" => "Eligibility ID",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => false,
);

$additionaldomainfields[".com.au"][] = array(
"Name" => "Eligibility ID Type",
"Type" => "dropdown",
"Options" => ",Australian Company Number (ACN),ACT Business Number,NSW Business Number,NT Business Number,QLD Business Number,SA Business Number,TAS Business Number,VIC Business Number,WA Business Number,Trademark (TM),Other - Used to record an Incorporated Association number,Australian Business Number (ABN)",
"Default" => "",
);

$additionaldomainfields[".com.au"][] = array(
"Name" => "Eligibility Type",
"Type" => "dropdown",
"Options" => "Charity,Citizen/Resident,Club,Commercial Statutory Body,Company,Incorporated Association,Industry Body,Non-profit Organisation,Other,Partnership,Pending TM Owner  ,Political Party,Registered Business,Religious/Church Group,Sole Trader,Trade Union,Trademark Owner,Child Care Centre,Government School,Higher Education Institution,National Body,Non-Government School,Pre-school,Research Organisation,Training Organisation",
"Default" => "Company",
);

$additionaldomainfields[".com.au"][] = array(
"Name" => "Eligibility Reason",
"Type" => "radio",
"Options" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.,Close and substantial connection between the domain name and the operations of your Entity.",
"Default" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.",
);

$additionaldomainfields[".net.au"] = $additionaldomainfields[".com.au"];

// org.au / asn.au

$additionaldomainfields[".org.au"][] = array(
"Name" => "Registrant Name",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".org.au"][] = array(
"Name" => "Registrant ID",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".org.au"][] = array(
"Name" => "Registrant ID Type",
"Type" => "dropdown",
"Options" => "ABN,ACN,N/A",
"Default" => "N/A",
);

$additionaldomainfields[".org.au"][] = array(
"Name" => "Eligibility Name",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => false,
);

$additionaldomainfields[".org.au"][] = array(
"Name" => "Eligibility ID",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => false,
);

$additionaldomainfields[".org.au"][] = array(
"Name" => "Eligibility ID Type",
"Type" => "dropdown",
"Options" => ",Australian Company Number (ACN),ACT Business Number,NSW Business Number,NT Business Number,QLD Business Number,SA Business Number,TAS Business Number,VIC Business Number,WA Business Number,Trademark (TM),Other - Used to record an Incorporated Association number,Australian Business Number (ABN)",
"Default" => "",
);

$additionaldomainfields[".org.au"][] = array(
"Name" => "Eligibility Type",
"Type" => "dropdown",
"Options" => "Charity,Citizen/Resident,Club,Commercial Statutory Body,Company,Incorporated Association,Industry Body,Non-profit Organisation,Other,Partnership,Pending TM Owner,Political Party,Registered Business,Religious/Church Group,Sole Trader,Trade Union,Trademark Owner,Child Care Centre,Government School,Higher Education Institution,National Body,Non-Government School,Pre-school,Research Organisation,Training Organisation",
"Default" => "Charity",
);

$additionaldomainfields[".org.au"][] = array(
"Name" => "Eligibility Reason",
"Type" => "radio",
"Options" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.,Close and substantial connection between the domain name and the operations of your Entity.",
"Default" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.",
);

$additionaldomainfields[".asn.au"] = $additionaldomainfields[".org.au"];


// id.au

$additionaldomainfields[".id.au"][] = array(
"Name" => "Registrant Name",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".id.au"][] = array(
"Name" => "Eligibility Type",
"Type" => "dropdown",
"Options" => "Citizen/Resident",
"Default" => "Citizen/Resident",
);

$additionaldomainfields[".id.au"][] = array(
"Name" => "Eligibility Reason",
"Type" => "radio",
"Options" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.",
"Default" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.",
);

## US DOMAIN REQUIREMENTS ##

$additionaldomainfields[".us"][] = array(
"Name" => "Nexus Category",
"Type" => "dropdown",
"Options" => "C11,C12,C21,C31,C32",
"Default" => "C11",
);

$additionaldomainfields[".us"][] = array(
"Name" => "Nexus Country",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".us"][] = array(
"Name" => "Application Purpose",
"Type" => "dropdown",
"Options" => "Business use for profit,Non-profit business,Club,Association,Religious Organization,Personal Use,Educational purposes,Government purposes",
"Default" => "Business use for profit",
);

## CA DOMAIN REQUIREMENTS ##

$additionaldomainfields[".ca"][] = array(
"Name" => "Legal Type",
"Type" => "dropdown",
"Options" => "Corporation,Canadian Citizen,Permanent Resident of Canada,Government,Canadian Educational Institution,Canadian Unincorporated Association,Canadian Hospital,Partnership Registered in Canada,Trade-mark registered in Canada,Canadian Trade Union,Canadian Political Party,Canadian Library Archive or Museum,Trust established in Canada,Aboriginal Peoples,Legal Representative of a Canadian Citizen,Official mark registered in Canada",
"Default" => "Corporation",
);

$additionaldomainfields[".ca"][] = array(
"Name" => "Registrant Name",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".ca"][] = array(
"Name" => "Trademark Number",
"Type" => "text",
"Size" => "50",
"Default" => "",
"Required" => false,
);

$additionaldomainfields[".ca"][] = array(
"Name" => "Organization Registered Location",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => false,
);

## UK DOMAIN REQUIREMENTS ##

$additionaldomainfields[".co.uk"][] = array(
"Name" => "Legal Type",
"Type" => "dropdown",
"Options" => "Individual,UK Limited Company,UK Public Limited Company,UK Partnership,UK Limited Liability Partnership,Sole Trader,UK Registered Charity,UK Entity (other),Foreign Organization,Other foreign organizations",
"Default" => "Individual",
);

$additionaldomainfields[".co.uk"][] = array(
"Name" => "Company ID Number",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => false,
);

$additionaldomainfields[".co.uk"][] = array(
"Name" => "Registrant Name",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".co.uk"][] = array(
"Name" => "WHOIS Opt-out",
"Type" => "tickbox",
);

$additionaldomainfields[".net.uk"] = $additionaldomainfields[".co.uk"];
$additionaldomainfields[".org.uk"] = $additionaldomainfields[".co.uk"];
$additionaldomainfields[".me.uk"] = $additionaldomainfields[".co.uk"];

## .PLC.UK DOMAIN REQUIREMENTS ##

$additionaldomainfields[".plc.uk"][] = array(
"Name" => "Legal Type",
"Type" => "dropdown",
"Options" => "UK Public Limited Company",
"Default" => "UK Public Limited Company",
);

$additionaldomainfields[".plc.uk"][] = array(
"Name" => "Company ID Number",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".plc.uk"][] = array(
"Name" => "Company Name",
"Type" => "text",
"Size" => "64",
"Default" => "",
"Required" => true,
);

## .LTD.UK DOMAIN REQUIREMENTS ##

$additionaldomainfields[".ltd.uk"][] = array(
"Name" => "Legal Type",
"Type" => "dropdown",
"Options" => "UK Limited Company,UK Limited Liability Partnership",
"Default" => "UK Limited Company",
);

$additionaldomainfields[".ltd.uk"][] = array(
"Name" => "Company ID Number",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".ltd.uk"][] = array(
"Name" => "Company Name",
"Type" => "text",
"Size" => "64",
"Default" => "",
"Required" => true,
);

## .ES DOMAIN REQUIREMENTS ##

$additionaldomainfields[".es"][] = array(
"Name" => "ID Form Type",
"Type" => "dropdown",
"Options" => "Other Identification,Tax Identification Number,Tax Identification Code,Foreigner Identification Number",
"Default" => "Other Identification",
);

$additionaldomainfields[".es"][] = array(
"Name" => "ID Form Number",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => true,
);

## .SG DOMAIN REQUIREMENTS ##

$additionaldomainfields[".sg"][] = array(
"Name" => "RCB/Singapore ID",
"Type" => "text",
"Size" => "30",
"Default" => "",
"Required" => true,
);

$additionaldomainfields[".sg"][] = array(
"Name" => "Registrant Type",
"Type" => "dropdown",
"Options" => "Individual,Organisation",
"Default" => "Individual",
);

$additionaldomainfields[".com.sg"] = $additionaldomainfields[".sg"];
$additionaldomainfields[".edu.sg"] = $additionaldomainfields[".sg"];
$additionaldomainfields[".net.sg"] = $additionaldomainfields[".sg"];
$additionaldomainfields[".org.sg"] = $additionaldomainfields[".sg"];
$additionaldomainfields[".per.sg"] = $additionaldomainfields[".sg"];

## .TEL DOMAIN REQUIREMENTS ##

$additionaldomainfields[".tel"][] = array(
"Name" => "Legal Type",
"Type" => "dropdown",
"Options" => "Natural Person,Legal Person",
"Default" => "Natural Person",
);

$additionaldomainfields[".tel"][] = array(
"Name" => "WHOIS Opt-out",
"Type" => "tickbox",
);

## .TEL DOMAIN REQUIREMENTS ##

$additionaldomainfields[".it"][] = array(
"Name" => "Tax ID",
"Type" => "text",
"Size" => "20",
"Default" => "",
"Required" => true,
);

?>