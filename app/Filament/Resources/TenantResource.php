<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use App\Filament\Resources\TenantResource\RelationManagers;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $pluralModelLabel = "Nájomníci";
    protected static ?string $slug = "najomnici";

    protected static ?string $navigationGroup = 'Používatelia';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Nájomník')->schema([
                    TextInput::make('first_name')
                        ->label('Meno')
                        ->required(),

                    TextInput::make('last_name')
                        ->label('Priezvisko')
                        ->required(),

                    TextInput::make('address')
                        ->label('Adresa')
                        ->required(),

                    TextInput::make('email')
                        ->label('Email'),

                    TextInput::make('phone')
                        ->label('telefón'),

                    TextInput::make('iban'),
                ])->collapsible()->columns()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([

                // see getFullNameAttribute in Tenant model
                TextColumn::make('full_name')->label('Meno Nájomníka')
                    ->searchable(['first_name', 'last_name', 'full_name', 'email']),

                TextColumn::make('address')->label('Adresa'),
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
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'view' => Pages\ViewTenant::route('/{record}'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
