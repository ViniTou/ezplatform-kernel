<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Values\Content\Query\SortClause;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\SPI\Repository\Values\Filter\FilteringSortClause;
use eZ\Publish\SPI\Repository\Values\Trash\Query\SortClause as TrashSortClause;

/**
 * Sets sort direction on Content name for a content query.
 */
class ContentName extends SortClause implements FilteringSortClause, TrashSortClause
{
    /**
     * Constructs a new ContentName SortClause.
     *
     * @param string $sortDirection
     */
    public function __construct(string $sortDirection = Query::SORT_ASC)
    {
        parent::__construct('content_name', $sortDirection);
    }
}
