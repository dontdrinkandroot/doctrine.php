<?php

namespace Dontdrinkandroot\Repository;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class CrudOperation
{
    const CREATE = 'CREATE';
    const READ = 'READ';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';

    public static function all(): array
    {
        return [self::CREATE, self::READ, self::UPDATE, self::DELETE];
    }
}
