<?php

use App\Legacy\ActiveUser;
use App\Legacy\LegacyConfig;
use Illuminate\Support\Facades\DB;

function login(int $userId, bool $remember = true)
{
    // remove old accesses

    // remember me

    // login
    ActiveUser::getInstance()->setId($userId);

    if (isset($_SESSION['login-attempts'])) {
        unset($_SESSION['login-attempts']);
    }

    return $userId;
}

/**
 * Login with username/email and password
 */
function standard_login(string $username, string $password, ?string $url = null, bool $remember = true)
{
    $username = strtolower($username);

    // set redirect location
    $url = $url ?: LegacyConfig::getInstance()->loggedRedirectUrl;

    // fetch user data
    $userData = DB::table('users')
        ->select('id', 'password')
        ->whereRaw('(LOWER(username) = ? OR LOWER(email) = ?)', [$username, $username])
        ->first();

    if ($userData) {
        // successful login
        $userId = $userData->id;
        $dbPassword = $userData->password;

        // update old password
        if ($dbPassword[0] != '$' && ($password == $dbPassword || md5($password) == $dbPassword)) {
            $dbPassword = password_hash($password, PASSWORD_DEFAULT);

            DB::table('users')->where('id', $userId)->update(['password' => $dbPassword]);
        }

        if (password_verify($password, $dbPassword)) {
            // successful login
            login($userId, $remember);
        } else {
            // wrong password
            return 'error-wrong-data';
        }

        redirect_old($url);
    } else {
        // unsuccessful login
        if (isset($_SESSION['login-attempts'])) {
            $_SESSION['login-attempts']++;
        } else {
            $_SESSION['login-attempts'] = 1;
        }

        return 'error-wrong-data';
    }
}

// direct login
function token_login(string $token)
{
    $userId = null;
    $validToken = false;
    $token = explode('_', $token);
    $selector = $token[0];
    if (! $validToken) {
        setcookie('auth_token', '', -1, '/');
    }

    return $userId;
}

function logout(string $url = '/')
{
    // setcookie('auth_token', '', -1);

    session_destroy();

    redirect_old($url);
}
