<?php

namespace App\Traits;

trait BasicAudit
{
    protected static function bootBasicAudit()
    {
        $self = new static;

        static::creating(function ($model) {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });

        static::deleting(function ($model) use ($self) {
            if ($self->isSoftDeleteEnabled()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }

    public function isSoftDeleteEnabled()
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this)) && ! $this->forceDeleting;
    }
}
