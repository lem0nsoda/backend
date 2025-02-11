<?php


namespace App\Controllers;


namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        echo '<form action="/login/authenticate" method="post">';
        echo '<input type="text" name="username" placeholder="Benutzername" required>';
        echo '<input type="password" name="password" placeholder="Passwort" required>';
        echo '<button type="submit">Login</button>';
        echo '</form>';
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('user_id', $user['id']);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Falsche Anmeldedaten');
        }
    }
}


?>