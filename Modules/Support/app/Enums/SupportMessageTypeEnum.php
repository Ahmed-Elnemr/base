<?php
namespace Modules\Support\app\Enums;

enum SupportMessageTypeEnum: string {
    case Inquiry    = 'inquiry';
    case Suggestion = 'suggestion';
    case Complaint  = 'complaint';
    case Other      = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Inquiry    => __('General inquiry'),
            self::Complaint  => __('Complaint'),
            self::Suggestion => __('Suggestion'),
            self::Other      => __('Other'),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn(self $case) => [$case->value => $case->label()]
        )->toArray();
    }
}
