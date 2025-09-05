<?php

namespace Venture\Aeon\Enums;

enum MigrationsEnum
{
    case Cache;
    case CacheLocks;
    case Jobs;
    case JobBatches;
    case FailedJobs;
    case Sessions;

    public function table(): string
    {
        return match ($this) {
            self::Cache => 'laravel_cache',
            self::CacheLocks => 'laravel_cache_locks',
            self::Jobs => 'laravel_jobs',
            self::JobBatches => 'laravel_job_batches',
            self::FailedJobs => 'laravel_failed_jobs',
            self::Sessions => 'laravel_sessions',
        };
    }
}
