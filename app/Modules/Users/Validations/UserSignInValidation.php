<?php

namespace App\Modules\Users\Validations;

use App\Modules\Users\Service\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ServerRequestInterface;

class UserSignInValidation
{
   private static function authCredentials()
   {
      $client = app(AuthService::class)->getPassportClient();
      if(isset($client))
          return [
              "client_id" =>$client['client_id'],
              "client_secret" => $client['client_secret'],
          ];

      throw new ModelNotFoundException('Password client not generated or does not exist!');
   }

    public static function rulesForSignIn(Request $request)
    {
        return Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
    }

    public static function parsedClientCredentials(ServerRequestInterface $serverRequest) : ServerRequestInterface
    {
        return $serverRequest->withParsedBody([
            "grant_type" => "client_credentials",
            "client_id" =>self::authCredentials()['client_id'],
            "client_secret" => self::authCredentials()['client_secret'],
        ]);
    }
}
