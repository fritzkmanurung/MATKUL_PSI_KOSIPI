<?php

namespace App\Filament\Resources\BesaranSimpanans;

use App\Filament\Resources\BesaranSimpanans\Pages\ManageBesaranSimpanans;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Placeholder;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\Simpanan\Models\BesaranSimpanan;
use App\Filament\Support\MoneyFormatter;
use App\Filament\Support\StatusHelper;

class BesaranSimpananResource extends Resource
{
    protected static ?string $model = BesaranSimpanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;
    protected static ?string $modelLabel = 'Besaran Simpanan';
    protected static ?string $pluralModelLabel = 'Besaran Simpanan';
    protected static \UnitEnum|string|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'nominal';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_simpanan')
                    ->label('Jenis Simpanan')
                    ->options([
                        'Pokok' => 'Pokok',
                        'Wajib' => 'Wajib',
                    ])
                    ->required()
                    ->default('Wajib'),
                TextInput::make('nominal')
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
            ->recordTitleAttribute('nominal')
            ->columns([
                StatusHelper::applyBadge(
                    TextColumn::make('jenis_simpanan')
                )->label('Jenis Simpanan')->sortable()->searchable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('nominal')
                )->sortable(),
                IconColumn::make('is_aktif')
                    ->label('Status Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis_simpanan')
                    ->label('Jenis Simpanan')
                    ->options([
                        'Pokok' => 'Pokok',
                        'Wajib' => 'Wajib',
                    ]),
            ])
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
            'index' => ManageBesaranSimpanans::route('/'),
        ];
    }
}
