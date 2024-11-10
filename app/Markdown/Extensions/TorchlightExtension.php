<?php

declare(strict_types=1);

namespace App\Markdown\Extensions;

use App\Markdown\BaseExtension;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class TorchlightExtension extends BaseExtension implements ExtensionInterface, NodeRendererInterface
{
    /**
     * This method just proxies to our base class, but the
     * signature has to match Commonmark V2.
     */
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $this->bind($environment, 'addRenderer');
    }

    /**
     * This method just proxies to our base class, but the
     * signature has to match Commonmark V2.
     *
     * @return mixed|string|\Stringable|null
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        return $this->renderNode($node);
    }

    /**
     * V2 Code node classes.
     *
     * @return string[]
     */
    protected function codeNodes(): array
    {
        return [
            FencedCode::class,
            IndentedCode::class,
        ];
    }

    /**
     * Get the string content from a V2 node.
     */
    protected function getLiteralContent($node): string
    {
        return $node->getLiteral();
    }
}
