<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\SPI\MVC\Templating;

use eZ\Publish\API\Repository\Values\ValueObject;

interface RenderStrategy
{
    public function supports(ValueObject $valueObject): bool;

    public function render(ValueObject $valueObject, array $options = []): string;
}
