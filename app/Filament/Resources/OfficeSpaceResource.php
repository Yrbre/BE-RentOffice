<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficeSpaceResource\Pages;
use App\Filament\Resources\OfficeSpaceResource\RelationManagers;
use App\Models\OfficeSpace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfficeSpaceResource extends Resource
{
    protected static ?string $model = OfficeSpace::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),

                    Forms\Components\FileUpload::make('thumbnail')
                        ->image()
                        ->directory('office-thumbnails')
                        ->maxSize(1024),

                    Forms\Components\Textarea::make('about')
                    ->required()
                    ->rows(10)
                    ->cols(20),

                    Forms\Components\Repeater::make('photos')
                    ->relationship('photos')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                        ->required(),
                    ]),

                    Forms\Components\Repeater::make('benefits')
                    ->relationship('benefits')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                        ->required(),
                    ]),

                    Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                    Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),

                    Forms\Components\TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->prefix('Days'),

                    Forms\Components\Toggle::make('is_open')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-bolt-slash')
                    ->onColor('success')
                    ->offColor('danger'),


                    Forms\Components\Toggle::make('is_full_booked')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-bolt-slash')
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->money('idr', true)->sortable(),
                Tables\Columns\IconColumn::make('is_open')
                    ->boolean()
                    ->trueIcon('heroicon-m-bolt')
                    ->falseIcon('heroicon-m-bolt-slash'),
                Tables\Columns\IconColumn::make('is_full_booked')
                    ->boolean()
                    ->trueIcon('heroicon-m-bolt')
                    ->falseIcon('heroicon-m-bolt-slash'),
                Tables\Columns\ImageColumn::make('thumbnail')->circular(),
            ])
            ->filters([
                    Tables\Filters\SelectFilter::make('city_id')
                        ->relationship('city', 'name')
                        ->label('City'),
                    Tables\Filters\TernaryFilter::make('is_open')
                    ->label('Open'),
                    Tables\Filters\TernaryFilter::make('is_full_booked')
                    ->label('Full Booked'),
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
            'index' => Pages\ListOfficeSpaces::route('/'),
            'create' => Pages\CreateOfficeSpace::route('/create'),
            'edit' => Pages\EditOfficeSpace::route('/{record}/edit'),
        ];
    }
}
