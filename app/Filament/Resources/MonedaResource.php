<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonedaResource\Pages;
use App\Filament\Resources\MonedaResource\RelationManagers;
use App\Models\Moneda;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;

class MonedaResource extends Resource
{
    protected static ?string $model = Moneda::class;

    protected static ?string    $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?string    $navigationLabel = 'Monedas';
    protected static ?string    $navigationGroup = 'Parametros';
    protected static ?string    $navigationParentItem = 'Parametros Generales';   
    protected static ?string    $modelLabel = 'Moneda';

    public static function form(Form $form): Form
    {
        return $form

        ->schema([
            Wizard::make()
                ->steps([
                    Wizard\Step::make('Step1')
                        ->schema([
                            TextInput::make('codigo')
                                ->required()
                                ->maxLength(3),
                                ]),
                    Wizard\Step::make('Step2')
                        ->schema([
                            TextInput::make('nombre')
                                ->required()
                                ->maxLength(255),
                                ]),
                        ])
                ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('codigo')
                ->searchable(),
            Tables\Columns\TextColumn::make('nombre')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMonedas::route('/'),
        ];
    }    
}
