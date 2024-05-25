<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use SAAS\Domain\Documents\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // document types
        foreach (\SAAS\Domain\Documents\Enums\DocumentType::cases() as $type) {
            DocumentType::firstOrCreate([
                'name' => $type->label(),
                'slug' => $type->value,
            ], [
                'usable' => true,
            ]);
        }
    }
}
