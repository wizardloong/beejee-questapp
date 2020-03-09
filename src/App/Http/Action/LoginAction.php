<?php

namespace App\Http\Action;

use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

class LoginAction implements RequestHandlerInterface
{
    private $users;
    private $template;

    public function __construct(array $users, TemplateRenderer $template)
    {
        $this->template = $template;
        $this->users = $users;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (isset($_SESSION['adminLoggedIn'])) {
            return new RedirectResponse('/logout');
        } else {
            $username = $request->getParsedBody()['username'] ?? '';
            $password = $request->getParsedBody()['password'] ?? '';
            if (!empty($username) && !empty($password)) {
                foreach ($this->users as $name => $pass) {
                    if ($username === $name && $password === $pass) {
                        $_SESSION['adminLoggedIn'] = $username;
                        return new RedirectResponse('/');
                    }
                }
            }
            return new HtmlResponse($this->template->render('app/login', ['error' => 'Login or pass is invalid']));
        }
    }
}
