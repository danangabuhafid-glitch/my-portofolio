<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project_category_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('title_id')
                    ->default(null),
                TextInput::make('title_en')
                    ->default(null),
                Textarea::make('description_id')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description_en')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('content_id')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('content_en')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('status')
                    ->default(null),
                TextInput::make('url')
                    ->url()
                    ->default(null),
                TextInput::make('repo_url')
                    ->url()
                    ->default(null),
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
