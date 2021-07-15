<?php
namespace App;

use Aws\Credentials\Credentials;

Class AwsCredentials {

  public static function getSESCredentials(): Credentials
  {
    return new Credentials(getenv('SES_AWS_KEY'), getenv('SES_AWS_SECRET'));
  }
}

