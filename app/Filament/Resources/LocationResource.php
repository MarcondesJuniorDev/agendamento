<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Filament\Resources\LocationResource\RelationManagers;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;
    protected static ?string $label = 'Local';
    protected static ?string $pluralLabel = 'Locais';
    protected static ?string $slug = 'locais';
    protected static ?string $navigationGroup = '#';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $activeNavigationIcon = 'heroicon-s-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do Local')
                    ->minLength(3)
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('O local deve ter um nome único')
                    ->unique(ignoreRecord: true, column: 'name')
                    ->required(),

                Forms\Components\TextInput::make('address')
                    ->label('Endereço')
                    ->helperText('Exemplo: Rua das Flores, 123')
                    ->minLength(3)
                    ->maxLength(255),

                Forms\Components\TextInput::make('city')
                    ->label('Cidade')
                    ->helperText('Exemplo: Manaus')
                    ->minLength(3)
                    ->maxLength(255),

                Forms\Components\TextInput::make('state')
                    ->label('Estado')
                    ->helperText('Exemplo: AM')
                    ->mask('aa'),

                Forms\Components\TextInput::make('zip_code')
                    ->label('CEP')
                    ->helperText('Exemplo: 69000-000')
                    ->mask('99999-999'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Local')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->sortable()
                    ->searchable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->limit(10),

                Tables\Columns\TextColumn::make('state')
                    ->label('Estado')
                    ->searchable()
                    ->limit(2),

                Tables\Columns\TextColumn::make('zip_code')
                    ->label('CEP')
                    ->searchable()
                    ->limit(10),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
