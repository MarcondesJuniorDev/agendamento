<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $label = 'Consulta';
    protected static ?string $pluralLabel = 'Consultas';
    protected static ?string $slug = 'consultas';
    protected static ?string $navigationGroup = '#';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $activeNavigationIcon = 'heroicon-s-calendar-days';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
