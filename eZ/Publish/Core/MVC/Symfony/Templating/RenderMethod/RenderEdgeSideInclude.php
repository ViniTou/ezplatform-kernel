<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\MVC\Symfony\Templating\RenderMethod;

use eZ\Publish\SPI\MVC\Templating\RenderMethod;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\AbstractSurrogateFragmentRenderer;

class RenderEdgeSideInclude implements RenderMethod
{
    public const IDENTIFIER = 'esi';

    /** @var \Symfony\Component\HttpKernel\Fragment\AbstractSurrogateFragmentRenderer */
    private $fragmentRenderer;

    public function __construct(
        AbstractSurrogateFragmentRenderer $fragmentRenderer
    ) {
        $this->fragmentRenderer = $fragmentRenderer;
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function render(Request $request): string
    {
        $controllerReference = new ControllerReference(
            $request->get('_controller'),
            $this->getScalarAttributes($request->attributes->all())
        );

        $esiFragmentResponse = $this->fragmentRenderer->render($controllerReference, $request);

        return $esiFragmentResponse->getContent();
    }

    private function getScalarAttributes(array $attributes): array
    {
        $scalarAttributes = [];

        foreach ($attributes as $key => $value) {
            if (is_scalar($value)) {
                $scalarAttributes[$key] = $value;
            }
        }

        return $scalarAttributes;
    }
}
