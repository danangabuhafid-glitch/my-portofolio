<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_id')
                    ->default(null),
                TextInput::make('title_en')
                    ->default(null),
                Textarea::make('content_id')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('content_en')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('seo_title_id')
                    ->default(null),
                TextInput::make('seo_title_en')
                    ->default(null),
                Textarea::make('meta_description_id')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('meta_description_en')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
