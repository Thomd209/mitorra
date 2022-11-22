<?php


class TwoFactorAuthorization
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->$pdo = $pdo;
    }

    public function isNotEmpty(string $field): bool {
        return ! empty($field);
    }

    public function checkLogin(string $login): bool {
        $sql = 'SELECT login FROM Users WHERE login = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$login]);

        $user = $stmt->fetchAll();

        return count($user) != 0;
    }

    public function checkPassword(string $login): bool {
        $sql = 'SELECT password FROM Users WHERE login = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$login]);

        $user = $stmt->fetchAll();

        return count($user) != 0;
    }

    public function checkCode(string $login, string $code): bool {
        $sql = "SELECT code FROM Users WHERE login = '?' AND code = '?'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$login, $code]);
        
        $code = $stmt->fetchAll();

        return count($code);
    }

    public function sendCode() {
        $code = $this->generate_code();

        $this->saveToDb($code);

        $this->sendEmail($code);

    }

    public function renderButton() {
        // some render code
    }

    public function saveToDb(string $code) {
        $sql = "INSERT INTO Users (code) values (?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$code]);
    }

    public function generate_code(): string
    {
        return substr(md5(uniqid(mt_rand(), true)) , 0, 8);
    }

    public function sendEmail(string $code) {
        $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
        $mail->From = "from@yourdomain.com";
        $mail->FromName = "Full Name";
        $mail->addAddress("recepient1@example.com", "Recepient Name");
        $mail->addAddress("recepient1@example.com"); //Recipient name is optional
        $mail->addReplyTo("reply@yourdomain.com", "Reply");
        $mail->addCC("cc@example.com");
        $mail->addBCC("bcc@example.com");
        $mail->isHTML(true);

        $mail->Subject = "Subject Text";
        $mail->Body = "Your code is" . $code;
        $mail->AltBody = "This is the plain text version of the email content";

        try {
            $mail->send();
            echo "Message has been sent successfully";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}