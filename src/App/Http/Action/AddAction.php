<?php
declare(strict_types=1);

namespace App\Http\Action;

use App\Service\QuestService;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

class AddAction implements RequestHandlerInterface
{
    private $template;
    private $questService;

    public function __construct(TemplateRenderer $templateRenderer, QuestService $questService)
    {
        $this->template = $templateRenderer;
        $this->questService = $questService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $request->getMethod() == 'POST'
            ? $this->handlePost($request)
            : $this->handleGet();
    }

    private function handleGet(): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app/add'));
    }

    private function handlePost(ServerRequestInterface $request): ResponseInterface
    {
        $formData = $request->getParsedBody();

        $result = $this->questService->addNew($formData);
        if (!empty($result)) {
            return new HtmlResponse($this->template->render('app/add', [
                'errors' => $result
            ]));
        }

        return new RedirectResponse('/?added=1');
    }
}
