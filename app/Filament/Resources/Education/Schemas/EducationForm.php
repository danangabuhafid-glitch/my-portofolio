<?php

namespace App\Filament\Resources\Education\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_id')
                    ->default(null),
                TextInput::make('title_en')
                    ->default(null),
                TextInput::make('school')
                    ->default(null),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Textarea::make('description_id')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description_en')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
