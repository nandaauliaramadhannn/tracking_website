<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid as RamseyUuid;

trait Uuid
{
    /**
     * Boot the UUID trait for the model.
     *
     * @return void
     */
    protected static function bootUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = static::generateUuid();
            }
        });
    }

    /**
     * Generate a UUID for the model.
     *
     * @return string
     */
    protected static function generateUuid(): string
    {
        return RamseyUuid::uuid4()->toString();
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * Cast the primary key to string.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            $this->getKeyName() => 'string',
        ];
    }
}
