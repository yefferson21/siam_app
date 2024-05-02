<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoContribuyenteResource\Pages;
use App\Filament\Resources\TipoContribuyenteResource\RelationManagers;
use App\Models\TipoContribuyente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoContribuyenteResource extends Resource
{
    protected static ?string $model = TipoContribuyente::class;

    protected static ?string    $navigationIcon = 'heroicon-o-identification';
    protected static ?string    $navigationLabel = 'Tipos de Contribuyentes';
    protected static ?string    $navigationGroup = 'Parametros';
    protected static ?string    $navigationParentItem = 'Parametros Terceros';   
    protected static ?string    $modelLabel = 'Contribuyente Tipo';
    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('nombre')
            ->required()
            ->maxLength(20),
        Forms\Components\TextInput::make('descripcion')
            ->required()
            ->maxLength(255),                    

        ]);
}

public static function table(Table $table): Table
{
    return $table
    ->columns([
        Tables\Columns\TextColumn::make('nombre')
        ->searchable()
        ->sortable(),
        Tables\Columns\TextColumn::make('descripcion')
        ->sortable(),

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
            'index' => Pages\ManageTipoContribuyentes::route('/'),
        ];
    }    
}
