<?php
declare(strict_types=1);

namespace App\Http\Action;

use App\Entity\Quest;
use App\ReadModel\QuestReadRepository;
use App\Service\QuestService;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

class EditAction implements RequestHandlerInterface
{
    private $template;
    private $questService;
    private $questReadRepository;

    public function __construct(
        TemplateRenderer $templateRenderer,
        QuestService $questService,
        QuestReadRepository $questReadRepository
    ) {
        $this->template = $templateRenderer;
        $this->questService = $questService;
        $this->questReadRepository = $questReadRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $questId = $request->getAttribute('quest') * 1;
        $quest = $this->questReadRepository->find($questId);

        return $request->getMethod() == 'POST'
            ? $this->handlePost($request, $quest)
            : $this->handleGet($request, $quest);
    }

    private function handleGet(ServerRequestInterface $request, Quest $quest): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app/edit', [
            'quest' => $quest
        ]));
    }

    private function handlePost(ServerRequestInterface $request, Quest $quest): ResponseInterface
    {
        $formData = $request->getParsedBody();

        $result = $this->questService->update($quest, $formData);
        if (!empty($result)) {
            return new HtmlResponse($this->template->render('app/edit', [
                'quest' => $quest,
                'errors' => $result
            ]));
        }

        return new RedirectResponse('/');
    }
}
