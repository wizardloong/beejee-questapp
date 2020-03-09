<?php

namespace App\Http\Middleware;

use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

class BasicAuthMiddleware implements MiddlewareInterface
{
    public const ATTRIBUTE = '_user';

    private $users;
    private $responsePrototype;
    private $template;

    public function __construct(array $users, ResponseInterface $responsePrototype, TemplateRenderer $templateRenderer)
    {
        $this->users = $users;
        $this->responsePrototype = $responsePrototype;
        $this->template = $templateRenderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (isset($_SESSION['adminLoggedIn'])) {
            $name = $_SESSION['adminLoggedIn'];
            return $handler->handle($request->withAttribute(self::ATTRIBUTE, $name));
        }

        return new RedirectResponse('/login');
    }
}
