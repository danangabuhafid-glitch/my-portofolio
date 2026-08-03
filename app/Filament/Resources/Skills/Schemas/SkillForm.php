<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('skill_category_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('title_id')
                    ->default(null),
                TextInput::make('title_en')
                    ->default(null),
                TextInput::make('percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('icon')
                    ->default(null),
            ]);
    }
}
