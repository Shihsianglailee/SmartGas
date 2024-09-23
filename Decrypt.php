<?php
include 'auth_mpi_mac.php';
$EncRes=
"344F5B074BCB12E82FAEFE535B5FCC445F6C43DB180928531A34811B829C809D5AD3485F50C22DC3148B51321C7D528B90C979B2A2CB4D4B079E3C786202161DB859CE6A3CD62A7C87317C5F5219AE6851C0C01AFC97C6502B6CBE435FFBF85A87FF85DACAFD4B7483ED777DA8F703E624E5FA24A2D11309C118D7AA1BD3A7E2F815A669B374598F05AB6D50C97D841C6AB885527D28866C7364541924EB0645784CB887679794F4412AC0EB6BB80E19554B133813AB2A7C0770D8416C5BACA292E98D7FBEEABA8C7612F8BAF56DB33B5BD2C4B7BE1ECC3003F18FAD011D0C91079DAD8330227C6C0A44A9C15EE1C73A291734FA22928B3FC87AF1DF6FB467F2659173EB74AF050A"; // 回傳的密文，請參考3.7特店網站設定AuthResURL(加密專用)取得URLResEnc
$Key="MNL0iUjhyIa1O570ekxehFIZ";
$debug="0";
$EncArray=gendecrypt($EncRes,$Key,$debug);
$MACString='';
$URLEnc=''
echo "<BR>\n";
foreach($EncArray AS $name => $val){
echo $name ."=>". urlencode(trim($val,"\x00..\x08")) ."\n";
}
$status = isset($EncArray['status']) ? $EncArray['status'] : "";
$errCode = isset($EncArray['errcode']) ? $EncArray['errcode'] : "";
$authCode = isset($EncArray['authcode']) ? $EncArray['authcode'] : "";
$authAmt = isset($EncArray['authamt']) ? $EncArray['authamt'] : "";
$lidm = isset($EncArray['lidm']) ? $EncArray['lidm'] : "";
$OffsetAmt = isset($EncArray['offsetamt']) ? $EncArray['offsetamt'] : "";
$OriginalAmt = isset($EncArray['originalamt']) ? $EncArray['originalamt'] : "";
$UtilizedPoint = isset($EncArray['utilizedpoint']) ? $EncArray['utilizedpoint'] : "";
$Option = isset($EncArray['numberofpay']) ? $EncArray['numberofpay'] : "";
//紅利交易時請帶入prodcode
//$Option = isset($EncArray['prodcode']) ? $EncArray['prodcode'] : "";
$Last4digitPAN = isset($EncArray['last4digitpan']) ? $EncArray['last4digitpan'] : "";
$pidResult= isset($EncArray['pidresult']) ? $EncArray['pidresult'] : "";
$CardNumber = isset($EncArray['cardnumber']) ? $EncArray['cardnumber'] : "";
$CardNo = isset($EncArray['cardno']) ? $EncArray['cardno'] : "";//(僅供優化環境使用 僅供優化環境使用 僅供優化環境使用 )
$EInvoice = isset($EncArray['einvoice']) ? $EncArray['einvoice'] : "";//(僅供優化環境 僅供優化環境 使用 )
$MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$lidm,$OffsetAmt,$OriginalAmt,$UtilizedPoint,$Option,$Last4digitPAN,$Key,$debug);
//if ($MACString == $EncArray['outmac']), then the result is right!
?>