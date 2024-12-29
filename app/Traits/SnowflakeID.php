<?php

namespace App\Traits;

use App\Helpers\Snowflake;

trait SnowflakeID
{
    /**
     * Boot function from Laravel.
     */
    protected static function bootSnowflakeId()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (new Snowflake)->short();
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
}
