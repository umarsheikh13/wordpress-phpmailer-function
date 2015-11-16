# WordPress PHPMailer Function

This function allows you to send HTML and plaintext emails using PHPMailer which already comes with WordPress.

## Usage

Include this function in your theme's functions.php file or drop it into your plugin.

```php
wp_mailer( $email_to, $email_subject, $email_message, $email_from );
```

## Parameters

Attribute       | Type         | Description
---             | ---		       | ---
`email_to`      | string/array | The recipient's email address(es).
`email_subject` | string       | The email subject.
`email_message` | string       | The email message.
`email_from`    | array        | The sender's email address and name.

## Example

```php
if ( wp_mailer( 'john.doe@email.com', 'Hello world!', 'How are you?', array( 'jane.doe@email.com', 'Jane Doe' ) ) ) {
    echo 'E-mail sent successfully :)';
} else {
    echo 'E-mail could not be sent :(';
}
```

## License

[MIT License](http://opensource.org/licenses/MIT)
