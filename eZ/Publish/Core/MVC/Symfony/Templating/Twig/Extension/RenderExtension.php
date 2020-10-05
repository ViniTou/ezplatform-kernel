<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\MVC\Symfony\Templating\Twig\Extension;

use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use eZ\Publish\SPI\MVC\Templating\RenderStrategy;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RenderExtension extends AbstractExtension
{
    /** @var \eZ\Publish\SPI\MVC\Templating\RenderStrategy */
    private $renderStrategy;

    public function __construct(RenderStrategy $renderStrategy)
    {
        $this->renderStrategy = $renderStrategy;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction(
                'ez_render',
                [$this, 'render'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function render(ValueObject $valueObject, array $options = [])
    {
        if (!$this->renderStrategy->supports($valueObject)) {
            throw new InvalidArgumentException(
                'valueObject',
                sprintf('%s is not supported.', get_class($valueObject))
            );
        }

        return $this->renderStrategy->render($valueObject, $options);
    }
}
