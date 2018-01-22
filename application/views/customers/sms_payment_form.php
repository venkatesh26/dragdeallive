<?php
$payu_settings=admin_settings_initialize('payu_settings');
$action = '';
$formError = 0;
$MERCHANT_KEY = $payu_settings['merchant_key'];
$SALT = $payu_settings['merchant_salt'];
$PAYU_BASE_URL = $payu_settings['pay_url'];
if(empty($posted['txnid'])) {
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
paymentsSave($txnid, $this->session->userdata('user_id'), 2);
$posted = array();
$posted['amount']=number_format($plan_details['price'], 2, '.', '');
$posted['email']=$this->session->userdata('user_email');
$posted['phone']=(isset($user_profile_info['mobile_number']) ) ? $user_profile_info['mobile_number'] : '';
$posted['firstname']=(isset($user_profile_info['name']) ) ? $user_profile_info['name'] : '';
$posted['lastname']=(isset($user_profile_info['last_name']) ) ? $user_profile_info['name'] : $user_profile_info['name'];
$posted['productinfo']=$plan_details['description'];
$posted['surl']=base_url().'home/payu_sms_credit_response';
$posted['furl']=base_url().'home/payu_fail_sms_credit_response';
$posted['address1']=(isset($user_profile_info['address']) ) ? $user_profile_info['address'] : '';
$posted['address2']='';
$posted['zipcode']='';
$posted['country']='';
$posted['udf1']=$this->session->userdata('user_id');
$posted['udf2']=$plan_details['description'];
$posted['udf3']=$my_add_id;
$posted['udf4']='1';
$posted['udf5']=$no_of_months;
$posted['udf6'] = "";
$posted['udf7'] = "";
$posted['udf8'] = ""; 
$posted['udf9'] = ""; 
$posted['udf10'] = "";
$posted['pg']='';
$posted['key']=$payu_settings['merchant_key'];
$posted['txnid']= $txnid;
$hash = '';
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|";
$hasTemp = $posted['key']."|".$posted['txnid']."|".$posted['amount']."|".$posted['productinfo']."|".$posted['firstname']."|".$posted['email']."|".$posted['udf1']."|".$posted['udf2']."|".$posted['udf3']."|".$posted['udf4']."|".$posted['udf5']."|".$posted['udf6']."|".$posted['udf7']."|".$posted['udf8']."|".$posted['udf9']."|".$posted['udf10'];
$hasTemp .= "|".$SALT;
$hash = strtolower(hash('sha512', $hasTemp));
$action = $PAYU_BASE_URL . '/_payment';

//print_r($posted);die;
?>
  <script>
	$(document).ready(function(){
     $("#payuForm").submit();
});
  </script>
<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()" style="display:none;">
    <h2>PayU Form</h2>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <table>
        <tr>
          <td><b>Mandatory Parameters</b></td>
        </tr>
        <tr>
          <td>Amount: </td>
          <td><input name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" /></td>
          <td>First Name: </td>
          <td><input name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" /></td>
        </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" /></td>
          <td>Phone: </td>
          <td><input name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td colspan="3"><textarea name="productinfo"><?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?></textarea></td>
        </tr>
        <tr>
          <td>Success URI: </td>
          <td colspan="3"><input name="surl" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" /></td>
        </tr>
        <tr>
          <td>Failure URI: </td>
          <td colspan="3"><input name="furl" value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" /></td>
        </tr>

        <tr>
          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
        </tr>

        <tr>
          <td><b>Optional Parameters</b></td>
        </tr>
        <tr>
          <td>Last Name: </td>
          <td><input name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" /></td>
          <td>Cancel URI: </td>
          <td><input name="curl" value="" /></td>
        </tr>
        <tr>
          <td>Address1: </td>
          <td><input name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" /></td>
          <td>Address2: </td>
          <td><input name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" /></td>
        </tr>
        <tr>
          <td>City: </td>
          <td><input name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" /></td>
          <td>State: </td>
          <td><input name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" /></td>
        </tr>
        <tr>
          <td>Country: </td>
          <td><input name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" /></td>
          <td>Zipcode: </td>
          <td><input name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" /></td>
        </tr>
        <tr>
          <td>UDF1: </td>
          <td><input name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" /></td>
          <td>UDF2: </td>
          <td><input name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" /></td>
        </tr>
        <tr>
          <td>UDF3: </td>
          <td><input name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" /></td>
          <td>UDF4: </td>
          <td><input name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" /></td>
        </tr>
        <tr>
          <td>UDF5: </td>
          <td><input name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" /></td>
          <td>PG: </td>
          <td><input name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" /></td>
        </tr>
        <tr>
          <?php if(!$hash) { ?>
            <td colspan="4"><input type="submit" value="Submit" /></td>
          <?php } ?>
        </tr>
      </table>
    </form>
  </body>
</html>