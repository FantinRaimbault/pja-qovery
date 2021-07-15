<?php


namespace App\Modules;

use App\AwsCredentials;
use Aws\Exception\AwsException;
use Aws\Ses\SesClient;

class BinksBeatMailer
{
  private static ?BinksBeatMailer $_instance = null;
  private SesClient $mailClient;

  private function __construct() {
    $this->mailClient = new SesClient(['region' => 'eu-central-1', 'version' => '2010-12-01', 'credentials' => AwsCredentials::getSESCredentials()]);
  }

  public static function getInstance(): BinksBeatMailer
  {
    if (is_null(self::$_instance)) self::$_instance = new BinksBeatMailer();
    return self::$_instance;
  }

  public function sendEmail(string $from, array $to, string $subject, string $message) {

    try {
      $result = $this->mailClient->sendEmail([
        'Destination' => [
          'ToAddresses' => $to,
        ],
        'Source' => $from,
        'Message' => [
          'Body' => [
            'Html' => [
              'Charset' => 'UTF-8',
              'Data' => $message,
            ],
          ],
          'Subject' => [
            'Charset' => 'UTF-8',
            'Data' => $subject,
          ],
        ],
      ]);
      return true;
    } catch (AwsException $e) {
      // output error message if fails
      echo $e->getMessage();
      echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
      echo "\n";
      return false;
    }
  }
}