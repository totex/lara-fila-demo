<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $pluralModelLabel = "Zmluvy";
    protected static ?string $slug = "zmluvy";
    protected static ?string $navigationGroup = 'Používatelia';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tenant_id')
                    ->relationship('tenant', 'first_name')
                    ->label('Meno Nájomníka'),

                Select::make('property_id')
                    ->relationship('property', 'num')
                    ->label('Parcela / Mólo'),

                TextInput::make('num')->label('Číslo'),
                TextInput::make('bail')->numeric()->label('Kaucia'),
                TextInput::make('yearly_fee')->numeric()->label('Ročný poplatok'),
                TextInput::make('tax')->numeric()->label('Daň'),
                TextInput::make('pay_term')->numeric()->label('Platobný termín'),
                DatePicker::make('start_date'),
                DatePicker::make('length'),
                DatePicker::make('end_date'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tenant.full_name')->label('Nájomník')->searchable(['first_name', 'last_name']),
                TextColumn::make('num')->searchable()->label('Číslo'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'view' => Pages\ViewContract::route('/{record}'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
