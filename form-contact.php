<?php
include "top.php";


// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.

$debug = false;

// If statement to help find errors later

if (isset($_GET["debug"])) {
    $debug = true;
}

if ($debug) {
    print "<p>DEBUG MODE IS ON</p>";
}


//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.

//$thisURL = $domain . $phpSelf;



//
// SECTION: 1c form variables
//
// Initialize variables for each form element
// ***in the order they appear on the form

$fan = true;
$agent = false;
$client = false;

$checkBoxSet = false;

$male = false;
$female = false;
$other = false;

if (isset($_GET['updateID'])){
        $updateID = htmlentities($_GET['updateID'], ENT_QUOTES, "UTF-8");

        //if($updateID > 0){
            $update = true;
        //}

        $query = 'SELECT * FROM tblMailList WHERE pmkContactId = ?' ;
        //$query .= $updateID;
        $data = array($updateID);

        if ($thisDatabaseReader->querySecurityOk($query, 1)) {
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $contact = $thisDatabaseReader->select($query, $data);
        }

        $firstName = $contact[0]["fldFirstName"];
        $lastName= $contact[0]["fldLastName"];
        $email = $contact[0]["fldEmail"]; 
        $ageRange = $contact[0]["fldAgeRange"];
        $gender = $contact[0]["fldGender"];
}else{
    $firstName= "";
    $lastName="";
    $email = "";
    $ageRange = "10-19";
    $gender = "Male";
}

// SECTION: 1d form error flags
//
// Initialize Error Flags for each form element
// ****in the order they appear in section 1c.

$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;




// SECTION: 1e misc variables
//
// create array to hold error messages 

$errorMsg = array();
$data = array();
$dataEntered = false; 
 

// have we mailed the information to the user?

$mailed=false;


// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
    
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

    $updateID = (int) htmlentities($_POST["hidContactId"], ENT_QUOTES, "UTF-8");
        if ($updateID > 0) {
            $update = true;
        }
    
    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $data[] = $firstName;
    
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $data[] = $lastName;
    
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);    
    $data[]= $email;
    
    $ageRange = htmlentities($_POST["lstAgeRange"], ENT_QUOTES, "UTF-8");
    $data[] = $ageRange;
    
    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $data[] = $gender;
    
    if (isset($_POST["chkFan"])) {
        $fan = true;
    } else {
        $fan = false;
    }
    //$data[] = $fan;
            
    if (isset($_POST["chkAgent"])) {
        $agent = true;
    } else {
        $agent = false;
    }
    //$data[] = $agent;
            
    if (isset($_POST["chkClient"])) {
        $agent = true;
    } else {
        $agent = false;
    }
    //$data[] = $agent;
    
    $query = 'SELECT * FROM tblMailList WHERE fldFirstName = ? ';


        if ($thisDatabaseReader->querySecurityOk($query, 1)) {
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $contact = $thisDatabaseReader->select($query, array($firstName));
        }

        $contactID = $contact[0]["pmkContactId"];
         
        print $query . $firstName . $contactID;
        print_r($contact);      
    // SECTION: 2c Validation

    
    
    
    
    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    }
//    elseif (!verifyAlphaNum($firstName)) {
//        $errorMsg[] = "Your first name appears to have extra characters.";
//        $firstNameERROR = true;
//    }
    
    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    }
//    elseif (!verifyAlphaNum($lastName)) {
//        $errorMsg[] = "Your last name appears to have extra characters.";
//        $lastNameERROR = true;
//    }
    
    
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    }
//    elseif (!verifyEmail($email)) {
//        $errorMsg[] = "Your email address appears to be incorrect.";
//        $emailERROR = true;
//    }
    

    
    
    
    
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    if (!$errorMsg) {
        if ($debug){
            print "<p>Form is valid</p>"; 
            
        }   
    
             

        
        
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.
        
        //TODO: ADD SAVE TO DATABASE INSTEAD OF CSV FILE
     
        
        try {
                $thisDatabaseWriter->db->beginTransaction();

                //If updating, call UPDATE SQL command
                if ($update) {
                    $query = 'UPDATE tblMailList SET ';
                //Otherwise call INSERT SQL command
                } else {
                    $query = 'INSERT INTO tblMailList SET ';
                    print_r($query);
                }

                
                $query .= 'fldFirstName = ?, ';
                $query .= 'fldLastName = ?, ';
                $query .= 'fldEmail = ?, ';
                $query .= 'fldAgeRange = ?, ';
                $query .= 'fldGender= ? ';

                if ($update) {
                    $query .= 'WHERE pmkContactId = ?';
                    $data[] = $updateID;


                    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->update($query, $data);
                    }

                } else {

                    // You really don't need to test this query, i left it here for you.

                    if ($debug) {
                        $thisDatabaseWriter->TestSecurityQuery($query, 0);
                        
                    }

                    if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->insert($query, $data);
                        $primaryKey = $thisDatabaseWriter->lastInsert();
                        print_r($data);
                    }

                    if ($debug) {
                        print "<p>pmk= " . $primaryKey;
                    }
                }  


                //Insert tags data to tblMailListContactType
                if (isset($_POST["chkFan"])){
                    $checkBoxSet = true;
                    $query = 'INSERT INTO tblMailListContactType SET ';
                    $query .= 'fnkContact = ?, ';
                    $query .= 'fnkType = ? ';
                    $dataFan = array($contactID, 1);     
                    if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->insert($query, $dataFan);
                        $primaryKey = $thisDatabaseWriter->lastInsert();
                    }
                    print_r($query);
                    print_r($dataFan);

                }

                if (isset($_POST["chkAgent"])){
                    $checkBoxSet = true;
                    $query = 'INSERT INTO tblMailListContactType SET ';
                    $query .= 'fnkContact = ?, ';
                    $query .= 'fnkType = ? ';
                    $dataAgent = array($contactID, 2);     
                    if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->insert($query, $dataAgent);
                        $primaryKey = $thisDatabaseWriter->lastInsert();
                    }        

                }

                if (isset($_POST["chkClient"])){
                    $checkBoxSet = true;
                    $query = 'INSERT INTO tblMailListContactType SET ';
                    $query .= 'fnkContact= ?, ';
                    $query .= 'fnkType = ? ';
                    $dataClient = array($contactID, 3);     

                    if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                        $query = $thisDatabaseWriter->sanitizeQuery($query);
                        $results = $thisDatabaseWriter->insert($query, $dataClient);
                        $primaryKey = $thisDatabaseWriter->lastInsert();
                    }   
                    }        

                


//                //If no check boxes are selected, delete all records with that ID
//                if(!$checkBoxSet){
//                    $query = 'DELETE FROM tblMailListContactType ';
//                    $query .= 'WHERE pfkTrailId = ? ';
//                    $data1[] = $trailID;
//
//                    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
//                        $query = $thisDatabaseWriter->sanitizeQuery($query);
//                        $results = $thisDatabaseWriter->delete($query, $data1);
//                    }
//
//                }



                // all sql statements are done so lets commit to our changes

                $dataEntered = $thisDatabaseWriter->db->commit();

                if ($debug)
                    print "<p>transaction complete ";
            } catch (PDOExecption $e) {
                $thisDatabase->db->rollback();
                if ($debug)
                    print "Error!: " . $e->getMessage() . "</br>";
                $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
            }

        }
    
    
    
    
    
        
        
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).
        $message= '<h2>Your information:</h2>';
        
        foreach ($_POST as $key => $value) {
            if ($key=="chkFan" || $key=="chkAgent" || $key=="chkClient"){
                $value="Checked";

            }
            
        
            
            if ($key!="btnSubmit" && $key != "hidContactId"){
                
                $message .= "<p class=confirm>";
            
                //breaks up the form names into words.
            
                $camelCase= preg_split('/(?=[A-Z])/', substr($key, 3));
            
                foreach ($camelCase as $one) {
                    $message .= $one . " ";
                }
            
                $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            
            }
     
        
        }
    
    
    
    
    
    
    
    
    
    
       
            
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        
        if (!$update){
            $to= $email; //the person who filled out the form
            $cc= "";
            $bcc= "";
        
            $from = "Craig Holcomb Jr. <noreply@craigholcombjr.com>";
        
            $todaysDate = strftime("%x");
            $subject="Craig Holcomb Jr. Contact Request " . $todaysDate;

        
            $mailed= sendMail($to, $cc, $bcc, $from, $subject, $message);
   
        
    } // end form is valid

}// ends if form was submitted.




// SECTION 3 Display Form
//
?>

<article id="main">
    
    <?php
    print('<p>User: '. $username . '</p>');
    if($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){
        print('<p>Admin = True</p>');
    }
    ?>
    
    <h2>Contact</h2>

    <?php
    
    
    //
    // SECTION 3a. 
    // 
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit 
        print "<h2 id= processed> Your Request has ";
 
        print "been processed</h2>";
    
        print "<p class=confirm>A copy of this message has ";
    
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p class=confirm>To: " . $email . "</p>";
    
        print "<p class=confirm2>Mail Message:</p>";
    
        print $message;
        die;
    
    } else {
    
     
        
        
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
   
    if ($errorMsg) {
        print '<div id="errors">' . "\n";
        print "<h2 id='mistakes'>Your form has the following mistakes that need to be fixed:</h2>\n";
        print "<ol>\n";
        
        foreach ($errorMsg as $err) {
            print "<li>" . $err . "</li>\n";
        }
        
        print "</ol>\n";
        print "</div>\n";
    }
    }
        
        
        // SECTION 3c html Form
        //
        
    ?>
    
    
    
    




    <p>
        Please complete the following for if you would like to get in contact with Craig Holcomb Jr. After 
        submitting, you will receive a confirmation email. After that time, feel free to email Craig with any
        questions or inquiries you may have. Be sure to mark the reason for your contact request in the form below. 
        Thank you for your interest!
    </p>
   
    
</article>


<article>
    <form action='../CraigHolcombJr/form-contact.php'
          method="post"
          id='frmSubscribe'>
        
        <input type="hidden" id="hidContactId" name="hidContactId"
                       value="<?php print $updateID; ?>"
                       >
    
        <fieldset class='wrapper'>
            <legend>Please Join Us!</legend>
            
            <fieldset class='wrapper2'>
                <legend>Complete the following form</legend>
                
                <fieldset class='contactInfo'>
                    <legend>Contact Information</legend>
                    <label for="txtFirstName" class="required">First Name
                        <input type="text"
                               id="txtFirstName"
                               name="txtFirstName"
                               value="<?php print $firstName;?>"
                               tabindex="50"
                               maxlength="35"
                               placeholder="Enter your first name"
                               <?php if ($firstNameERROR) {print 'class="mistake"';} ?>
                               onfocus="this.select()"
                               autofocus>
                    </label>
                    
                    <label for="txtLastName" class="required">Last Name
                        <input type="text"
                               id="txtLastName"
                               name="txtLastName"
                               value="<?php print $lastName;?>"
                               tabindex="70"
                               maxlength="45"
                               placeholder="Enter your last name"
                               <?php if ($firstNameERROR) {print 'class="mistake"';} ?>
                               onfocus="this.select()"
                               >
                    </label>
                    
                    <label for='txtEmail' class='required'>Email
                        <input type='text' 
                               id='txtEmail' 
                               name='txtEmail'
                               value='<?php print $email;?>'
                               tabindex="150"
                               maxlength="40"
                               placeholder="Please enter valid email"
                               <?php if ($emailERROR) {print 'class="mistake"';} ?>
                               onfocus="this.select()">
                        
                    </label>
                </fieldset>
                
                <fieldset class="listbox">
                    <label for="lstAgeRange">Age Range</label>
                    <select id="lstAgeRange"
                            name="lstAgeRange"
                            tabindex="200">
                        <option <?php if($ageRange=="0-9") {print"selected";}?>
                            value="0-9">0-9</option>
                        <option <?php if($ageRange=="10-19") {print"selected";}?>
                            value="10-19">10-19</option>
                        <option <?php if($ageRange=="20-29") {print"selected";}?>
                            value="20-29">20-29</option>
                        <option <?php if($ageRange=="30-39") {print"selected";}?>
                            value="30-39">30-39</option>
                        <option <?php if($ageRange=="40-49") {print"selected";}?>
                            value="40-49">40-49</option>
                        <option <?php if($ageRange=="50-59") {print"selected";}?>
                            value="50-59">50-59</option>
                        <option <?php if($ageRange=="60+") {print"selected";}?>
                            value="60+">60+</option>
                    </select>
                </fieldset>
                
                <fieldset class="radio">
                    <legend>What is your gender?</legend>
                    <label>
                        <input type="radio"
                               id="radMale"
                               name="radGender"
                               value="Male"
                               <?php if ($gender == "Male") {print 'checked';}?>
                               tabindex="250">Male</label>
                    
                    <label>
                        <input type="radio"
                               id="radFemale"
                               name="radGender"
                               value="Female"
                               <?php if ($gender == "Female") {print 'checked';}?>
                               tabindex="260">Female</label>
                    
                    <label>
                        <input type="radio"
                               id="radOther"
                               name="radGender"
                               value="Other"
                               <?php if ($gender == "Other") {print 'checked';}?>
                               tabindex="270">Other</label>
                    
                </fieldset>
                
                <fieldset class="checkbox">
                    <legend>Options:</legend>
                    <label>
                        <input type="checkbox"
                               id="chkFan"
                               name="chkFan"
                               value="fan"
                               <?php if ($fan) {print "checked";} ?>
                               tabindex="300">I am a fan.</label>
                    
                    <label>
                        <input type="checkbox"
                               id="chkAgent"
                               name="chkAgent"

                               value="agent"
                               <?php if ($agent) {print "checked";} ?>
                               tabindex="310">I am an agent.</label>
                    
                    <label>
                        <input type="checkbox"
                               id="chkClient"
                               name="chkClient"

                               value="client"
                               <?php if ($client) {print "checked";} ?>
                               tabindex="320">I am a client.
                    
                    </label>
                       
     
            </fieldset>
                
                
                
            <fieldset class="button">
            <legend></legend>
            <input type="submit" 
                 id="btnSubmit" 
                 name="btnSubmit" 
                 value="Join" 
                 tabindex="800" 
                 class="button">
            </fieldset>          
        </fieldset>
        </fieldset>                           
    </form>
</article>

<?php
$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
if ($username == "abatisto" || $username == "rerickso" || $username == "ylin19"){
    print '<a id = "edit" href = "contactRecords.php">[Edit Records]</a>';
    print '<a id = "tables" href = "tables.php">Tables.php</a>';
}
include("footer.php");
?>


