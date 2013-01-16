<?php
//modified by Alex Perez from http://www.freecontactform.com/email_form.php
// Validates input fields for existence and correct format 
// Required fields in POST http request -
// JS enabled:
// - name
// - email
// - msginput
// JS disabled:
// - namebox
// - contactbox
// - messagebox

function died($error) {
    // your error code can go here
    echo "We are very sorry, but there were error(s) found with the form you submitted. ";
    echo "These errors appear below.<br /><br />";
    echo $error."<br /><br />";
    echo "Please go back and fix these errors.<br /><br />";

    die();
}

function clean_string($string) {
  $bad = array("content-type","bcc:","to:","cc:","href");
  return str_replace($bad,"",$string);
}

//DEBUG: change this to the proper address after testing     
$destination_address = "contact@thinktankgoesboom.com"; 

//get form information - DEFAULTS to JS-enabled values
$name = $_POST['name'];
$email_from = $_POST['email'];
$message = $_POST['msginput'];

//test if JS disabled to change what we're looking for
if(isset($_POST['jsdisabled'])){
    $name = $_POST['namebox'];
    $email_from = $_POST['contactbox'];
    $message = $_POST['messagebox'];
}

//validate that expected data exists
if(!isset($name) || !isset($email_from) || !isset($message)) {
    died('Hey! Please go back in your browser history and make sure all the fields are filled out correctly, ThinkTank wants to know who we\'re talking to!');      
}

//validate the email address is in the correct form 
$error_message = "";
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

if(!preg_match($email_exp,$email_from)) {
  $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  died($error_message);
}

// create email headers
$headers = 'From: '.$email_from."\r\n".
           'Reply-To: '.$email_from."\r\n" .
           'X-Mailer: PHP/' . phpversion();

//construct the message
$email_to = $destination_address; 
$email_subject = "Message from " . clean_string($email_from); 

$email_message = "Form details below.\n\n";
$email_message .= "Email: ".clean_string($email_from)."\n";   
$email_message .= "Name: " .clean_string($name)."\n";
$email_message .= "Comments: ".clean_string($message)."\n";

if(mail($email_to, $email_subject, $email_message, $headers)){
    //send success to the ajax requester
    echo "<h2>Contact Form Submitted!</h2><p>We will be in touch soon.</p>";
}

?>
