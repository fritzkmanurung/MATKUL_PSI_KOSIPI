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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Tagihan';
    protected static ?string $modelLabel = 'Tagihan Pinjaman';
    protected static \UnitEnum|string|null $navigationGroup = 'Pinjaman';
    protected static ?int $navigationSort = 6;
    protected static bool $shouldRegisterNavigation = false;

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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['pinjaman.user']);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canForceDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canForceDeleteAny(): bool
    {
        return false;
    }

    public static function canRestore(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canRestoreAny(): bool
    {
        return false;
    }
}
