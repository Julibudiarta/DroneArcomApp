<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncidentResource\Pages;
use App\Filament\Resources\IncidentResource\RelationManagers;
use App\Models\drone;
use App\Models\fligh;
use App\Models\fligh_location;
use App\Models\Incident;
use App\Models\project;
use App\Models\User;
use Filament\Forms;
use Filament\Infolists\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Stichoza\GoogleTranslate\GoogleTranslate;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;
    // protected static ?string $navigationLabel = 'Incident';

    protected static ?string $navigationIcon = 'heroicon-m-exclamation-triangle';
    public static ?string $tenantOwnershipRelationshipName = 'teams';
    public static ?int $navigationSort = 7;
    public static ?string $navigationGroup = 'flight';
    protected static bool $isLazy = false;
    
    public static function getNavigationBadge(): ?string{
        return static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return GoogleTranslate::trans('Incident', session('locale') ?? 'en');
    }
    public static function getModelLabel(): string
    {
        return GoogleTranslate::trans('Incident', session('locale') ?? 'en');
    }


    public static function form(Form $form): Form
    {
        $currentTeamId = auth()->user()->teams()->first()->id;
        return $form
            ->schema([
                Forms\Components\Section::make(GoogleTranslate::trans('Incident Overview', session('locale') ?? 'en'))
                    ->description('')
                    ->schema([
                    Forms\Components\Hidden::make('teams_id')
                        ->default(auth()->user()->teams()->first()->id ?? null),
                    Forms\Components\DatePicker::make('incident_date')
                    ->label(GoogleTranslate::trans('Incident Date', session('locale') ?? 'en'))
                    ->required(),
                    Forms\Components\TextInput::make('cause')
                        ->label(GoogleTranslate::trans('Incident Cause', session('locale') ?? 'en'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->label(GoogleTranslate::trans('Status', session('locale') ?? 'en'))
                        ->required()
                        ->options([
                            false => 'Closed',
                            true => 'Under Review',
                        ]),
                    // Forms\Components\BelongsToSelect::make('location_id')
                    Forms\Components\Select::make('location_id')
                        // ->relationship('fligh_locations', 'name')
                        ->options(function (callable $get) use ($currentTeamId) {
                            return fligh_location::where('teams_id', $currentTeamId)->pluck('name', 'id');
                        })
                        ->searchable()
                        ->label(GoogleTranslate::trans('Flight Locations', session('locale') ?? 'en'))
                        ->required(),
                        // ->searchable(),
                     Forms\Components\Select::make('drone_id')
                        // ->relationship('drone','name')
                        ->label(GoogleTranslate::trans('Drone', session('locale') ?? 'en'))
                        ->options(function (callable $get) use ($currentTeamId) {
                            return drone::where('teams_id', $currentTeamId)->pluck('name', 'id');
                        })
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('project_id')
                        // ->relationship('project','case')
                        ->label(GoogleTranslate::trans('Projects', session('locale') ?? 'en'))
                        ->options(function (callable $get) use ($currentTeamId) {
                            return project::where('teams_id', $currentTeamId)->pluck('case', 'id');
                        })
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('personel_involved_id')
                    ->label(GoogleTranslate::trans('Organization Personnel Involved', session('locale') ?? 'en'))
                        ->options(
                            function (Builder $query) use ($currentTeamId) {
                                return User::whereHas('teams', function (Builder $query) use ($currentTeamId) {
                                    $query->where('team_user.team_id', $currentTeamId); 
                            })->pluck('name','id');
                        }  
                        )->searchable()
                        ->columnSpanFull(),
                    ])->columns(2),
                    //section 2
                Forms\Components\Section::make(GoogleTranslate::trans('Insiden Description', session('locale') ?? 'en'))
                    ->description('')
                    ->schema([
                        Forms\Components\TextArea::make('aircraft_damage')->label(GoogleTranslate::trans('Aircraft Damage', session('locale') ?? 'en'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextArea::make('other_damage')->label(GoogleTranslate::trans('Other Damage', session('locale') ?? 'en'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextArea::make('description')->label(GoogleTranslate::trans('Description', session('locale') ?? 'en'))
                        ->required()
                        ->maxLength(255)->columnSpanFull(),
                    Forms\Components\TextInput::make('incuration_type')->label(GoogleTranslate::trans('Incursions (people, aircraft...)', session('locale') ?? 'en'))
                        ->required()
                        ->maxLength(255)->columnSpanFull(),
                    ])->columns(2),
                    //section 3
                Forms\Components\Section::make(GoogleTranslate::trans('Incident Rectification', session('locale') ?? 'en'))
                ->description('')
                ->schema([
                    Forms\Components\TextInput::make('rectification_note')->label(GoogleTranslate::trans('Rectification Notes', session('locale') ?? 'en'))
                        ->required()
                        ->maxLength(255)->columnSpanFull(),
                    Forms\Components\DatePicker::make('rectification_date')->label(GoogleTranslate::trans('Rectification Date', session('locale') ?? 'en'))
                        ->required(),
                    Forms\Components\TextInput::make('Technician')->label(GoogleTranslate::trans('Technician', session('locale') ?? 'en'))
                        ->required()
                        ->maxLength(255),
                ])->columns(2),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('incident_date')
                    ->label(GoogleTranslate::trans('Incident Date', session('locale') ?? 'en'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cause')
                    ->label(GoogleTranslate::trans('Cause', session('locale') ?? 'en'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('aircraft_damage')
                    ->label(GoogleTranslate::trans('Aircraft Damage', session('locale') ?? 'en'))
                    ->searchable(),

                // Tables\Columns\TextColumn::make('other_damage')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('description')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('incuration_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('rectification_note')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('rectification_date')
                //     ->date()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('Technician')
                    ->label(GoogleTranslate::trans('Technician', session('locale') ?? 'en'))
                    ->searchable(),

                // Tables\Columns\TextColumn::make('location_id')
                //     ->numeric()
                //     ->sortable(),

                Tables\Columns\TextColumn::make('drone.name')
                    ->label(GoogleTranslate::trans('Drones', session('locale') ?? 'en'))
                    ->numeric()
                    ->url(fn($record) => $record->drone_id?route('filament.admin.resources.drones.view', [
                        'tenant' => Auth()->user()->teams()->first()->id,
                        'record' => $record->drone_id,
                    ]):null)->color(Color::Blue)
                    ->sortable(),
                Tables\Columns\TextColumn::make('project.case')
                    ->label(GoogleTranslate::trans('Projects', session('locale') ?? 'en'))
                    ->numeric()
                    ->url(fn($record) => $record->project_id?route('filament.admin.resources.projects.index', [
                        'tenant' => Auth()->user()->teams()->first()->id,
                        'record' => $record->project_id,
                    ]):null)->color(Color::Blue)
                    ->sortable(),
                // Tables\Columns\TextColumn::make('personel_involved_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(GoogleTranslate::trans('Created at', session('locale') ?? 'en'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('Updated at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])



            ->filters([
                //
            ])
            ->actions([
                // Action::make('viewFlight')
                // ->label('View Flight')
                // ->url(function ($record) {
                //     $flight = fligh::where('projects_id', $record->project_id)
                //         ->where('location_id', $record->location_id)
                //         ->where('drones_id', $record->drone_id)
                //         ->orderBy('start_date_flight', 'desc')
                //         ->first();

                //     if (!$flight) {
                //             $flight = fligh::where('drones_id', $record->drone_id)
                //                 ->orderBy('start_date_flight', 'desc')
                //                 ->first();
                //         }

                //     return $flight
                //         ? route('filament.admin.resources.flighs.view', [
                //             'tenant' => auth()->user()->teams()->first()->id,
                //             'record' => $flight->id,
                //         ])
                //         : null; 
                // })
                // ->button()
                // ->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Section::make('Incident Overview')
                ->schema([
                    TextEntry::make('incident_date')->label(GoogleTranslate::trans('Incident Date', session('locale') ?? 'en')),
                    TextEntry::make('cause')->label(GoogleTranslate::trans('Cause', session('locale') ?? 'en')),
                    TextEntry::make('status')->label(GoogleTranslate::trans('Status', session('locale') ?? 'en')),
                    TextEntry::make('location_id')->label(GoogleTranslate::trans('Locations', session('locale') ?? 'en')),
                    TextEntry::make('drone.name')
                        ->label(GoogleTranslate::trans('Drones', session('locale') ?? 'en'))
                        ->url(fn($record) => $record->drone_id?route('filament.admin.resources.drones.view', [
                            'tenant' => Auth()->user()->teams()->first()->id,
                            'record' => $record->drone_id,
                        ]):null)->color(Color::Blue),
                    TextEntry::make('project.case')
                        ->label(GoogleTranslate::trans('Projects', session('locale') ?? 'en'))
                        ->url(fn($record) => $record->project_id?route('filament.admin.resources.projects.index', [
                            'tenant' => Auth()->user()->teams()->first()->id,
                            'record' => $record->project_id,
                        ]):null)->color(Color::Blue),
                    TextEntry::make('personel_involved_id')->label(GoogleTranslate::trans('Organization Personnel Involved', session('locale') ?? 'en')),
                ])->columns(4),
            Section::make('Insiden Description')
                ->schema([
                    TextEntry::make('aircraft_damage')->label(GoogleTranslate::trans('Aircraft Damage', session('locale') ?? 'en')),
                    TextEntry::make('other_damage')->label(GoogleTranslate::trans('Other Damage', session('locale') ?? 'en')),
                    TextEntry::make('description')->label(GoogleTranslate::trans('Description', session('locale') ?? 'en')),
                    TextEntry::make('incuration_type')->label(GoogleTranslate::trans('Incuration Type', session('locale') ?? 'en')),
                ])->columns(4),
            Section::make('Incident Rectification')
                ->schema([
                    TextEntry::make('rectification_note')->label(GoogleTranslate::trans('Rectification Note', session('locale') ?? 'en')),
                    TextEntry::make('rectification_date')->label(GoogleTranslate::trans('Rectification Date', session('locale') ?? 'en')),
                    TextEntry::make('Technician')->label(GoogleTranslate::trans('Technician', session('locale') ?? 'en')),
                ])->columns(3)
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
            'index' => Pages\ListIncidents::route('/'),
            'create' => Pages\CreateIncident::route('/create'),

            //'view' => Pages\ViewIncident::route('/{record}'),

            'edit' => Pages\EditIncident::route('/{record}/edit'),
        ];
    }
}
