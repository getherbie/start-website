<?php

declare(strict_types=1);

namespace HerbieKickstarter\Plugin\Blog;

use herbie\AbstractPlugin;
use herbie\HttpException;
use herbie\Page;
use herbie\PageRepositoryInterface;
use herbie\Plugin;
use herbie\Site;
use herbie\UrlManager;
use herbie\middlewares\PageResolverMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Turns the blog taxonomy routes into virtual pages. Tags, categories, the
 * archive, the author index and the Atom feed no longer need placeholder files.
 */
#[Plugin('blog')]
final class BlogPlugin extends AbstractPlugin
{
    public function __construct(
        private readonly PageRepositoryInterface $pageRepository,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly Site $site,
        private readonly UrlManager $urlManager,
    ) {}

    public function applicationMiddlewares(): array
    {
        return [$this->renderVirtualPages(...)];
    }

    public function renderVirtualPages(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        /** @var string $route */
        $route = $request->getAttribute(PageResolverMiddleware::HERBIE_REQUEST_ATTRIBUTE_ROUTE, '');
        /** @var array<string, string> $params */
        $params = $request->getAttribute(PageResolverMiddleware::HERBIE_REQUEST_ATTRIBUTE_ROUTE_PARAMS, []);

        if ($route === 'blog/feed.xml') {
            return $this->createFeedResponse();
        }

        if ($route !== 'blog' || $params === []) {
            return $handler->handle($request);
        }

        $page = $this->createVirtualPage($params);
        if ($page === null) {
            return $handler->handle($request);
        }

        return $handler->handle(
            $request->withAttribute(PageResolverMiddleware::HERBIE_REQUEST_ATTRIBUTE_PAGE, $page),
        );
    }

    /**
     * @param array<string, string> $params
     */
    private function createVirtualPage(array $params): ?Page
    {
        if (isset($params['author'])) {
            $id = $params['author'];
            $authors = $this->authors();
            if (!isset($authors[$id]) || !is_array($authors[$id])) {
                throw HttpException::notFound('blog/author/' . $id);
            }
            $author = $authors[$id];
            $title = (string)($author['title'] ?? $id);
            return $this->page(
                'blog/author/' . $id,
                $title,
                'author',
                '# ' . $title . "\n\n" . (string)($author['about'] ?? '')
                    . "\n\nBrowse the {{ link_page('blog', 'blog index') }} for articles by all authors.",
                extra: [
                    'type' => 'blog-author',
                    'author_id' => $id,
                    'role' => (string)($author['role'] ?? ''),
                    'initials' => (string)($author['initials'] ?? ''),
                    'avatar' => (string)($author['avatar'] ?? ''),
                    'bio' => (string)($author['bio'] ?? ''),
                    'website' => (string)($author['website'] ?? ''),
                    'email' => (string)($author['email'] ?? ''),
                    'github' => (string)($author['github'] ?? ''),
                ],
            );
        }

        if (isset($params['tag'])) {
            $tag = $this->resolveTerm('tags', $params['tag']);
            return $this->page(
                'blog/tag/' . $params['tag'],
                'Tag: ' . $tag,
                'archive',
                '# Tag: ' . $this->escape($tag) . "\n\nPosts about " . $this->escape($tag) . '.',
                'tags',
                $tag,
            );
        }

        if (isset($params['category'])) {
            $category = $this->resolveTerm('categories', $params['category']);
            return $this->page(
                'blog/category/' . $params['category'],
                'Category: ' . $category,
                'archive',
                '# Category: ' . $this->escape($category) . "\n\nPosts in the "
                    . $this->escape($category) . ' category.',
                'categories',
                $category,
            );
        }

        return match ($params['section'] ?? '') {
            'archive' => $this->page(
                'blog/archive',
                'Archive',
                'archive',
                "# Blog archive\n\nEvery post in this example blog, newest first.",
            ),
            'author' => $this->page(
                'blog/author',
                'Authors',
                'authors',
                "# Authors\n\nThe people who write this example blog.",
            ),
            'tag' => $this->page(
                'blog/tag',
                'Tags',
                'archive',
                "# Tags\n\nAll tags used in this example blog.",
            ),
            'category' => $this->page(
                'blog/category',
                'Categories',
                'archive',
                "# Categories\n\nAll categories used in this example blog.",
            ),
            default => null,
        };
    }

    /**
     * Routes are lowercase; front matter may use a different capitalisation.
     */
    private function resolveTerm(string $field, string $value): string
    {
        foreach ($this->pageRepository->findAll() as $post) {
            if (($post['type'] ?? '') !== 'post') {
                continue;
            }
            foreach ((array)($post[$field] ?? []) as $term) {
                if (is_string($term) && strcasecmp($term, $value) === 0) {
                    return $term;
                }
            }
        }
        return $value;
    }

    private function page(
        string $route,
        string $title,
        string $layout,
        string $intro,
        ?string $filterField = null,
        ?string $filterValue = null,
        array $extra = [],
    ): Page {
        $data = [
            'route' => $route,
            'title' => $title,
            'layout' => $layout,
            'type' => 'blog-taxonomy',
            'format' => 'markdown',
            'cached' => false,
            'hidden' => true,
            'no_search' => true,
        ];
        if ($filterField !== null) {
            $data['filter_field'] = $filterField;
            $data['filter_value'] = $filterValue;
        }
        return new Page(array_merge($data, $extra), ['default' => $intro]);
    }

    /**
     * @return array<string, mixed>
     */
    private function authors(): array
    {
        $data = $this->site->getData();
        return is_array($data['authors'] ?? null) ? $data['authors'] : [];
    }

    private function createFeedResponse(): ResponseInterface
    {
        $siteData = $this->site->getData();
        $site = is_array($siteData['site'] ?? null) ? $siteData['site'] : [];
        $title = $this->escape((string)($site['title'] ?? 'Blog')) . ' Blog';
        $description = $this->escape((string)($site['description'] ?? ''));

        $posts = [];
        foreach ($this->pageRepository->findAll() as $post) {
            if (($post['type'] ?? '') === 'post') {
                $posts[] = $post;
            }
        }
        usort($posts, static fn(Page $a, Page $b): int => strcmp((string)$b['date'], (string)$a['date']));

        $selfUrl = $this->escape($this->urlManager->createAbsoluteUrl('blog/feed.xml'));
        $blogUrl = $this->escape($this->urlManager->createAbsoluteUrl('blog'));

        $xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n"
            . '<feed xmlns="http://www.w3.org/2005/Atom">' . "\n"
            . '    <title>' . $title . '</title>' . "\n"
            . '    <subtitle>' . $description . '</subtitle>' . "\n"
            . '    <link href="' . $selfUrl . '" rel="self" />' . "\n"
            . '    <link href="' . $blogUrl . '" />' . "\n"
            . '    <id>' . $blogUrl . '</id>' . "\n"
            . '    <updated>' . date('c') . '</updated>' . "\n";

        foreach ($posts as $post) {
            $postUrl = $this->escape($this->urlManager->createAbsoluteUrl((string)$post->getRoute()));
            $authors = (array)($post['authors'] ?? []);
            $authorName = $this->escape((string)(reset($authors) ?: ''));
            $published = $this->isoDate((string)($post['date'] ?? ''));

            $xml .= "    <entry>\n"
                . '        <title>' . $this->escape((string)($post['title'] ?? '')) . '</title>' . "\n"
                . '        <link href="' . $postUrl . '" />' . "\n"
                . '        <id>' . $postUrl . '</id>' . "\n"
                . '        <published>' . $published . '</published>' . "\n"
                . '        <updated>' . $published . '</updated>' . "\n"
                . '        <summary>' . $this->escape((string)($post['abstract'] ?? '')) . '</summary>' . "\n"
                . '        <author><name>' . $authorName . '</name></author>' . "\n";

            foreach (['categories', 'tags'] as $field) {
                foreach ((array)($post[$field] ?? []) as $term) {
                    $xml .= '        <category term="' . $this->escape((string)$term) . '" />' . "\n";
                }
            }

            $xml .= "    </entry>\n";
        }

        $xml .= "</feed>\n";

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write($xml);
        return $response->withHeader('Content-Type', 'application/atom+xml');
    }

    private function isoDate(string $date): string
    {
        $timestamp = strtotime($date);
        return $timestamp === false ? $this->escape($date) : date('c', $timestamp);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
