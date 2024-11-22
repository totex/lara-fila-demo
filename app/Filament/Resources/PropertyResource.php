<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $pluralModelLabel = "Parcely / Móla";
    protected static ?string $slug = "parcely-mola";

    protected static ?string $navigationGroup = 'Oblasti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Oblasti')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Typ')
                            ->options(['parcel' => 'Parcela', 'pier' => 'Mólo'])
                            ->required(),
                        Forms\Components\Select::make('area_id')
                            ->label('Územie')
                            ->relationship('area', 'name')
                            ->required(),
                        TextInput::make('number')
                            ->label('Číslo parcely/móla')
                            ->required(),

                        Forms\Components\Select::make('tenant_id')
                            ->label('Nájomník')
//                            ->relationship('tenant', 'first_name')
                            ->relationship('tenant', 'full_name')
//                            ->options(Tenant::all()->pluck('full_name', 'id'))
//                            ->getSearchResultsUsing(fn (string $search): array => Tenant::where('first_name', 'like', "%{$search}%")
//                                ->limit(5)->pluck('first_name', 'id')->toArray())
//                            ->relationship(
//                                name: 'tenant',
//                                modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
//                            )
//                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}")

                            ->searchable(['first_name', 'last_name', 'full_name', 'email'])
//                            ->live()
//                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('first_name')
                                    ->label('Meno')
                                    ->required(),
                                Forms\Components\TextInput::make('last_name')
                                    ->label('Priezvisko')
                                    ->required(),
                                Forms\Components\TextInput::make('address')
                                    ->label('Adresa')
                                    ->required(),
                            ]),

                        TextInput::make('old_num')->label('Staré číslo parcely/móla'),
                        TextInput::make('size_m2')->label('Veľkosť m2'),
                        DatePicker::make('evi_start')->label('Zaraďená do evidencii'),
                        DatePicker::make('evi_end')->label('Vyraďená z evidencii'),

//                Forms\Components\RichEditor::make('evi_end_rsn')
//                    ->label('Dôvod vyradenia')
//                    ->columnSpan('full'),

                        Textarea::make('evi_end_rsn')
                            ->label('Dôvod vyradenia')
                            ->columnSpan('full'),

//                        Forms\Components\Select::make('invoice_id')
//                            ->label('Faktúra')
//                            ->relationship('invoice', 'number'),

                    ])->collapsible()->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                // see getPropertyTypeAttribute in Property model
                TextColumn::make('property_type')
                    ->label('Typ'),

                TextColumn::make('area.name')
                    ->label('Územie')
                    ->icon('heroicon-o-magnifying-glass')
                    ->searchable(),

                TextColumn::make('tenant.full_name')
                    ->label('Nájomník')
                    ->icon('heroicon-o-magnifying-glass')
                    ->searchable(['first_name', 'last_name']),

                TextColumn::make('number')
                    ->label('Číslo')
                    ->icon('heroicon-o-magnifying-glass')
                    ->searchable()
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(['parcel' => 'parcela', 'pier' => 'mólo'])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\TenantRelationManager::class,
            RelationManagers\ContractRelationManager::class,
            RelationManagers\InvoiceRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'view' => Pages\ViewProperty::route('/{record}'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
