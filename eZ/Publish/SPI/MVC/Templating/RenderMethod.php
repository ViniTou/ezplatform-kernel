<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\SPI\MVC\Templating;

use Symfony\Component\HttpFoundation\Request;

interface RenderMethod
{
    public function getIdentifier(): string;

    public function render(Request $request): string;
}
