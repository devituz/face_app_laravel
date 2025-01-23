<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiAdminsResource\Pages;
use App\Filament\Resources\ApiAdminsResource\RelationManagers;
use App\Models\ApiAdmins;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiAdminsResource extends Resource
{
    protected static ?string $model = ApiAdmins::class;
    protected static ?string $navigationLabel = 'Mobile admins';
    protected static ?string $label = 'Mobile admins';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label("Admin nomi"),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('categories')
                    ->nullable()
                    ->required()
                    ->disk('public')
                    ->label("Admin rasmi"),

                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->maxLength(15)
                    ->label("Telefon raqam")
                    ->tel(),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255)
                    ->email()
                    ->label("Email"),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->maxLength(255)
                    ->label("Parol"),
                Forms\Components\Toggle::make('is_admin')
                    ->label("Adminmi?")
                    ->required()
                    ->default(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->label("Id"),
                TextColumn::make('name')
                    ->searchable()
                    ->label("Admin nomi"),

                ImageColumn::make('image')
                    ->disk('public')
                    ->label("Admin rasmi")
                    ->circular()
                    ->width(60)
                    ->height(60),

                TextColumn::make('phone')
                    ->searchable()
                    ->label("Telefon raqam"),

                TextColumn::make('email')
                    ->searchable()
                    ->label("Email"),
                TextColumn::make('password')
                    ->label("Parol")
                    ->searchable(),
//                    ->formatStateUsing(fn ($state) => '********'),

                TextColumn::make('formattedCreatedAt')
                    ->label("Yaratilgan vaqti"),
            ])
            ->filters([
                // Custom filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApiAdmins::route('/'),
            'create' => Pages\CreateApiAdmins::route('/create'),
            'edit' => Pages\EditApiAdmins::route('/{record}/edit'),
        ];
    }
}
