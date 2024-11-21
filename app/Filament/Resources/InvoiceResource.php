<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
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

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-euro';
    protected static ?string $pluralModelLabel = "Faktúry";
    protected static ?string $slug = "faktury";
    protected static ?string $navigationGroup = 'Financie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tenant_id')
                    ->label('Nájomník')
                    ->relationship('tenant', 'full_name')
                    ->required(),
                Select::make('property_id')
                    ->label('Parcela / Mólo')
                    ->relationship('property', 'number')
                    ->required(),
                Select::make('contract_id')
                    ->label('Zmluva')
                    ->relationship('contract', 'number')
                    ->required(),
                TextInput::make('number')
                    ->label('Číslo')
                    ->required(),
                DatePicker::make('issue_date')
                    ->label('Dátum vydania')
                    ->required(),
                DatePicker::make('due_date')
                    ->label('Dátum splatnosti')
                    ->required(),
                TextInput::make('amount')
                    ->label('Suma')
                    ->numeric()
                    ->required(),
                Checkbox::make('paid')
                    ->label('Zaplatené'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('tenant.full_name')->label('Nájomník'),
                TextColumn::make('number')->label('Číslo'),
                TextColumn::make('amount')->label('Suma')->money('EUR'),
                TextColumn::make('due_date')->label('Dátum splatnosti')->date(),
                Tables\Columns\IconColumn::make('paid')->boolean()->label('Zaplatené'),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
