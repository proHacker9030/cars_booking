<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    public function __construct()
    {
        $modelFqcn = static::getModelFqcn();
        if (!class_exists($modelFqcn)) {
            throw new \InvalidArgumentException(sprintf('The specified class "%s" does not exist.', $modelFqcn));
        }

        if (!is_subclass_of($modelFqcn, Model::class)) {
            throw new \InvalidArgumentException(sprintf(
                'The specified class "%s" must be subclass of "%s".', $modelFqcn, Model::class
            ));
        }
    }

    /**
     * @return Model|string the Eloquent instance class FQCN
     */
    abstract public static function getModelFqcn(): Model|string;
}
