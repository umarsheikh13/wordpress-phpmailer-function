<?php
/**
 * WordPress PHPMailer Function
 *
 * This function allows you to send HTML and plaintext emails using PHPMailer 
 * which already comes with WordPress.
 * 
 * @author Umar Sheikh <hello@umarsheikh.co.uk>
 *
 * @param string|array $email_to 'recipient@website.com' | array( 'recipient@website.com', 'recipient2@website.com' )
 * @param string $email_subject 'Hello world!'
 * @param string $email_message 'This is my <b>message</b>.'
 * @param array $email_from	array( 'hello@umarsheikh.co.uk', 'Umar Sheikh' )
 *
 * @version 0.1.0
 * @return Returns true if email was sent successfully or false on failure.
 */

function wp_mailer( $email_to, $email_subject, $email_message, $email_from = array() ) {

	// Include PHPMailer

	if ( !class_exists( 'PHPMailer' ) ) {
		require( ABSPATH . WPINC . '/class-phpmailer.php' );
	}

	// Setup PHPMailer

	$mail = new PHPMailer();

	// Check from variable and set default
	
	if ( count( $email_from ) == 1 ) {
		$email_from[1] = get_bloginfo( 'name' );
	} else {
		$email_from = array( get_option( 'admin_email' ), get_bloginfo( 'name' ) );
	}

	// Get HTML template

	ob_start();
	require( 'email-template.php' );
	$message_html = ob_get_contents();
	ob_end_clean();

	// Basic example of template

	/*
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>E-mail</title>
	</head>

	<body>

	<h1><?php echo $email_subject; ?></h1>
	<p><?php echo $email_message; ?></p>
	<p><?php echo $email_from[1]; ?></p>

	</body>

	</html>
	*/

	// Create plain text version

	$message_plain = strip_tags( $email_message );

	// SMTP settings

    //$mail->IsSMTP();
    //$mail->SMTPAuth   = true;
    //$mail->Username   = get_option('bs-smtp-username');
    //$mail->Password   = get_option('bs-smtp-password');
    //$mail->Host       = get_option('bs-smtp-host');
    //$mail->Port       = (int)get_option('bs-smtp-port');

    // Send email

    $mail->CharSet = 'UTF-8';
    $mail->SetFrom( $email_from[0], $email_from[1] );
    $mail->Subject = $email_subject;
    $mail->AltBody = $message_plain;
    $mail->MsgHTML( $message_html );
    if ( is_array( $email_to ) ) {
    	$sent = true;
    	foreach( $email_to as $email_t ) {
    		$mail->ClearAllRecipients();
    		$mail->AddAddress( $email_t );
			if ( !$mail->Send() ) {
			    return false;
			}
    	}
    	return $sent;
    } else {
    	$mail->AddAddress( $email_to );
		if ( $mail->Send() ) {
		    return true;
		} else {
			return false;
		}
    }
	
}

?>
