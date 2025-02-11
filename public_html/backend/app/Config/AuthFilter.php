<?php

namespace app\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Prüfe, ob der Benutzer authentifiziert ist
        if (!session()->get('isLoggedIn')) {
            // Weiterleitung zur Login-Seite
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Aktionen nach der Anfrage
    }
}

