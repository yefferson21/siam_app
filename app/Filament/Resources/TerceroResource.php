<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerceroResource\Pages;
use App\Filament\Resources\TerceroResource\RelationManagers;
use App\Models\Tercero;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Barrio;
use App\Models\NivelEscolar;
use App\Models\EstadoCivil;
use App\Models\Profesion;
use App\Models\Novedades;
use App\Models\TipoIdentificacion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Set;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
 

class TerceroResource extends Resource
{
    protected static ?string $model = Tercero::class;

    protected static ?string    $navigationIcon = 'heroicon-o-user-group';
    protected static ?string    $navigationLabel = 'Creacion de Terceros';  
    protected static ?string    $navigationGroup = 'Administracion de Terceros';
    protected static ?string    $modelLabel = 'Tercero';
    protected static ?int       $navigationSort = 1;

    
    public static function form(Form $form): Form
    {
        return $form

                
            ->schema([
                Wizard::make()
                ->steps([
                Wizard\Step::make('Identificacion ')
                ->columns(4)
                ->schema([
                TextInput::make('tercero_id')
                    ->markAsRequired(false)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(16)
                    ->columnSpan(2)
                    ->prefix('Id')
                    ->disabled(fn ($record) => optional($record)->exists ?? false) // Verificar si $record existe antes de acceder a ->exists
                    ->label('No. de Identificacion'),
                TextInput::make('digito_verificacion')
                    ->maxLength(1)
                    ->markAsRequired(false)
                    ->columnSpan(1)
                    ->Hidden()
                    ->label('Digito de Verificacion'),
                Select::make('tipo_identificacion_id')
                    ->relationship('tipoidentificacion', 'nombre')
                    ->columnSpan(1)
                   
                    ->label('Tipo de Identificacion'),
                    Radio::make('tipo_tercero')
                    ->required()
                    ->label('')
                    ->columnSpan(1)
                    ->options([
                        'Natural' => 'Persona Natural',
                        'Juridica' => 'Persona Juridica',
                    ]),
                ])
                ->columnSpanFull(),
                Wizard\Step::make('Datos Basicos')
                ->columns(4)
                ->schema([              
                    TextInput::make('nombres')
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(255)
                    ->columnSpan(2)
                    ->label('Nombres Completos'),
                TextInput::make('primer_apellido')
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(255)
                    ->columnSpan(1)
                    ->label('Primer Apellido'),
                TextInput::make('segundo_apellido')
                    ->maxLength(255)
                    ->markAsRequired(false)
                    ->columnSpan(1)
                    ->label('Segundo Apellido'),
                TextInput::make('telefono')
                    ->markAsRequired(false)
                    ->required()
                    ->columnSpan(1)
                    ->minLength(7)
                    ->maxLength(10)
                    ->label('No de Telefono'),      
                TextInput::make('direccion')
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(255)
                    ->columnSpan(3)
                    ->label('Direccion Residencia'),
                Select::make('pais_id')
                        ->options(Pais::query()->pluck('nombre', 'id'))
                        ->markAsRequired(false)
                        ->required()
                        ->preload()
                        ->columnSpan(1)
                        ->live()
                        ->label('Pais de Residencia'),
                Select::make('ciudad_id')
                    ->options(fn (Get $get): Collection => Ciudad::query()
                    ->where('pais_id', $get('pais_id'))
                    ->pluck('nombre', 'id'))
                    ->markAsRequired(false)
                    ->required()
                    ->columnSpan(1)
                    ->live()
                    ->preload()
                    ->label('Ciudad de Residencia'),
                Select::make('barrio_id')
                    ->options(fn (Get $get): Collection => Barrio::query()
                    ->where('ciudad_id', $get('ciudad_id'))
                    ->pluck('nombre', 'id'))
                    ->markAsRequired(false)
                    ->required()
                    ->preload()
                    ->columnSpan(2)
                    ->live()
                    ->label('Barrio'),
                TextInput::make('celular')
                    ->required()
                    ->markAsRequired(false)
                    ->minLength(10)
                    ->columnSpan(1)
                    ->suffixIcon('heroicon-m-phone')     
                    ->maxLength(12)
                    ->label('Celular'),             
                TextInput::make('email')
                    ->email()
                    ->markAsRequired(false)
                    ->required()
                    ->maxLength(255)
                    ->suffixIcon('heroicon-m-envelope-open')                    
                    ->columnSpan(3)
                    ->label('Correo Electronico'),
                Select::make('tipo_contribuyente_id')
                    ->relationship('tipocontribuyente', 'nombre')
                    ->required()
                    ->markAsRequired(false)
                    ->preload()
                    ->columnSpan(1)
                    ->label('Tipo de Contribuyente'),
                Select::make('profesion_id')
                    ->relationship('profesion', 'nombre')
                    ->required()
                    ->markAsRequired(false)
                    ->columnSpan(1)
                    ->label('Ocupacion'),
                Select::make('nivelescolar_id')
                    ->relationship('nivelescolar', 'nombre')
                    ->required()
                    ->markAsRequired(false)
                    ->preload()
                    ->columnSpan(1)
                    ->label('Nivel Escolar'),
                Select::make('estadocivil_id')
                    ->relationship('estadocivil', 'nombre')
                    ->required()
                    ->markAsRequired(false)
                    ->preload()
                    ->columnSpan(1)
                    ->label('Estado Civil'),
                Textarea::make('observaciones')
                    ->maxLength(65535)
                    ->markAsRequired(false)
                    ->columnSpanFull(),
                Toggle::make('activo')
                    ->onIcon('heroicon-m-hand-thumb-up')
                    ->offColor('danger')
                    ->offIcon('heroicon-m-hand-thumb-down')
                    ->label('Autorización tratamiento de datos personales
                    FONDEP. 
                    Responsable de los datos personales recolectados de sus Asociados con ocasión 
                    de la prestación del servicio y en atención a la ley 1581 de 2012 y del Decreto 1377 de
                     2013, Autorizo para continuar con el tratamiento de mis datos que permita recaudar, 
                     almacenar, usar, circular, suprimir, procesar, compilar, intercambiar, y en general la
                      información suministrada en este formulario, con fines que cumpla el objeto social de
                    FONDEP')
                    ->columnSpanFull()
                    ->required(),
                CheckboxList::make('autorizacion')
                    ->label('Autorizo recibir información general de Fondep por el o los siguientes medios')
                    ->options([
                        'Correo_Electronico' => 'Correo_Electronico',
                        'SMS' => 'SMS',
                        'Whatsapp' => 'Whatsapp',
                        'Grupo_Whatsapp' => 'Grupo_Whatsapp',
                    ])
                ->columns(4)
                ->gridDirection('row')
                ->columnSpanFull()
                ->hiddenOn('create'),
                ]),              
                ])->columnSpanFull(),
                
            ]);
        
                    

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tercero_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombres')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primer_apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('segundo_apellido')
                    ->searchable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->Hidden(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->Hidden(),

            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\TerceroSarlaftRelationManager::class,
            RelationManagers\InformacionFinancieraRelationManager::class,
            RelationManagers\ReferenciasRelationManager::class,
            RelationManagers\NovedadesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTerceros::route('/'),
            'create' => Pages\CreateTercero::route('/create'),
            'view' => Pages\ViewTercero::route('/{record}'),
            'edit' => Pages\EditTercero::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
