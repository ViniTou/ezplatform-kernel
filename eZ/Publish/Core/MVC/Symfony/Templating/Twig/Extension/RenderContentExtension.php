<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\MVC\Symfony\Templating\Twig\Extension;

use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\Core\MVC\Symfony\Templating\RenderContentStrategy;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RenderContentExtension extends AbstractExtension
{
    /** @var \eZ\Publish\Core\MVC\Symfony\Templating\RenderContentStrategy */
    private $renderContentStrategy;

    public function __construct(
        RenderContentStrategy $renderContentStrategy
    ) {
        $this->renderContentStrategy = $renderContentStrategy;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction(
                'ez_render_content',
                [$this, 'renderContent'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function renderContent(Content $content, array $options = [])
    {
        return $this->renderContentStrategy->render($content, $options);
    }
}
