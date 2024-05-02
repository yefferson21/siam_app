<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoNovedadClienteResource\Pages;
use App\Filament\Resources\TipoNovedadClienteResource\RelationManagers;
use App\Models\TipoNovedadCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class TipoNovedadClienteResource extends Resource
{
    protected static ?string $model = TipoNovedadCliente::class;

    protected static ?string    $navigationIcon = 'heroicon-o-folder';
    protected static ?string    $navigationLabel = 'Tipos de Novedades Clientes';
    protected static ?string    $navigationGroup = 'Parametros';
    protected static ?string    $navigationParentItem = 'Parametros Terceros';   
    protected static ?string    $modelLabel = 'Tipo Novedad Cliente';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('codigo')
                ->required()
                ->maxLength(3),
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('descripcion')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('cambiaestado')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('nuevoestado')
                ->required()
                ->maxLength(3),
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
            Tables\Columns\TextColumn::make('cambiaestado')
                ->searchable(),
            Tables\Columns\TextColumn::make('nuevoestado')
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
            'index' => Pages\ManageTipoNovedadClientes::route('/'),
        ];
    }    



}
