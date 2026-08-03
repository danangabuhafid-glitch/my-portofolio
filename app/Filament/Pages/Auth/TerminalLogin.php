<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class TerminalLogin extends BaseLogin
{
    protected string $view = 'filament.pages.auth.terminal-login';
    protected static string $layout = 'filament-panels::components.layout.base';

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->components([
            \Filament\Forms\Components\TextInput::make('login')
                ->required(),
            \Filament\Forms\Components\TextInput::make('password')
                ->required(),
        ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        return [
            $login_type => $data['login'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'data.login' => 'Username tidak terdaftar atau password salah.',
        ]);
    }
}
