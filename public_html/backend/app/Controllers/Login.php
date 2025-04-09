<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    //zeigt login-formular an
    public function index()
    {
        echo '<form action="/login/authenticate" method="post">';
        echo '<input type="text" name="username" placeholder="benutzername" required>';
        echo '<input type="password" name="password" placeholder="passwort" required>';
        echo '<button type="submit">login</button>';
        echo '</form>';
    }

    //überprüft die benutzerdaten und startet eine session bei erfolg
    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('username', $username)->first();

        // wenn benutzer gefunden und passwort korrekt ist, speichert die session und leitet weiter 
        if ($user && password_verify($password, $user['password'])) {
            session()->set('user_id', $user['id']);
            return redirect()->to('/dashboard');
        } else {
            //bei fehlerhaften daten wird zurückgeleitet (fehlermeldung
            return redirect()->back()->with('error', 'falsche anmeldedaten');
        }
    }
}

?>
