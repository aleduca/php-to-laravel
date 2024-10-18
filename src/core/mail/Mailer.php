<?php

namespace core\mail;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{

  private string $from;
  private string $to;
  private string $subject;
  private bool $isHtml = true;
  private string $body;

  /**
   * @throws \Exception
   */
  public function send(
    string $view,
    array $data,
    ?\Closure $closure = null
  ): bool {

    if ($closure) {
      $closure($this);
    }

    $this->parseHtml($view, $data);

    $mail = new PHPMailer(true);
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = env('MAIL_HOST');                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = env('MAIL_USERNAME');                     //SMTP username
    $mail->Password = env('MAIL_PASSWORD');                               //SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = env('MAIL_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom($this->from);
    $mail->addAddress($this->to);     //Add a recipient

    //Content
    $mail->isHTML($this->isHtml);                                  //Set email format to HTML
    $mail->Subject = $this->subject;
    $mail->Body = $this->body;

    return $mail->send();
  }

  public function to(string $to): static
  {
    $this->to = $to;

    return $this;
  }

  public function from(string $from): static
  {
    $this->from = $from;

    return $this;
  }

  public function subject(string $subject): static
  {
    $this->subject = $subject;
    return $this;
  }

  public function isHtml(bool $isHtml): static
  {
    $this->isHtml = $isHtml;
    return $this;
  }

  /**
   * @throws \Exception
   */
  private function parseHtml(
    string $view,
    array $data
  ): void {
    $replace = [];

    foreach ($data as $key => $value) {
      $replace["@$key"] = $value;
    }

    $file = VIEW_PATH.DIRECTORY_SEPARATOR.$view.'.html';

    if (!file_exists($file)) {
      throw new \Exception('Email View not found');
    }

    $body = str_replace(
      array_keys($replace),
      array_values($replace),
      file_get_contents($file),
      $count
    );

    if ($count !== count($replace)) {
      throw new \Exception('Some data was not replaced');
    }

    $this->body = $body;
  }
}