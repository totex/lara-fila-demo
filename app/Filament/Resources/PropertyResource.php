<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
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
                Forms\Components\Select::make('type')->label('Typ')->options(['parcel' => 'Parcela', 'pier' => 'Mólo']),
                Forms\Components\Select::make('tenant_id')->relationship('tenant', 'first_name'),
                Forms\Components\Select::make('area_id')->relationship('area', 'name'),
                TextInput::make('num')->label('Číslo parcely/móla'),
                TextInput::make('old_num')->label('Staré číslo parcely/móla'),
                TextInput::make('size_m2')->label('Veľkosť m2'),
                DatePicker::make('evi_start')->label('Zaraďená do evidencii'),
                DatePicker::make('evi_end')->label('Vyraďená z evidencii'),
                Textarea::make('evi_end_rsn')->label('Dôvod vyradenia'),
                Forms\Components\Select::make('invoice_id')->relationship('invoice', 'number'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // see getPropertyTypeAttribute in Property model
                TextColumn::make('property_type')->label('Typ'),

                TextColumn::make('area.name')->label('Územie')->searchable(),
                TextColumn::make('tenant.full_name')->label('Nájomník')->searchable(['first_name', 'last_name']),
                TextColumn::make('num')->label('Číslo')->searchable()
            ])
            ->filters([
                SelectFilter::make('type')->options(['parcel' => 'parcela', 'pier' => 'mólo'])
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
            //
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
