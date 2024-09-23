<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"/>
    <title></title>
    <style>
        label{
            display: block;
        }
    </style>
</head>
<body>
<form id="idFormAioCheckOut" method="post" action="https://testepos.ctbcbank.com/mauth/SSLAuthUI.jsp">">
    
    <tr>
<td width="100%">
加密值： <input name="URLEnc" value="">
</td>
</tr>
    <label>訂單編號 訂單編號 (MerchantTradeNo):
        <input type="text" name="MerchantTradeNo" value="oikidA0000001" class="form-control"/>
        不可重複使用。英數字大小寫混合
    </label>

    <label class="col-xs-12">類型 (PaymentType):
        <input type="text" name="PaymentType" value="aio" class="form-control"/>
        aio
    </label>
    <label class="col-xs-12">訂單金額(TotalAmount):
        <input type="text" name="TotalAmount" value="29999" class="form-control"/>
        
    </label>
    <label class="col-xs-12">信用卡號 (TradeDesc):
        <input type="text" name="Credit_num" value="Desc" class="form-control"/>
    </label>
    <label class="col-xs-12">三碼檢查碼 (ItemName):
        <input type="text" name="Check_num" value="" class="form-control"/>
       
    </label>
    <label class="col-xs-12">時間 (MerchantTradeDate):
        <input type="text" name="MerchantTradeDate" value="2017/06/30 00:00:00" class="form-control"/>
        yyyy/MM/dd HH:mm:ss
    </label>
    <label class="col-xs-12">付款方式 (ChoosePayment):
        <input type="text" name="ChoosePayment" value="ALL"/>
        
    </label>
 
    <input type="hidden" name="MerchantID" value="2000132" />
    <input type="hidden" name="HashKey" value="5294y06JbISpM5x9" />
    <input type="hidden" name="HashIV" value="v77hoKGq4kWxNNIS" />
 
    <button type="submit" class="btn btn-default">線上支付</button>
</form>
 
</body>
</html>