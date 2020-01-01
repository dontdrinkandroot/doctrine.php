<?php

namespace Dontdrinkandroot\Util;

use Dontdrinkandroot\Entity\AssignedIdExampleEntity;
use Dontdrinkandroot\Utils\EntityUtils;
use PHPUnit\Framework\TestCase;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class EntityUtilsTest extends TestCase
{
    public function testIsUuid()
    {
        $this->assertTrue(EntityUtils::isUuid('f2362e34-a40d-11e9-9768-4a27d89dc929'));
        $this->assertTrue(EntityUtils::isUuid('8c1b199d-054f-4acb-9e66-69fe93a0a514'));

        $this->assertFalse(EntityUtils::isUuid(null));
        $this->assertFalse(EntityUtils::isUuid('test'));
        $this->assertFalse(EntityUtils::isUuid(12345));
    }

    public function testCollectIds()
    {
        $this->assertEquals([], EntityUtils::collectIds([]));

        $entity1 = new AssignedIdExampleEntity();
        $entity1->setName('Seven');
        $entity1->setId(7);

        $entity2 = new AssignedIdExampleEntity();
        $entity2->setName('Three');
        $entity2->setId(3);

        $this->assertEquals([7, 3], EntityUtils::collectIds([$entity1, $entity2]));
    }
}
