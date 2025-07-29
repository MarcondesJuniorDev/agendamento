<?php

namespace App\Filament\Resources\ProfessionalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';
    protected static ?string $title = 'Serviços';
    protected static ?string $label = 'Serviço';
    protected static ?string $pluralLabel = 'Serviços';
    protected static ?string $icon = 'heroicon-o-sparkles';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service.name')
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
