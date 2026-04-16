<?php

namespace App\Filament\Resources\TagihanWajibs;

use App\Filament\Resources\TagihanWajibs\Pages\CreateTagihanWajib;
use App\Filament\Resources\TagihanWajibs\Pages\EditTagihanWajib;
use App\Filament\Resources\TagihanWajibs\Pages\ListTagihanWajibs;
use App\Filament\Resources\TagihanWajibs\Pages\ViewTagihanWajib;
use App\Filament\Resources\TagihanWajibs\Schemas\TagihanWajibForm;
use App\Filament\Resources\TagihanWajibs\Schemas\TagihanWajibInfolist;
use App\Filament\Resources\TagihanWajibs\Tables\TagihanWajibsTable;
use Modules\Simpanan\Models\TagihanWajib;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TagihanWajibResource extends Resource
{
    protected static ?string $model = TagihanWajib::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $modelLabel = 'Tagihan Simpanan Wajib';
    protected static ?string $pluralModelLabel = 'Tagihan Simpanan Wajib';
    protected static ?string $navigationLabel = 'Tagihan Wajib';
    protected static \UnitEnum|string|null $navigationGroup = 'Tagihan';
    protected static ?int $navigationSort = 8;
    protected static ?string $recordTitleAttribute = 'kode_tagihan';

    public static function form(Schema $schema): Schema
    {
        return TagihanWajibForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TagihanWajibInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagihanWajibsTable::configure($table);
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
            'index' => ListTagihanWajibs::route('/'),
            'view' => ViewTagihanWajib::route('/{record}'),
            'edit' => EditTagihanWajib::route('/{record}/edit'),
        ];
    }
}
