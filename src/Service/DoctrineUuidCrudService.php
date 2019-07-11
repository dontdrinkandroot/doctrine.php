<?php

namespace Dontdrinkandroot\Service;

/**
 * @deprecated
 */
class DoctrineUuidCrudService extends DoctrineCrudService
{
    protected $uuidField = 'uuid';

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        if (self::isUuid($id)) {
            return $this->findOneBy([$this->uuidField => $id]);
        }

        return parent::find($id, $lockMode, $lockVersion);
    }

    public static function isUuid($id)
    {
        return 1 === preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $id);
    }
}
