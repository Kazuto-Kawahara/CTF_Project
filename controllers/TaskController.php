<?php

namespace app\controllers;

use app\models\Login;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Task Controller.
 */
class TaskController extends BaseController
{
    /**
     * Calculates commission fees for provided csv file.
     *
     * @param array $params Input parameters
     */
    public function login()
    {
        // Create new Login object
        $login = new Login();

        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set username and password from form data
            $login->uname = $_POST['uname'];
            $login->pass = $_POST['pass'];



            // Generate JWT token
            $login->generateJwt();
            $localStorage = 'localStorage';

            echo '<script>';
            echo 'var jwt = "' . $login->jwt . '";';
            echo $localStorage . '.setItem("jwt", jwt);';
            echo '</script>';
            
            // Render view with JWT token
            $this->render('AssigmentPage.php');
        } else {
            // Render login form
            $this->render('LoginForm.php', ['login' => $login]);
        }
    }

    public function test()
    {
        $request_headers = getallheaders();
        if (!isset($request_headers['Authorization'])) {
            throw new \Exception("Yetkisiz erişim", 1);
        }

        $jwt = $request_headers['Authorization'];

        try {
            $decoded = JWT::decode($jwt, new Key('bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=', 'HS512'));
        } catch (InvalidArgumentException $e) {
            // provided key/key-array is empty or malformed.
        } catch (DomainException $e) {
            // provided algorithm is unsupported OR
            // provided key is invalid OR
            // unknown error thrown in openSSL or libsodium OR
            // libsodium is required but not available.
        } catch (SignatureInvalidException $e) {
            // provided JWT signature verification failed.
        } catch (BeforeValidException $e) {
            // provided JWT is trying to be used before "nbf" claim OR
            // provided JWT is trying to be used before "iat" claim.
        } catch (ExpiredException $e) {
            // provided JWT is trying to be used after "exp" claim.
        } catch (UnexpectedValueException $e) {
            // provided JWT is malformed OR
            // provided JWT is missing an algorithm / using an unsupported algorithm OR
            // provided JWT algorithm does not match provided key OR
            // provided key ID in key/key-array is empty or invalid.
        }
        var_dump($decoded);
        die();
    }
   
}