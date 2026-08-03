<?php

namespace App\Filament\Resources\ProjectCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_id')
                    ->default(null),
                TextInput::make('title_en')
                    ->default(null),
            ]);
    }
}
