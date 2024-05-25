<?php

namespace SAAS\Domain\WebApps\Enums\Apps;

use Illuminate\Support\Arr;

enum Restore: string
{
    case APP_KEY = 'restore';

    case PROJECT_TYPES_COLORS = 'restore_project_types_colors';

    case FEATURE_PROJECTS = 'restore_projects';
    case FEATURE_MOISTURE_MAP = 'restore_moisture_map';
    case FEATURE_PSYCHROMETRIC_REPORT = 'restore_psychrometric_report';
    case FEATURE_WORK_REPORT = 'restore_work_report';

    public static function settings()
    {
        return RestoreSettings::settings();
    }

    public function features()
    {
        return Arr::where(self::cases(), fn ($value, $key) => str($key)->startsWith('FEATURE_'));
    }
}
