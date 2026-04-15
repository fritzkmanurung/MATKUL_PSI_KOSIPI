<?php

namespace App\Filament\Resources\TagihanPinjamen;

use App\Filament\Resources\TagihanPinjamen\Pages\CreateTagihanPinjaman;
use App\Filament\Resources\TagihanPinjamen\Pages\EditTagihanPinjaman;
use App\Filament\Resources\TagihanPinjamen\Pages\ListTagihanPinjamen;
use App\Filament\Resources\TagihanPinjamen\Pages\ViewTagihanPinjaman;
use App\Filament\Resources\TagihanPinjamen\Schemas\TagihanPinjamanForm;
use App\Filament\Resources\TagihanPinjamen\Schemas\TagihanPinjamanInfolist;
use App\Filament\Resources\TagihanPinjamen\Tables\TagihanPinjamenTable;
use App\Filament\Resources\TagihanPinjamen\TagihanPinjamanResource\Pages;
use Modules\Pinjaman\Models\TagihanPinjaman;
use Filament\Forms;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagihanPinjamanResource extends Resource
{
    protected static ?string $model = TagihanPinjaman::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TagihanPinjamanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TagihanPinjamanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagihanPinjamenTable::configure($table);
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
            'index' => ListTagihanPinjamen::route('/'),
            'create' => CreateTagihanPinjaman::route('/create'),
            'view' => ViewTagihanPinjaman::route('/{record}'),
            'edit' => EditTagihanPinjaman::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
