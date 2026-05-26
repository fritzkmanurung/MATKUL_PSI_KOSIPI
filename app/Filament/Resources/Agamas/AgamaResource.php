<?php

namespace App\Filament\Resources\Agamas;

use Modules\Sistem\Models\Agama;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class AgamaResource extends Resource
{
    protected static ?string $model = Agama::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static \UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Agama';
    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->required()->label('Nama Agama'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat')->sortable(),
            ])
            ->actions(\App\Filament\Support\DefaultActionGroup::make('sm'))
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAgamas::route('/'),
        ];
    }
}
