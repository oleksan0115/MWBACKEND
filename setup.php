<?php include 'includes/vendor_head.php'; ?>
<?php is_user_login() ? '' : redirect('login.php'); ?>

    <body class="index-opt-2">
<div class="wrapper">
<?php include 'includes/mobile_search_form.php' ?>
  <?php  require_once('operations/config_pdo.php');?>

    <!-- HEADER -->
    
    <main class="site-main m-b-100">
    <div class="block-slide">
      <div class="container">
                  <div class="col-sm-3">
        	<div class="dashboard-left-div">
            	<h3>Categories</h3>
                <ul style="list-style-type:none">
                	<li><a href="https://newdev.destinytemple.com/product_listing.php?search_category=fashion">Fashion</a></li>
                    <li><a href="https://newdev.destinytemple.com/product_listing.php?search_category=music">Music</a></li>
                    <li><a href="https://newdev.destinytemple.com/product_listing.php?search_category=healthnbeauty">Health & Beauty</a></li>
                    <li><a href="https://newdev.destinytemple.com/product_listing.php?search_category=sports">Sports</a></li>
                    <li><a href="https://newdev.destinytemple.com/product_listing.php?search_category=electronics">Electronics</a></li>
                    <li><a href="https://newdev.destinytemple.com/motor/motors.php">Motor & Accessories</a></li>
                  
                    <li><a href="https://newdev.destinytemple.com/product_listing.php?search_category=appliances">Appliances</a></li>
                    <li><a href="https://newdev.destinytemple.com/product_listing.php?search_category=homenliving">Home & Living</a></li>
                    <li><a href="https://newdev.destinytemple.com/motor/vehicles_listing.php?motor_condition=&motor_make=&motor_model=&motor_year=&search_motor=&v_s_type=&v_type=5">Automobiles</a></li>
                    
                </ul>
            </div>
        </div>
    <div class="col-sm-9 m-t-sm">
        <div class="row">
            <div class="col-md-6">
                <div class="task-progress">
                    <h3 class="page_header"><span class="fa fa-money"></span> Set Up Payment
                    </h3>
                </div>
            </div>
            <?php
            if (isset($product_info)) {
                $link = "view_sports_product.php";
            }else{
                $link = "sports_product.php";

            }
            ?>

        </div>
<?php

// Required to import the Stripe library and others.
require_once('scatest/server/php/vendor/autoload.php');

// Two things grabbed from your account setup. Your user must be
// logged in. And then you do a look up in your user table for
// their corresponding stripeAccountId. If they haven't set it up
// yet, it will be null orwww ''.
$currentUserId = -1;
// Put look up in user session here.
$currentUserId = 1;
// YOU_NEED_TO_ADD_CODE
// Validate user logged in
if ($currentUserId == -1) {
    die('Error: Invalid user log in.');
}
// Put stripe account id from table look up here.
if (isset($_SESSION['stripeAccountId']))
$stripeAccountId = $_SESSION['stripeAccountId'];
else
    $stripeAccountId='';
$stmt = $conn->prepare("SELECT * FROM iz_vendor_stripe as go WHERE go.vendor = ?");
$stmt->execute([$_SESSION['user'][0]->user_id]);
$arr = $stmt->fetchAll();
$data_exists = (count($arr)> 0) ? true : false;
        if($data_exists == true){
            echo 'you have finished setup payments for stripe ';
        }

// YOU_NEED_TO_ADD_CODE
// The structure for rendering and updating data is I'm going to
// load one needed item at a time. So for example if I need:
// sin_number, phone_number, name... I'll just load sin_number
// update that info then move on.
// When there is no account id, load begin_setup as the value.
// In the action script, I'll know to create an account object.
else if ($stripeAccountId == '') {
    // Case: Brand new user, never setup account.
    echo '<form action="./setup-action.php" method="POST">';
    ?>
    <div class="form-group col-md-6">
        <label class="title">Enter Your  Country <span class="required">*</span></label>
        <select name="country_textbox" required class="form-control">
            <?php
            $COUNTRY_OPTIONS = ["US" => "United States","CA" => "Canada","AU" => "Australia","GB" => "United Kingdom","DE" => "Germany" ,"FR" => "France" ,"NL" => "Netherlands" ,"IE" => "Ireland" ,"IT" => "Italy" ,"PL" => "Poland","DK" => "Denmark","SK"=>"Slovakia","SI"=>"Slovenia","SG"=>"Singapore","SE"=>"Sweden","PT"=>"Portugal","NZ"=>"New Zealand","NO"=>"Norway","LV"=>"Latvia","LU"=>"Luxembourg","LT"=>"Lithuania","HK"=>"Hong Kong","GR"=>"Greece","FI"=>"Finland","ES"=>"Spain","EE"=>"Estonia","CH"=>"Switzerland","BE"=>"Belgium","AT"=>"Austria"];

            foreach ($COUNTRY_OPTIONS as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
            ?>
        </select>
    </div>
    <?php
    echo '<input type="text" hidden name="action_type" value="begin_setup" />';
    $OPTIONS = [ 'company'=>'Company','individual' => 'Individual'];
    ?>
    <div class="form-group col-md-6">

            <label class="title">Stripe Account Type <span class="required">*</span></label>
            <select name="value_textbox" required class="form-control">
                <?php

            foreach ($OPTIONS as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
       ?>
            </select>
        </div>
        <?php
    echo '<label>By registering your account, you agree  the <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>.</label>';
    echo '<button type="submit" class="btn-order">Begin Account Setup</button>';
    echo '</form>';

} else {
    // Configure the library. You need to input your own test/live API Key.
    // This can be found on your Stripe dashboawwwrd.
    //\Stripe\Stripe::setApiKey('sk_live_CgwxPujOej04dSPOm5Gw70FI00sVbOTCuy');
    \Stripe\Stripe::setApiKey('sk_test_GaC7At1Z13RIysXA9qDIe0Kb00RIQ8OZk2');
//    \Stripe\Account::update(
//        $stripeAccountId,
//        ['individual' => ['first_name' => 'mohamed','address' =>['line1' => 'hyhy']]]
//    );
    $stripeAccountObj = \Stripe\Account::retrieve($stripeAccountId);
//    $stripeAccountObj->company->owners_provided=true;
//    $stripeAccountObj->company->directors_provided=true;
//
//    $stripeAccountObj->save();
   // echo var_dump($stripeAccountObj);
    $_SESSION['currency']=$stripeAccountObj->default_currency;
    $_SESSION['country']=$stripeAccountObj->country;

//    echo json_encode($stripeAccountObj->external_accounts->total_count);
//    exit();
# So if fields needed is empty, you are good.
//    if (count($stripeAccountObj->verification->fields_needed) == 0) {
//        die('You are all setup!');
//    } else {
        # Other wise load element one.
# Following the same structure as above:
//        $neededCode = $stripeAccountObj->verification->fields_needed[0];
        if ($stripeAccountObj->business_type ==null) {
            $neededCode='legal_entity.type';
            // Special case
            $OPTIONS = [ 'company'=>'Company','individual' => 'Individual'];
            echo '<form action="./setup-action.php" method="POST">';
            echo '<input type="text" hidden name="action_type" value="' . $neededCode . '" />';
            ?>

            <?php
            // Using a Select
            ?>
        <div class="form-group col-md-6">
            <label class="title">Stripe Account Type <span class="required">*</span></label>
            <select name="value_textbox" required class="form-control">
                <?php

            foreach ($OPTIONS as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
       ?>
            </select>
        </div>
            <br>
                <?php

                echo '<button type="submit" class="btn-order">Update</button>';
            echo '</form>';
        }

        else if ($stripeAccountObj->business_type=='company' && $stripeAccountObj->company->address->city ==null)
        {
            $neededCode = 'company.city';

            $COUNTRY_OPTIONS = ["US" => "United States"];
            // Special case: address
            echo '<form action="./setup-action.php" method="POST">';
            ?>
            <!---->
            <div class="form-group col-md-6">
                <label class="title">Enter Company  name <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="name"  name="cname">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Enter Tax Id <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="tax id"   name="tax">
            </div>

            <div class="form-group col-md-6">
                <label class="title">Enter Company Address line1 <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="123 Fake Street" name="cline_textbox">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Enter Company Address line2 <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="Apartment 1" name="cline2_textbox">
            </div>  <div class="form-group col-md-6">
            <label class="title">Enter Company City <span class="required">*</span></label>
            <input type="text" class="form-control" id="forLName" placeholder="Toronto" name="ccity_textbox">
        </div>  <div class="form-group col-md-6">
            <label class="title">Enter Company  State <span class="required">*</span></label>
            <input type="text" class="form-control" id="forLName" placeholder="Ontario" name="cstate_textbox">
        </div>
            <div class="form-group col-md-6">
                <label class="title">Enter Company Postal Code <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="M8K 8L3" name="cpostal_textbox">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Enter Representative First name <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="first name"  name="first_name">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Enter Representative Last name <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="Last name"  name="last_name">
            </div>



            <div class="form-group col-md-6">
                <label class="title">Enter Representative Date of birth <span class="required">*</span></label>
                <input type="date" class="form-control" id="forLName" value="1990-10-24" placeholder="Date of birth" name="birth">
            </div>
            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter SSN Last 4<span class="required">*</span></label>-->
            <!--                <input type="number" class="form-control" id="forLName" maxlength="4" minlength="4" placeholder="SSN Last 4" name="ssn">-->
            <!--            </div>-->

            <div class="form-group col-md-6">
                <label class="title">Enter Representative Email<span class="required">*</span></label>
                <input type="email" class="form-control" id="forLName"  placeholder="Email" name="email">
            </div>

            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter Phone number<span class="required">*</span></label>-->
            <!--                <input type="text" class="form-control" id="forLName"  placeholder="Phone number" name="phone">-->
            <!--            </div>-->

            <!---->
            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter Industry<span class="required">*</span></label>-->
            <!--                <input type="text" class="form-control" id="forLName"  placeholder="Enter Industry" name="industry">-->
            <!--            </div>-->
            <!---->
            <!---->
            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter Business website<span class="required">*</span></label>-->
            <!--                <input type="text" class="form-control" id="forLName"  placeholder="Business website" name="phone">-->
            <!--            </div>-->
            <!---->
            <!---->
            <!---->
            <div class="form-group col-md-6">
                <label class="title">Enter Representative Address line1 <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="123 Fake Street" name="line_textbox">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Enter Representative Address line2 <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="Apartment 1" name="line2_textbox">
            </div>  <div class="form-group col-md-6">
            <label class="title">Enter Representative City <span class="required">*</span></label>
            <input type="text" class="form-control" id="forLName" placeholder="Toronto" name="city_textbox">
        </div>  <div class="form-group col-md-6">
            <label class="title">Enter Representative  State <span class="required">*</span></label>
            <input type="text" class="form-control" id="forLName" placeholder="Ontario" name="state_textbox">
        </div>


            <div class="form-group col-md-6">
                <label class="title">Enter Representative Postal Code <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="M8K 8L3" name="postal_textbox">
            </div>
            <button type="button"  onclick="location.href='<?php echo 'setup-action.php' ?>'"  class="btn-order">Back  </button>

            <?php
            echo '<input type="text" hidden name="action_type" value="' . $neededCode . '" />';

            echo '<button type="submit">Update</button>';
            echo '</form>';
        }

        else if ($stripeAccountObj->business_type=='individual' && $stripeAccountObj->individual->address->city ==null)
        {
            $neededCode = 'individual.city';

            $COUNTRY_OPTIONS = ["US" => "United States"];
            // Special case: address
            echo '<form action="./setup-action.php" method="POST">';
            ?>
            <!---->
            <div class="form-group col-md-6">
                <label class="title">Enter  first name <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="first name"  name="first">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Enter  last name <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="last name"  name="last">
            </div>

            <div class="form-group col-md-6">
                <label class="title">Enter Your Date of birth <span class="required">*</span></label>
                <input type="date" class="form-control" id="forLName" value="1990-10-24" placeholder="Date of birth" name="birth">
            </div>
            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter SSN Last 4<span class="required">*</span></label>-->
            <!--                <input type="number" class="form-control" id="forLName" maxlength="4" minlength="4" placeholder="SSN Last 4" name="ssn">-->
            <!--            </div>-->

            <div class="form-group col-md-6">
                <label class="title">Enter Email<span class="required">*</span></label>
                <input type="email" class="form-control" id="forLName"  placeholder="Email" name="email">
            </div>

            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter Phone number<span class="required">*</span></label>-->
            <!--                <input type="text" class="form-control" id="forLName"  placeholder="Phone number" name="phone">-->
            <!--            </div>-->

            <!---->
            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter Industry<span class="required">*</span></label>-->
            <!--                <input type="text" class="form-control" id="forLName"  placeholder="Enter Industry" name="industry">-->
            <!--            </div>-->
            <!---->
            <!---->
            <!--            <div class="form-group col-md-6">-->
            <!--                <label class="title">Enter Business website<span class="required">*</span></label>-->
            <!--                <input type="text" class="form-control" id="forLName"  placeholder="Business website" name="phone">-->
            <!--            </div>-->
            <!---->
            <!---->
            <!---->
            <div class="form-group col-md-6">
                <label class="title">Enter Your Address line1 <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="123 Fake Street" name="line_textbox">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Enter Your Address line2 <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="Apartment 1" name="line2_textbox">
            </div>  <div class="form-group col-md-6">
            <label class="title">Enter Your City <span class="required">*</span></label>
            <input type="text" class="form-control" id="forLName" placeholder="Toronto" name="city_textbox">
        </div>  <div class="form-group col-md-6">
            <label class="title">Enter Your  State <span class="required">*</span></label>
            <input type="text" class="form-control" id="forLName" placeholder="Ontario" name="state_textbox">
        </div>


            <div class="form-group col-md-6">
                <label class="title">Enter Your  Postal Code <span class="required">*</span></label>
                <input type="text" class="form-control" id="forLName" placeholder="M8K 8L3" name="postal_textbox">
            </div>
            <button type="button"  onclick="location.href='<?php echo 'setup-action.php' ?>'"  class="btn-order">Back  </button>

            <?php
            echo '<input type="text" hidden name="action_type" value="' . $neededCode . '" />';

            echo '<button type="submit">Update</button>';
            echo '</form>';
        }
//        else if (
//            $neededCode === 'legal_entity.address.city' ||
//            $neededCode === 'legal_entity.address.country' ||
//            $neededCode === 'legal_entity.address.line1' ||
//            $neededCode === 'legal_entity.address.line2' ||
//            $neededCode === 'legal_entity.address.postal_code' ||
//            $neededCode === 'legal_entity.address.state'
//        )


    else if ($stripeAccountObj->external_accounts->total_count==0) {
        if ($_SESSION['country']=='GB')
        {
            echo '<form id="bankingForm" method="POST">';
            echo '<input type="text" hidden name="country" id="country"   value="'.$_SESSION['country'].'" />';

            echo '<input type="text" hidden name="action_type" value="banking" />';
            echo '<input type="text" hidden name="currency" id="currency"  value="'.$_SESSION['currency'].'" />';


            # I recommend customizing this a little.
            echo '<div class="form-group col-md-6">';
            echo '<label class="title">Sort <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="Sort" id="routing_number" required />';
            echo ' </div>';

            echo '<div class="form-group col-md-6">';
            echo '<label class="title">Account Number <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="Account Number" id="account_number" required />';
            echo ' </div>';

            echo '<div class="form-group col-md-6">';
            echo '<label class="title">Account Holder Name <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="" id="account_holder_name" required />';
            echo ' </div>';



            ?>
            <div class="form-group col-md-6">
                <label class="title">Bank Account Type <span class="required">*</span></label>
                <select id="account_holder_type" required class="form-control">
                    <?php
                    $ACCOUNT_TYPE_OPTIONS = ['individual' => 'Individual', 'company'=>'Company'];
                    foreach ($ACCOUNT_TYPE_OPTIONS as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php
            ?>

            <button type="button"  onclick="location.href='<?php echo 'setup-action.php' ?>'"  class="btn-order">Back  </button>
            <?php
            echo '<button type="submit" class="btn-order">Update</button>';

            echo '</form>';
            ?>

        <?php
        }
        else if ($_SESSION['country']=='US'||$_SESSION['country']=='CA' || $_SESSION['country']=='AU' || $_SESSION['country']=='HK' || $_SESSION['country']=='SG' || $_SESSION['country']=='BR') {
            echo '<form id="bankingForm" method="POST">';
            echo '<input type="text" hidden name="country" id="country"   value="' . $_SESSION['country'] . '" />';

            echo '<input type="text" hidden name="action_type" value="banking" />';
            echo '<input type="text" hidden name="currency" id="currency"  value="' . $_SESSION['currency'] . '" />';


            # I recommend customizing this a little.
            echo '<div class="form-group col-md-6">';
            echo '<label class="title">Routing Number <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="Routing Number" id="routing_number" required />';
            echo ' </div>';

            echo '<div class="form-group col-md-6">';
            echo '<label class="title">Account Number <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="Account Number" id="account_number" required />';
            echo ' </div>';

            echo '<div class="form-group col-md-6">';
            echo '<label class="title">Account Holder Name <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="" id="account_holder_name" required />';
            echo ' </div>';


            ?>
            <div class="form-group col-md-6">
                <label class="title">Bank Account Type <span class="required">*</span></label>
                <select id="account_holder_type" required class="form-control">
                    <?php
                    $ACCOUNT_TYPE_OPTIONS = ['individual' => 'Individual', 'company'=>'Company'];
                    foreach ($ACCOUNT_TYPE_OPTIONS as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php
            ?>

            <button type="button"  onclick="location.href='<?php echo 'setup-action.php' ?>'"  class="btn-order">Back  </button>
            <?php

            echo '<button type="submit" class="btn-order">Update</button>';

            echo '</form>';

        }
        else
        {
            echo '<form id="bankingForm" method="POST">';
            echo '<input type="text" hidden name="country" id="country"   value="' . $_SESSION['country'] . '" />';

            echo '<input type="text" hidden name="action_type" value="banking" />';
            echo '<input type="text" hidden name="currency" id="currency"  value="' . $_SESSION['currency'] . '" />';


            # I recommend customizing this a little.


            echo '<div class="form-group col-md-6">';
            echo '<label class="title"> Number <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="Account Number" id="account_number" required />';
            echo ' </div>';

            echo '<div class="form-group col-md-6">';
            echo '<label class="title">Account Holder Name <span class="required">*</span></label> ';
            echo '<input type="text" class="form-control" placeholder="" id="account_holder_name" required />';
            echo ' </div>';


            ?>
            <div class="form-group col-md-6">
                <label class="title">Bank Account Type <span class="required">*</span></label>
                <select id="account_holder_type" required class="form-control">
                    <?php
                    $ACCOUNT_TYPE_OPTIONS = ['individual' => 'Individual', 'company'=>'Company'];
                    foreach ($ACCOUNT_TYPE_OPTIONS as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php
            ?>

            <button type="button"  onclick="location.href='<?php echo 'setup-action.php' ?>'"  class="btn-order">Back  </button>
            <?php
            echo '<button type="submit" class="btn-order">Update</button>';

            echo '</form>';

        }
            

        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
        echo '<script src="https://js.stripe.com/v3/"></script>';
        echo '<script>';
        echo 'var stripe = Stripe(\'pk_live_Wcw7r9g4zvNT5AFkQSFTp2rm00TBNZPrqG\', { stripeAccount: \'' . $stripeAccountId . '\' });';            echo '</script>';
        echo '<script src="./bank-account.js"></script>';
    }




//        else if ($neededCode == 'legal_entity.verification.document') {
//            // Special case:
//            echo '<form action="./setup-action.php" method="POST" enctype="multipart/form-data">';
//            echo '<input type="text" hidden name="action_type" value="' . $neededCode . '" />';
//            # I recommend customizing this a little.
//            echo '<label>' . $neededCode . '</label><br/>';
//            echo '<input type="file" name="fileToUpload" required /><br/>';
//            echo '<button type="submit">Update</button>';
//            echo '</form>';
//        }
    else
    {

        $stmt = $conn->prepare("INSERT INTO `iz_vendor_stripe`(`account`,`token`, `vendor`) VALUES (?, ?, ?)");

        $execute_query = $stmt->execute([$_SESSION['stripeAccountId'], $_SESSION['token'],$_SESSION['user'][0]->user_id]);
        $stmt = null;
        echo 'you have finished setup payments for stripe ';



    }


}
?>
    </div>
    </div>
    </div>
    </main>
<?php include 'includes/footer2.php' ?>
    <script type="text/javascript">
        function get_category(val){
            var type_id = val;
            if (type_id != '')
            {
                $.ajax({
                    url: 'vendor_actions/ajax/ajax_get_product_details.php',
                    data: {type_id: type_id , operation: 'get_sports_category_data'},
                    type: 'POST',
                    success: function(res){
                        $('#cat_data').html(res);
                    }
                });
            }
        }
        function get_brands(cat_id,user_id){
            var product_id = 6;
            if (cat_id != '')
            {
                $.ajax({
                    url: 'vendor_actions/ajax/ajax_get_brands_details.php',
                    data: {cat_id: cat_id, product_id: product_id, user_id: user_id, operation: 'get_brands_data'},
                    type: 'POST',
                    success: function(res){
                        $('#sports_brands').html(res);
                    }
                });
            }
        }
    </script>
<?php include 'includes/footer_script.php' ?>


<!--    else if ($stripeAccountObj->business_type=='company' && $stripeAccountObj->company->address->city ==null)-->
<!--    {-->
<!--    $neededCode = 'company.city';-->
<!---->
<!--    $COUNTRY_OPTIONS = ["US" => "United States"];-->
<!--    // Special case: address-->
<!--    echo '<form action="./setup-action.php" method="POST">';-->
<!--    ?>-->
<!--    <div class="form-group col-md-6">-->
<!--        <label class="title">Enter Your Address line1 <span class="required">*</span></label>-->
<!--        <input type="text" class="form-control" id="forLName" placeholder="123 Fake Street" name="line_textbox">-->
<!--    </div>-->
<!--    <div class="form-group col-md-6">-->
<!--        <label class="title">Enter Your Address line2 <span class="required">*</span></label>-->
<!--        <input type="text" class="form-control" id="forLName" placeholder="Apartment 1" name="line2_textbox">-->
<!--    </div>  <div class="form-group col-md-6">-->
<!--        <label class="title">Enter Your City <span class="required">*</span></label>-->
<!--        <input type="text" class="form-control" id="forLName" placeholder="Toronto" name="city_textbox">-->
<!--    </div>  <div class="form-group col-md-6">-->
<!--        <label class="title">Enter Your  State <span class="required">*</span></label>-->
<!--        <input type="text" class="form-control" id="forLName" placeholder="Ontario" name="state_textbox">-->
<!--    </div>-->
<!---->
<!--    <div class="form-group col-md-6">-->
<!--        <label class="title">Enter Your  Country <span class="required">*</span></label>-->
<!--        <select name="country_textbox" required class="form-control">-->
<!--            --><?php
//
//            foreach ($COUNTRY_OPTIONS as $key => $value) {
//                echo '<option value="' . $key . '">' . $value . '</option>';
//            }
//            ?>
<!--        </select>-->
<!--    </div>-->
<!--    <div class="form-group col-md-6">-->
<!--        <label class="title">Enter Your  Postal Code <span class="required">*</span></label>-->
<!--        <input type="text" class="form-control" id="forLName" placeholder="M8K 8L3" name="postal_textbox">-->
<!--    </div>-->
<?php
//echo '<input type="text" hidden name="action_type" value="' . $neededCode . '" />';
//
//echo '<button type="submit">Update</button>';
//echo '</form>';

