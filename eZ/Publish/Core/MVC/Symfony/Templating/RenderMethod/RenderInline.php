<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\MVC\Symfony\Templating\RenderMethod;

use eZ\Bundle\EzPublishCoreBundle\EventListener\ViewControllerListener;
use eZ\Publish\Core\MVC\Symfony\Templating\Exception\InvalidResponseException;
use eZ\Publish\Core\MVC\Symfony\View\View;
use eZ\Publish\SPI\MVC\Templating\RenderMethod;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactoryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

class RenderInline extends BaseRenderMethod implements RenderMethod
{
    public const IDENTIFIER = 'inline';

    /** @var \Twig\Environment */
    private $twig;

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function __construct(
        KernelInterface $kernel,
        ViewControllerListener $controllerListener,
        ControllerResolverInterface $controllerResolver,
        ArgumentMetadataFactoryInterface $argumentMetadataFactory,
        ArgumentValueResolverInterface $argumentValueResolver,
        Environment $twig
    ) {
        parent::__construct(
            $kernel,
            $controllerListener,
            $controllerResolver,
            $argumentMetadataFactory,
            $argumentValueResolver
        );

        $this->twig = $twig;
    }

    public function render(Request $request): string
    {
        $event = $this->getControllerEvent($request);
        $controller = $this->getController($event);
        $arguments = $this->getArguments($controller, $event);

        $response = call_user_func_array($controller, $arguments);

        if ($response instanceof View) {
            return $this->twig->render($response->getTemplateIdentifier(), $response->getParameters());
        } elseif ($response instanceof Response) {
            return $response->getContent();
        } elseif (is_string($response)) {
            return $response;
        }

        throw new InvalidResponseException(
            sprintf('Unsupported type (%s)', get_class($response))
        );
    }
}
