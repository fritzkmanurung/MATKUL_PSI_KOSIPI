<?php

namespace App\Filament\Support;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class DefaultActionGroup
{
    /**
     * Generate a standardized three-dot action group with View, Edit, and Delete actions.
     * All actions are configured to open in modals with a consistent width.
     */
    public static function make(string $modalWidth = 'md'): array
    {
        return [
            ActionGroup::make([
                ViewAction::make()
                    ->label('Lihat')
                    ->modalWidth($modalWidth),
                EditAction::make()
                    ->label('Ubah')
                    ->modalWidth($modalWidth),
                DeleteAction::make()
                    ->label('Hapus')
                    ->modalWidth($modalWidth),
            ])
            ->icon('heroicon-m-ellipsis-vertical')
            ->tooltip('Aksi')
            ->color('gray')
            ->iconButton()
            ->size('sm'),
        ];
    }

    public static function create(string $modalWidth = 'md'): \Filament\Actions\CreateAction
    {
        return \Filament\Actions\CreateAction::make()
            ->modalWidth($modalWidth);
    }
}
