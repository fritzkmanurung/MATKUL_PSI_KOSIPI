<?php

namespace App\Filament\Resources\DendaKeterlambatans;

use App\Filament\Resources\DendaKeterlambatans\Pages\ManageDendaKeterlambatans;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Placeholder;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Sistem\Models\DendaKeterlambatan;
use App\Filament\Support\MoneyFormatter;
use App\Filament\Support\StatusHelper;

class DendaKeterlambatanResource extends Resource
{
    protected static ?string $model = DendaKeterlambatan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;
    protected static ?string $navigationLabel = 'Denda';
    protected static ?string $modelLabel = 'Denda Keterlambatan';
    protected static ?string $pluralModelLabel = 'Denda Keterlambatan';
    protected static \UnitEnum|string|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 11;

    protected static ?string $recordTitleAttribute = 'nominal_denda';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('jenis_denda')
                    ->label('Jenis Denda')
                    ->options([
                        'Simpanan Wajib' => 'Simpanan Wajib',
                        'Pinjaman' => 'Pinjaman',
                    ])
                    ->required(),
                TextInput::make('nominal_denda')
                    ->required()
                    ->numeric()
                    ->inputMode('numeric')
                    ->step(1)
                    ->mask(\Filament\Support\RawJs::make('$money($input, \',\', \'.\', 0)'))
                    ->stripCharacters('.')
                    ->extraInputAttributes([
                        'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                        'onfocus' => "this.value == '0' ? this.value = '' : null",
                    ])
                    ->prefix('Rp')
                    ->label('Nominal Denda (Per Hari)')
                    ->helperText('Nominal denda ini akan dikalikan dengan jumlah hari keterlambatan.')
                    ->default(0),
                Toggle::make('is_aktif')
                    ->label('Aktifkan Nominal Ini?')
                    ->required()
                    ->hiddenOn('view'),
                Placeholder::make('status_label')
                    ->label('Status Aturan')
                    ->content(fn ($record) => new HtmlString(Blade::render('<x-koperasi.status-badge :status="$status" />', [
                        'status' => $record?->is_aktif ? 'Aktif' : 'Non-aktif'
                    ])))
                    ->visibleOn('view'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nominal_denda')
            ->columns([
                StatusHelper::applyBadge(
                    TextColumn::make('jenis_denda')
                )->label('Jenis Denda')->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('nominal_denda')
                )->label('Nominal Denda (Per Hari)')->sortable(),
                IconColumn::make('is_aktif')
                    ->label('Status Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions(\App\Filament\Support\DefaultActionGroup::make('md'))
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDendaKeterlambatans::route('/'),
        ];
    }
}
