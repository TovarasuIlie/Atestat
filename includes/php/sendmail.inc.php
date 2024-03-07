<?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['sendmail-logout'])) {


        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $emailrepeat = $_POST['emailrepeat'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $conditions = $_POST['conditions'];

        if(empty($firstname) || empty($lastname) || empty($email) || empty($emailrepeat) || empty($subject) || empty($message)) {
            header("Location: ../../contact.php?msg=emptyfields");
            exit();
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../../contact.php?msg=invalidmail");
            exit();
        } else if($email != $emailrepeat) {
            header("Location: ../../contact.php?msg=emaildontmatch");
            exit();
        } else if($conditions[0] != "checked") {
            header("Location: ../../contact.php?msg=notchecked");
            exit();
        } else {
                require 'connect.php';
                if($HOST_TYPE == "LOCALHOST") {

                    // Import PHPMailer classes into the global namespace
                    // These must be at the top of your script, not inside a function
                    // Load Composer's autoloader
                    require 'PHPMailer/PHPMailer.php';
                    require 'PHPMailer/SMTP.php';
                    require 'PHPMailer/Exception.php';

                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    //Server settings
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'volvofan.ro@gmail.com';                     // SMTP username
                    $mail->Password   = 'Nilietraian1';                               // SMTP password
                    $mail->SMTPSecure = 'TLS';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom($email, 'De la: "'.$firstname.' '.$lastname.'" trimis de pe VolvoFAN.ro');
                    $mail->addAddress('volvofan.ro@gmail.com');
                    $mail->addReplyTo($email, $firstname.' '.$lastname);
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;

                    if($mail->send()) {
                        header("location: ../../contact.php?msg=success");
                        exit();
                    } else {
                        header("location: ../../contact.php?msg=error");
                        exit();
                    }
                } else {
                    $headers = "From: " . $email . "\r\n";
                    $headers .= "Reply-To: ". $email . "\r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    if(mail('volvofan.ro@gmail.com', $subject, $message, $headers)) {
                        header("location: ../../contact.php?msg=success");
                        exit();
                    } else {
                        header("location: ../../contact.php?msg=error");
                        exit();
                    };
                }
            }
    }

    if(isset($_POST['sendmail-login'])) {

        require 'connect.php';
        session_start();
        $username = $_SESSION['username'];
        $firstname = $_SESSION['firstname'];
        $lastname = $_SESSION['lastname'];
        $email = $_SESSION['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $conditions = $_POST['conditions'];

        if(empty($subject) || empty($message)) {
            header("Location: ../../contact.php?msg=emptyfields");
            exit();
        } else if($conditions[0] != "checked") {
            header("Location: ../../contact.php?msg=notchecked");
            exit();
        } else {
            if($HOST_TYPE == "LOCALHOST") {
                    // Import PHPMailer classes into the global namespace
                    // These must be at the top of your script, not inside a function
                    // Load Composer's autoloader
                    require 'PHPMailer/PHPMailer.php';
                    require 'PHPMailer/SMTP.php';
                    require 'PHPMailer/Exception.php';

                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    //Server settings
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'volvofan.ro@gmail.com';                     // SMTP username
                    $mail->Password   = 'Nilietraian1';                               // SMTP password
                    $mail->SMTPSecure = 'TLS';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom($email, 'De la user-ul: "'.$username.'" trimis de pe VolvoFAN.ro');
                    $mail->addAddress('volvofan.ro@gmail.com');
                    $mail->addReplyTo($email, $firstname.' '.$lastname);
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;

                    if($mail->send()) {

                        $inboxtext = 'Email-ul tau pe subiectul <b>'.$subject.'</b> a fost trimis catre suportul <b>VolvoFAN.ro</b>. O sa primesti un reply pe adresa de email <b>'.$email.'</b>.';
                        $sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$username', '$inboxtext')";
                        mysqli_query($con, $sqlinbox);
                        header("location: ../../contact.php?msg=success");
                        exit();
                    } else {
                        header("location: ../../contact.php?msg=error");
                        exit();
                    }
                } else {
                    $headers = "From: " . $email . "\r\n";
                    $headers .= "Reply-To: ". $email . "\r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    if(mail('volvofan.ro@gmail.com', $subject, $message, $headers)) {

                        $inboxtext = 'Email-ul tau pe subiectul <b>'.$subject.'</b> a fost trimis catre suportul <b>VolvoFAN.ro</b>. O sa primesti un reply pe adresa de email <b>'.$email.'</b>.';
                        $sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$username', '$inboxtext')";
                        mysqli_query($con, $sqlinbox);

                        header("location: ../../contact.php?msg=success");
                        exit();
                    } else {
                        header("location: ../../contact.php?msg=error");
                        exit();
                    }
                }
            }
    }