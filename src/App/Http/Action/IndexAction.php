<?php
declare(strict_types=1);

namespace App\Http\Action;

use App\ReadModel\Pagination;
use App\ReadModel\QuestReadRepository;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction implements RequestHandlerInterface
{
    private const PER_PAGE = 3;

    private $quests;
    private $template;

    public function __construct(QuestReadRepository $quests, TemplateRenderer $template)
    {
        $this->quests = $quests;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $currentPage = $request->getAttribute('page') * 1;
        $pager = new Pagination(
            $this->quests->countAll(),
            $currentPage ?: 1,
            self::PER_PAGE
        );

        if ($currentPage > $pager->getPagesCount()) {
            return new HtmlResponse($this->template->render('error/404', [
                'request' => $request,
            ]), 404);
        }

        $sort = $request->getAttribute('sort') ?? 'id';
        $order = $request->getAttribute('order') ?? 'ASC';

        $quests = $this->quests->all(
            $pager->getOffset(),
            $pager->getLimit(),
            $sort,
            $order
        );

        return new HtmlResponse($this->template->render('app/index', [
            'quests' => $quests,
            'pager' => $pager,
            'sort' => $sort,
            'order' => $order
        ]));
    }
}
