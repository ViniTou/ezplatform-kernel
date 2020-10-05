<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\MVC\Symfony\Templating;

use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use eZ\Publish\SPI\MVC\Templating\RenderMethod;
use eZ\Publish\SPI\MVC\Templating\RenderStrategy;

abstract class BaseRenderStrategy implements RenderStrategy
{
    /** @var string */
    protected $defaultMethod;

    /** @var \eZ\Publish\SPI\MVC\Templating\RenderMethod[] */
    protected $renderMethods = [];

    /** @var \eZ\Publish\Core\MVC\Symfony\SiteAccess */
    protected $siteAccess;

    public function __construct(
        iterable $renderMethods,
        string $defaultMethod,
        SiteAccess $siteAccess
    ) {
        $this->defaultMethod = $defaultMethod;
        $this->siteAccess = $siteAccess;

        foreach ($renderMethods as $renderMethod) {
            $this->renderMethods[$renderMethod->getIdentifier()] = $renderMethod;
        }
    }

    protected function getRenderMethod(array $options, ValueObject $valueObject): RenderMethod
    {
        if (empty($options['method'])) {
            $options['method'] = $this->defaultMethod;
        }

        if (empty($this->renderMethods[$options['method']])) {
            throw new InvalidArgumentException('method', sprintf(
                "Method '%s' is not supported for %s.", $options['method'], get_class($valueObject)
            ));
        }

        return $this->renderMethods[$options['method']];
    }
}
