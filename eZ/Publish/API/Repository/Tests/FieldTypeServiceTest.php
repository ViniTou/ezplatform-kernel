<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\API\Repository\Tests;

/**
 * Test case for operations in the FieldTypeService using in memory storage.
 *
 * @see eZ\Publish\API\Repository\FieldTypeService
 * @group field-type
 */
class FieldTypeServiceTest extends BaseTest
{
    /**
     * Test for the getFieldTypes() method.
     *
     * @see \eZ\Publish\API\Repository\FieldTypeService::getFieldTypes()
     */
    public function testGetFieldTypes()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $fieldTypeService = $repository->getFieldTypeService();

        // Contains the list of all registered field types
        $fieldTypes = $fieldTypeService->getFieldTypes();
        /* END: Use Case */

        // Require at least 1 field type
        $this->assertNotCount(0, $fieldTypes);

        foreach ($fieldTypes as $fieldType) {
            $this->assertInstanceOf(
                'eZ\\Publish\\API\\Repository\\FieldType',
                $fieldType
            );
        }
    }

    /**
     * Test for the getFieldType() method.
     *
     * Expects FieldType "ezurl" to be available!
     *
     * @see \eZ\Publish\API\Repository\FieldTypeService::getFieldType()
     */
    public function testGetFieldType()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $fieldTypeService = $repository->getFieldTypeService();

        // Contains the "ezurl" FieldType
        $fieldType = $fieldTypeService->getFieldType('ezurl');
        /* END: Use Case */

        $this->assertInstanceof(
            'eZ\\Publish\\API\\Repository\\FieldType',
            $fieldType
        );
        $this->assertEquals(
            'ezurl',
            $fieldType->getFieldTypeIdentifier()
        );
    }

    /**
     * Test for the getFieldType() method.
     *
     * @see \eZ\Publish\API\Repository\FieldTypeService::getFieldType()
     */
    public function testGetFieldTypeThrowsNotFoundException()
    {
        $this->expectException(\RuntimeException::class);

        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $fieldTypeService = $repository->getFieldTypeService();

        // Throws and exception since type does not exist
        $fieldType = $fieldTypeService->getFieldType('sindelfingen');
        /* END: Use Case */
    }

    /**
     * Test for the hasFieldType() method.
     *
     * @see \eZ\Publish\API\Repository\FieldTypeService::hasFieldType()
     */
    public function testHasFieldTypeReturnsTrue()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $fieldTypeService = $repository->getFieldTypeService();

        // Returns true, since 'ezurl' type exists
        $typeExists = $fieldTypeService->hasFieldType('ezurl');
        /* END: Use Case */

        $this->assertTrue($typeExists);
    }

    /**
     * Test for the hasFieldType() method.
     *
     * @see \eZ\Publish\API\Repository\FieldTypeService::hasFieldType()
     */
    public function testHasFieldTypeReturnsFalse()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $fieldTypeService = $repository->getFieldTypeService();

        // Returns false, since type does not exist
        $typeExists = $fieldTypeService->hasFieldType('sindelfingen');
        /* END: Use Case */

        $this->assertFalse($typeExists);
    }
}
