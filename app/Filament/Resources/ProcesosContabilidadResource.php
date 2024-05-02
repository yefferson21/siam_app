<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcesosContabilidadResource\Pages;
use App\Filament\Resources\ProcesosContabilidadResource\RelationManagers;
use App\Models\ProcesosContabilidad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcesosContabilidadResource extends Resource
{
    protected static ?string $model = ProcesosContabilidad::class;

    protected static ?string    $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string    $navigationLabel = 'Procesos';
    protected static ?string    $navigationGroup = 'Contabilidad';
    protected static ?int       $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListProcesosContabilidads::route('/'),
            'create' => Pages\CreateProcesosContabilidad::route('/create'),
            'edit' => Pages\EditProcesosContabilidad::route('/{record}/edit'),
        ];
    }
}
