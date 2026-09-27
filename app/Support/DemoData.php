<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;

use function array_map;
use function resource_path;

/**
 * Local demo data for the example dashboard pages (resources/data).
 */
class DemoData
{
    /**
     * @return list<array<string, mixed>>
     */
    public static function customers(): array
    {
        return self::load('customers');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function members(): array
    {
        return self::load('members');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function mails(): array
    {
        return self::withDates(self::load('mails'));
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function notifications(): array
    {
        return self::withDates(self::load('notifications'));
    }

    /**
     * @return array<string, mixed>
     */
    public static function billing(): array
    {
        /** @var array<string, mixed> $billing */
        $billing = File::json(resource_path('data/billing.json'));

        return [...$billing, 'invoices' => self::withDates(self::load('invoices'))];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private static function load(string $name): array
    {
        /** @var list<array<string, mixed>> */
        return File::json(resource_path("data/{$name}.json"));
    }

    /**
     * Replace the stored "minutes_ago" offset with a date relative to now.
     *
     * @param  list<array<string, mixed>>  $items
     * @return list<array<string, mixed>>
     */
    private static function withDates(array $items): array
    {
        $now = Date::now();

        return array_map(static function (array $item) use ($now): array {
            $minutesAgo = (int) $item['minutes_ago'];
            unset($item['minutes_ago']);

            return [...$item, 'date' => $now->copy()->subMinutes($minutesAgo)->toIso8601String()];
        }, $items);
    }
}
