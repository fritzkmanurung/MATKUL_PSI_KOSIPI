<?php

namespace App\Filament\Member\Resources\TagihanWajibAnggotas;

use App\Filament\Member\Resources\TagihanWajibAnggotas\Pages\ListTagihanWajibAnggotas;
use App\Filament\Member\Resources\TagihanWajibAnggotas\Pages\ViewTagihanWajibAnggota;
use Modules\Simpanan\Models\TagihanWajib;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;

class TagihanWajibAnggotaResource extends Resource
{
    protected static ?string $model = TagihanWajib::class;

    protected static ?string $modelLabel = 'Tagihan Simpanan Wajib';
    protected static ?string $pluralModelLabel = 'Tagihan Simpanan Wajib';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'kode_tagihan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_tagihan')->label('Kode')->searchable()->sortable(),
                TextColumn::make('periode')->label('Periode')->sortable(),
                TextColumn::make('nominal_tagihan')->label('Nominal')->money('IDR')->sortable(),
                TextColumn::make('status')->label('Status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Lunas' => 'success',
                        'Menunggu Verifikasi' => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('tanggal_bayar')->label('Tgl Bayar')->date('d/m/Y'),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTagihanWajibAnggotas::route('/'),
            'view' => ViewTagihanWajibAnggota::route('/{record}'),
        ];
    }
}
