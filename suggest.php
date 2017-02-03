<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $suggest = trim($_POST["suggest"]);

    if ($name == "" || $email == "" || $suggest == "")
    {
        echo "Please fill in the required fields: Name, Email, Suggest";
        exit;
    }
    if ($_POST["blank"] != "") {
        echo "Bad form input";
        exit;
    }
    require ("includes/phpmailer/class.phpmailer.php");
    $mail = new PHPMailer;

    if (!$mail->ValidateAddress($email)) {
        echo "Invalid Email address";
        exit;
    }
    $email_body = "";
    $email_body .= "Name $name \n";
    $email_body .= "Email $email \n";
    $email_body .= "Suggest $suggest \n";

    $mail->setFrom($email, $name);
    $mail->addAddress('treehouse@localhost', 'Etienne');     // Add a recipient
    $mail->isHTML(false);                                  // Set email format to HTML

    $mail->Subject = "Personal Media Library Suggestion from $name";
    $mail->Body    = $email_body;

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;
    } else {
        header("location:suggest.php?status=thanks");
    }
}
$pageTitle = "Suggestions";
$currentPage = "Suggest";
include("includes/header.php");?>
<div class="section page">
    <div class="wrapper">
        <?php
        if (isset($_GET["status"]) && $_GET["status"] == "thanks")
        {?>
            <h1>Thank you</h1>
            <p>Thanks for the mail! I'll check your suggestion shortly!</p>
        <?php } else { ?>
            <h1>Suggest a Media Item</h1>
            <p>If you think there is something I'm missing, let me know! Complete the form to send me an email.</p>
            <form method="post" action="suggest.php">
                <table>
                    <tr>
                        <th><label for="name">Name: </label></th>
                        <td><input type="text" id="name" name="name" /></td>
                    </tr>
                    <tr>
                        <th><label for="email">Email: </label></th>
                        <td><input type="text" id="email" name="email" /></td>
                    </tr>
                    <tr>
                        <th><label for="suggest">Suggest: </label></th>
                        <td><textarea name="suggest" id="suggest"></textarea></td>
                    </tr>
                    <tr style="display:none">
                        <th><label for="blank">Suggest: </label></th>
                        <td><input name="blank" id="blank"/>
                        <p>Please let this field blank!</p></td>
                    </tr>
                </table>
            <input type="submit" value="Send"/>
            </form>
        <?php } ?>
    </div>
</div>
<?php include("includes/footer.php"); ?>
