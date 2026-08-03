<?php

namespace App\Filament\Resources\Music\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class MusicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('subtitle')
                    ->maxLength(255),
                FileUpload::make('file_path')
                    ->label('Audio File (MP3)')
                    ->directory('music')
                    ->disk('public')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg'])
                    ->required(),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
