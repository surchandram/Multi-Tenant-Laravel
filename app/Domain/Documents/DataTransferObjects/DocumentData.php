<?php

namespace SAAS\Domain\Documents\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Documents\Models\Document;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class DocumentData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $uuid,
        public readonly string $title,
        public readonly ?string $body,
        public readonly ?string $created_at,
        public readonly ?string $signature,
        public readonly bool $signed = false,
        public readonly null|Lazy|DocumentTypeData $type = null,
        public readonly bool $is_editable = true,
        public readonly bool $usable = false,
    ) {
    }

    public static function fromSignature(int $id, string $signature): self
    {
        $document = Document::find($id);

        return self::from([
            ...$document->toArray(),
            'signature' => $signature,
        ]);
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'type' => DocumentTypeData::fromId($request->type_id),
        ]);
    }

    public static function fromModel(Document $document): self
    {
        return self::from([
            ...$document->toArray(),
            'signature' => $document->pivot?->signature,
            'signed' => filled($document->pivot?->signature),
            'type' => Lazy::whenLoaded(
                'type',
                $document,
                fn () => DocumentTypeData::fromModel($document->type)
            ),
        ]);
    }
}
