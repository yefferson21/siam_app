<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoIdentificacionResource\Pages;
use App\Filament\Resources\TipoIdentificacionResource\RelationManagers;
use App\Models\TipoIdentificacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoIdentificacionResource extends Resource
{
    protected static ?string $model = TipoIdentificacion::class;

    protected static ?string    $navigationIcon = 'heroicon-o-identification';
    protected static ?string    $navigationLabel = 'Tipos de Identificacion';
    protected static ?string    $navigationGroup = 'Parametros';
    protected static ?string    $navigationParentItem = 'Parametros Terceros';   
    protected static ?string    $modelLabel = 'Identificacion Tipo';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('codigo')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255),
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
            'index' => Pages\ManageTipoIdentificacions::route('/'),
        ];
    }    
}
