<?php
require 'assets/PHPMailer.php';
require 'assets/SMTP.php';
require 'assets/Exception.php';

use PHPMAILER\PHPMAILER\PHPMAILER;
use PHPMAILER\PHPMAILER\SMTP;
use PHPMAILER\PHPMAILER\Exception;

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com"; // je suis censée mettre une adresse mais je n'ai pas compris laquelle
$mail->SMTPAuth = "true";
$mail->SMTPSecure = "tls";
$mail->Port = "587"; // ????
$mail->Username = "evelynecolacogarcia1988@gmail.com"; // je dois mettre une adresse encore une fois 
$mail->Password = "SimplePassword"; // mot de passe 
$mail->Subject = "Test Email Using PHPMailer";
$mail->setFrom("evelynecolacogarcia1988@gmail.com");//une adresss mail entre les parenthèses
$mail->Body = "This is plain text email body";
$mail->addAddress("");
if ($mail->Send() ){
  echo "Email Sent !";
}else{
  echo "Error..!";
}
$mail->smtpClose();




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackers Poulette ™ Form</title>
    <style>
        .error {color: #FF0000;}
    </style>
   <link rel="icon" type="image/png" href="assets/logo.png">
</head>
<body>
<header>
<h1>Hackers Poulette complain form</h1>
<img src="assets/logo.png" alt="logo">
</header>

<?php
// define variables and set to empty values
$firstnameErr = $lastnameErr = $genderErr = $emailErr = $countryErr = "";
$firstname = $lastname = $gender = $email = $country = $subject = $comment = "";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// email sending
$message = "your complaint form has been sent perfectly. We will get back to you shortly.";


$message = wordwrap($message, 70, "\r\n");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
      $firstnameErr = "firstname is required";
    } else {
      $firstname = test_input($_POST["firstname"]);
      // check if name only contains letters and whitespace
    if (preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
        filter_var($firstname, FILTER_SANITIZE_STRING);
      } else {
        $firstnameErr = "Only letters and white space allowed";
      }
    }

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Lastname is required";
      } else {
        $lastname = test_input($_POST["lastname"]);
        // check if name only contains letters and whitespace
    if (preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
      filter_var($lastname, FILTER_SANITIZE_STRING);        
      } else {
        $lastnameErr = "Only letters and white space allowed";
      }
      }

      if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
      } else {
        $gender = test_input($_POST["gender"]);
      }
    
    if (empty($_POST["email"])) {
      $emailErr = "Email is required";
    } else {
      $email = test_input($_POST["email"]);
      // check if e-mail address is well-formed
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        filter_var($email, FILTER_SANITIZE_EMAIL);
      } else {
        $emailErr = "Please enter a valid email format like : John.Doe@gmail.com";
      }
    }
      
    if (empty($_POST["country"])) {
      $country = "";
    } else {
      $country = test_input($_POST["country"]);
    }

    if (empty($_POST["subject"])) {
        $subject = "";
      } else {
        $subject = test_input($_POST["subject"]);
      }
  
    if (empty($_POST["comment"])) {
      $comment = "";
    } else {
      $comment = test_input($_POST["comment"]);
    }
  
    mail($email, 'Your complaint form', $message);
  }


?>



    <form method='post' id='form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="user">
        <label for="firstname">Firstname : </label><input type="text" name="firstname" id="firstname"><span class="error"> * <?php echo $firstnameErr;?></span>
        <label for="lastname">Lastname : </label><input type="text" name="lastname" id="lastname"><span class="error"> * <?php echo $lastnameErr;?></span>
    </div>
    <div class='gender'>
        <p> Select your gender : 
        <input type='radio' name='gender' value='male' id='male'> Man 
        <input type='radio' name='gender' value='female' id='female'> Woman 
        <input type='radio' name='gender' value='other' id='other'> Other <span class="error"> * <?php echo $genderErr;?></span></p>
    </div>
    <div class="email">
        <label for="email">Your email address :</label>
        <input type="text" name="email" id="email"><span class="error"> * <?php echo $emailErr;?></span><br><br>
    </div>
    <div class='country'>
        <label for="country">Select a country : </label><select name='country' id='country' required> 
            <option value=''> --- </option>
            <option value='Belgium'> Belgium </option>
            <option value='France'> France </option>
            <option value='Spain'> Spain </option>
            <option value='Portugal'> Portugal </option>
            <option value='Netherlands'> Netherlands </option>
            <option value='Germany'> Germany </option>
            <option value='Luxembourg'> Luxembourg </option>
        </select><span class="error"> * </span><br><br>
    </div>
    <div class='subject'>
        <label for='subject'>Subject of your complain : </label><select name='subject' id='subject'>
            <option value=''> --- </option>
            <option value='Delivery problem'> Delivery problem </option>
            <option value='Defective parts'> Defective parts </option>
            <option value='Other'> Other </option>
        </select><br><br>
    </div>
    <div class='comment'>
        <label for='comment'> Comment : 
        <textarea id='comment' name='comment'rows="3" cols="45"><?php echo $comment;?></textarea>
    </div>
    <br>
    <p><span class="error"> * required field.</span></p>
    <input type='submit' value='Send your form'>
    </form>

    <?php
/*echo "<h2>Your Input:</h2>";
echo $firstname;
echo "<br>";
echo $lastname;
echo "<br>";
echo $gender;
echo "<br>";
echo $email;
echo "<br>";
echo $country;
echo "<br>";
echo $subject;
echo "<br>";
echo $comment;
echo "<br>";
*/
?>
<footer>

</footer>

</body>
</html>