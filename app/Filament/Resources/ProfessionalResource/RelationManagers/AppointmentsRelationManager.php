<?php

namespace App\Filament\Resources\ProfessionalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';
    protected static ?string $title = 'Consultas';
    protected static ?string $label = 'Consulta';
    protected static ?string $pluralLabel = 'Consultas';
    protected static ?string $icon = 'heroicon-o-calendar-days';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Solicitante')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Select::make('professional_id')
                    ->label('Profissional')
                    ->required()
                    ->relationship('user', 'name', fn($query) => $query->whereHas('roles', function ($q) {
                        $q->where('name', 'professional');
                    })),

                Forms\Components\Select::make('service_id')
                    ->label('Serviço')
                    ->relationship('service', 'name')
                    ->required(),

                Forms\Components\Select::make('location_id')
                    ->label('Localização')
                    ->relationship('location', 'name')
                    ->required(),

                Forms\Components\DatePicker::make('appointment_date')
                    ->label('Data do Agendamento')
                    ->required(),
                Forms\Components\TimePicker::make('appointment_time')
                    ->label('Hora do Agendamento')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'pendente' => 'Pendente',
                        'agendado' => 'Agendado',
                        'concluido' => 'Concluído',
                        'cancelado' => 'Cancelado',
                    ]),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Solicitante')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('professional.user.name')
                    ->label('Profissional')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Serviço')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location.name')
                    ->label('Local')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Data do Agendamento')
                    ->dateTime('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('appointment_time')
                    ->label('Hora do Agendamento')
                    ->dateTime('H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),

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
