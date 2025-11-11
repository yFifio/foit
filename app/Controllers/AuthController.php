<?php
// Salve em: app/Controllers/AuthController.php

class AuthController
{
    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm(): void
    {
        view('login');
    }

    /**
     * Processa a tentativa de login.
     */
    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        /** @var User|null $user */
        $user = User::findByEmail($email); //

        // Verifica se o usuário existe e se a senha está correta
        if ($user && password_verify($password, $user->getPassword())) {
            
            // --- CORREÇÃO AQUI ---
            // Use 'put' para dados persistentes
            session()->put('user_id', $user->getId()); //
            session()->put('user_name', $user->getName()); //
            session()->put('is_admin', $user->isAdmin()); //

            // Redireciona para a loja
            redirect('/roupas'); //
        } else {
            // Falha no login, redireciona de volta com erro
            session()->flash('error', 'Email ou senha inválidos.'); //
            redirect('/login');
        }
    }

    /**
     * Exibe o formulário de registro.
     */
    public function showRegisterForm(): void
    {
        view('register'); //
    }

    /**
     * Processa a tentativa de registro.
     */
    public function register(): void
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validação básica
        if (empty($name) || empty($email) || empty($password)) {
            session()->flash('error', 'Todos os campos são obrigatórios.');
            redirect('/register');
        }

        // Verifica se o email já existe
        if (User::findByEmail($email)) { //
            session()->flash('error', 'Este email já está cadastrado.');
            redirect('/register');
        }

        // Cria o novo usuário
        $success = User::create($name, $email, $password); //

        if ($success) {
            session()->flash('success', 'Conta criada com sucesso! Faça o login.');
            redirect('/login');
        } else {
            session()->flash('error', 'Ocorreu um erro ao criar sua conta.');
            redirect('/register');
        }
    }

    /**
     * Faz o logout do usuário.
     */
    public function logout(): void
    {
        session()->destroy(); //
        redirect('/login');
    }
}