<?php

namespace App\Filament\Resources\TenggatWaktus;

use App\Filament\Resources\TenggatWaktus\Pages\CreateTenggatWaktu;
use App\Filament\Resources\TenggatWaktus\Pages\EditTenggatWaktu;
use App\Filament\Resources\TenggatWaktus\Pages\ListTenggatWaktus;
use App\Filament\Resources\TenggatWaktus\Schemas\TenggatWaktuForm;
use App\Filament\Resources\TenggatWaktus\Tables\TenggatWaktusTable;
use Modules\Sistem\Models\TenggatWaktu;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class TenggatWaktuResource extends Resource
{
    protected static ?string $model = TenggatWaktu::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $navigationLabel = 'Tenggat Bayar';
    protected static ?string $modelLabel = 'Tenggat Waktu Tagihan';
    protected static ?string $pluralModelLabel = 'Tenggat Waktu Tagihan';
    protected static \UnitEnum|string|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return TenggatWaktuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenggatWaktusTable::configure($table);
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
            'index' => Pages\ManageTenggatWaktus::route('/'),
        ];
    }
}
