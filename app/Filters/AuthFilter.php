<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('user_id')) {
            return null;
        }

        return redirect()->to('/login')
            ->with('login_error', 'Please sign in to open that page.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No response changes are needed after the controller runs.
    }
}
