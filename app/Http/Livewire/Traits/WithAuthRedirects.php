<?php

namespace App\Http\Livewire\Traits;

trait WithAuthRedirects
{
    public function redirectToLogin()
    {
        redirect()->setIntendedUrl(url()->previous());

        return redirect()->route('login');
    }

    public function redirectToRegister()
    {
        redirect()->setIntendedUrl(url()->previous());

        return redirect()->route('register');
    }
}
