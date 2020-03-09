<?php
declare(strict_types=1);

namespace Infrastructure\App\Http\Action;

use App\Http\Action\LoginAction;
use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;

class LoginActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginAction($container->get('config')['auth']['users'], $container->get(TemplateRenderer::class));
    }
}
