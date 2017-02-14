<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $category = trim($_POST["category"]);
    $title = trim($_POST["title"]);
    $format = trim($_POST["format"]);
    $genre = trim($_POST["genre"]);
    $year = trim($_POST["year"]);
    $suggest = trim($_POST["suggest"]);

    if ($name == "" || $email == "" || $category == "" || $title == "")
    {
        $error_message = "Please fill in the required fields: Name, Email, Category, Title";
    }
    if ($_POST["blank"] != "") {
        $error_message = "Bad form input";
    }
    require ("includes/phpmailer/class.phpmailer.php");
    $mail = new PHPMailer;

    if ($email != "" && !$mail->ValidateAddress($email)) {
        $error_message = "Invalid Email address";
    }
    if (!isset($error_message))
    {
        $email_body = "";
        $email_body .= "Name $name \n";
        $email_body .= "Email $email \n";
        $email_body .= "Category $category \n";
        $email_body .= "Title $title \n";
        $email_body .= "Feature \n";
        $email_body .= "Format $format \n";
        $email_body .= "Genre $genre \n";
        $email_body .= "Year $year \n";
        $email_body .= "Suggest $suggest \n";

        $mail->setFrom($email, $name);
        $mail->addAddress('treehouse@localhost', 'Etienne');     // Add a recipient
        $mail->isHTML(false);                                  // Set email format to HTML

        $mail->Subject = "Personal Media Library Suggestion from $name";
        $mail->Body    = $email_body;

        if ($mail->send()) {
            header("location:suggest.php?status=thanks");
            exit;
        }
        $error_message = 'Message could not be sent.';
        $error_message .= 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
$pageTitle = "Suggestions";
$currentPage = "Suggest";
include("includes/header.php");?>
<div class="section page">
    <div class="wrapper">
        <?php
        if (isset($_GET["status"]) && $_GET["status"] == "thanks")
        { ?>
            <h1>Thank you</h1>
            <p>Thanks for the mail! I'll check your suggestion shortly!</p>
        <?php } else {
                if (isset($error_message))
                { ?>
                    <p class="message"><?php echo $error_message; ?></p>
                <?php } else { ?>
                    <h1>Suggest a Media Item</h1>
                    <p>If you think there is something I'm missing, let me know! Complete the form to send me an email.</p>
                <?php } ?>
            <form method="post" action="suggest.php">
                <table>
                    <tr>
                        <th><label for="name">Name*: </label></th>
                        <td><input type="text" id="name" name="name" value="<?php if (isset($name)){echo $name;}?>"/></td>
                    </tr>
                    <tr>
                        <th><label for="email">Email*: </label></th>
                        <td><input type="text" id="email" name="email" value="<?php if (isset($email)){echo $email;}?>"/></td>
                    </tr>
                    <tr>
                        <th><label for="category">Category*: </label></th>
                        <td>
                            <select id="category" name="category">
                                <option value="">Select a category</option>
                                <option value="books" <?php if ($category == "books"){echo "selected";}?>>Book</option>
                                <option value="movies" <?php if ($category == "movies"){echo "selected";}?>>Movie</option>
                                <option value="music" <?php if ($category == "music"){echo "selected";}?>>Music</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="title">Title*: </label></th>
                        <td><input type="text" id="title" name="title" value="<?php if (isset($title)){echo $title;}?>"/></td>
                    </tr>
                    <tr>
                        <th>
                            <label for="format">Format</label>
                        </th>
                        <td>
                            <select name="format" id="format">
                                <option value="">Select One</option>
                                <optgroup label="Books">
                                    <option value="Audio"<?php
                                    if (isset($format) && $format=="Audio") {
                                        echo " selected";
                                    } ?>>Audio</option>
                                    <option value="Ebook"<?php
                                    if (isset($format) && $format=="Ebook") {
                                        echo " selected";
                                    } ?>>Ebook</option>
                                    <option value="Hardcover"<?php
                                    if (isset($format) && $format=="Hardcover") {
                                        echo " selected";
                                    } ?>>Hardcover</option>
                                    <option value="Paperback"<?php
                                    if (isset($format) && $format=="Paperback") {
                                        echo " selected";
                                    } ?>>Paperback</option>
                                </optgroup>
                                <optgroup label="Movies">
                                    <option value="Blu-ray"<?php
                                    if (isset($format) && $format=="Blu-ray") {
                                        echo " selected";
                                    } ?>>Blu-ray</option>
                                    <option value="DVD"<?php
                                    if (isset($format) && $format=="DVD") {
                                        echo " selected";
                                    } ?>>DVD</option>
                                    <option value="Streaming"<?php
                                    if (isset($format) && $format=="Streaming") {
                                        echo " selected";
                                    } ?>>Streaming</option>
                                    <option value="VHS"<?php
                                    if (isset($format) && $format=="VHS") {
                                        echo " selected";
                                    } ?>>VHS</option>
                                </optgroup>
                                <optgroup label="Music">
                                    <option value="Cassette"<?php
                                    if (isset($format) && $format=="Cassette") {
                                        echo " selected";
                                    } ?>>Cassette</option>
                                    <option value="CD"<?php
                                    if (isset($format) && $format=="CD") {
                                        echo " selected";
                                    } ?>>CD</option>
                                    <option value="MP3"<?php
                                    if (isset($format) && $format=="MP3") {
                                        echo " selected";
                                    } ?>>MP3</option>
                                    <option value="Vinyl"<?php
                                    if (isset($format) && $format=="Vinyl") {
                                        echo " selected";
                                    } ?>>Vinyl</option>
                                </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="genre">Genre</label>
                        </th>
                        <td>
                            <select name="genre" id="genre">
                                <option value="">Select One</option>
                                <?php
                                $genreArray = ft_get_array();
                                foreach ($genreArray as $cat=>$gens) {
                                    echo "<optgroup label=\"$cat\">"
                                    foreach($cat as $gen) {
                                        echo "<option value=\"$gen\""
                                        if (isset($genre) && $genre == $gen) {
                                            echo " selected";
                                        }
                                        echo ">$gen</option>";
                                    }
                                    echo "</optgroup>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="year">Year: </label></th>
                        <td><input type="text" id="year" name="year"  value="<?php if (isset($year)){echo $year;}?>"/></td>
                    </tr>
                    <tr>
                        <th><label for="suggest">Suggest: </label></th>
                        <td><textarea name="suggest" id="suggest"> <?php if (isset($suggest)){echo $suggest;}?></textarea></td>
                    </tr>
                    <tr style="display:none">
                        <th><label for="blank">Suggest: </label></th>
                        <td><input name="blank" id="blank"/>
                        <p>Please let this field blank!</p></td>
                    </tr>
                </table>
            <input type="submit" value="Send"/>
            <p style="color:#cf4014">*: Required field</p>
            </form>
        <?php } ?>
    </div>
</div>
<?php include("includes/footer.php"); ?>
