<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllSearchGetResource\Pages;
use App\Models\AllSearchGet;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AllSearchGetResource extends Resource
{
    protected static ?string $model = AllSearchGet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('search_image_url')
                    ->label('Search Image'),
                Tables\Columns\TextColumn::make('scan_id')
                    ->label('Scan ID')
                    ->sortable()
                   ->searchable(),
                Tables\Columns\TextColumn::make('student_name')
                    ->label('Student Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('student_image_url')
                    ->label('Student Image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAllSearchGets::route('/'),
        ];
    }

}
