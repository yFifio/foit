<?php
// Salve em: app/Core/Session.php

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Define uma "flash message" (que só dura uma requisição).
     */
    public function flash(string $key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Pega uma "flash message" (e a apaga em seguida).
     */
    public function getFlash(string $key)
    {
        if (isset($_SESSION['_flash'][$key])) {
            $value = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $value;
        }
        return null;
    }

    /**
     * Coloca um item na sessão.
     */
    public function put(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Pega um item da sessão.
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Remove um item da sessão.
     */
    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destrói a sessão (logout).
     */
    public function destroy(): void
    {
        session_destroy();
    }
}