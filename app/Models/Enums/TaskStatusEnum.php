<?php

namespace App\Models\Enums;

enum TaskStatusEnum: string
{
    case NOT_STARTED = 'not_started';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    /**
     * @return TaskStatusEnum[]
     */
    public static function getStatuses(): array
    {
        return [
            self::NOT_STARTED,
            self::IN_PROGRESS,
            self::COMPLETED,
        ];
    }

    /**
     * @return string[]
     */
    public static function getStatusValues(): array
    {
        return [
            self::NOT_STARTED->value,
            self::IN_PROGRESS->value,
            self::COMPLETED->value,
        ];
    }
}
