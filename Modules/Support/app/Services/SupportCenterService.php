<?php

namespace Modules\Support\app\Services;

use Modules\Support\app\Enums\SupportMessageStatusEnum;
use Modules\Support\app\Enums\SupportMessageTypeEnum;
use Modules\Support\app\Models\SupportMessage;
use Modules\Support\app\Models\SupportPage;

class SupportCenterService
{
    public function __construct(
        private readonly SupportPage $supportPage,
        private readonly SupportMessage $supportMessage,
    ) {
    }

    public function getActivePage(): ?SupportPage
    {
        return $this->supportPage->newQuery()
            ->active()
            ->with('media')
            ->latest('updated_at')
            ->first();
    }

    public function messageTypes(): array
    {
        return collect(SupportMessageTypeEnum::cases())
            ->map(fn (SupportMessageTypeEnum $case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ])
            ->values()
            ->toArray();
    }

    public function persistMessage(array $payload): SupportMessage
    {
        $page = $this->getActivePage();

        if ($page) {
            $payload['support_page_id'] = $page->id;
        }

        $payload['status'] = SupportMessageStatusEnum::New->value;
        $payload['locale'] = app()->getLocale();

        return $this->supportMessage->newQuery()->create($payload);
    }
}

