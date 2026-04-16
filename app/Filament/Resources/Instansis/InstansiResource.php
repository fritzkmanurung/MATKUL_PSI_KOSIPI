<?php

namespace App\Filament\Resources\Instansis;

use Modules\Sistem\Models\Instansi;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class InstansiResource extends Resource
{
    protected static ?string $model = Instansi::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;
    protected static \UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Instansi';
    protected static ?int $navigationSort = 12;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->required()->label('Nama Instansi'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat')->sortable(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstansis::route('/'),
            'create' => Pages\CreateInstansi::route('/create'),
            'edit' => Pages\EditInstansi::route('/{record}/edit'),
        ];
    }
}
