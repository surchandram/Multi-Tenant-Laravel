<?php

namespace SAAS\Domain\Documents\DataTransferObjects;

use SAAS\Domain\Documents\Models\DocumentType;
use Spatie\LaravelData\Data;

class DocumentTypeData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly ?string $created_at,
        public readonly bool $usable = false,
    ) {
    }

    public static function fromString(string $slug): self
    {
        return self::fromModel(DocumentType::whereSlug($slug)->first());
    }

    public static function fromId(int $id): self
    {
        return self::fromModel(DocumentType::find($id));
    }

    public static function fromModel(DocumentType $documentType): self
    {
        return self::from([
            ...$documentType->toArray(),
        ]);
    }
}
