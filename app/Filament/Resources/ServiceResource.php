<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Termwind\Components\Raw;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $label = 'Serviço';
    protected static ?string $pluralLabel = 'Serviços';
    protected static ?string $slug = 'servicos';
    protected static ?string $navigationGroup = '#';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $activeNavigationIcon = 'heroicon-s-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do Serviço')
                    ->minLength(3)
                    ->maxLength(255)
                    ->placeholder('Digite o nome do serviço')
                    ->columnSpanFull()
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Descrição do Serviço')
                    ->placeholder('Descreva um pouco sobre o serviço')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('duration_minutes')
                    ->label('Duração (em minutos)')
                    ->placeholder('Digite a duração do serviço em minutos')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('R$')
                    ->suffix(',00'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Serviços')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Duração (minutos)')
                    ->badge()
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),

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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
