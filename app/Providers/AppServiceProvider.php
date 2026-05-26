<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        // Konsistensi Tombol Filament (Maksimal 2 Kata)
        
        // General Actions (berlaku untuk Pages, Tables, Infolists)
        CreateAction::configureUsing(fn (CreateAction $action) => $action->label('Tambah')->icon('heroicon-o-plus')->color('primary'));
        EditAction::configureUsing(fn (EditAction $action) => $action->label('Ubah')->icon('heroicon-o-pencil-square')->color('warning'));
        ViewAction::configureUsing(fn (ViewAction $action) => $action->label('Lihat')->icon('heroicon-o-eye')->color('info'));
        DeleteAction::configureUsing(fn (DeleteAction $action) => $action->label('Hapus')->icon('heroicon-o-trash')->color('danger'));
        ForceDeleteAction::configureUsing(fn (ForceDeleteAction $action) => $action->label('Hapus Permanen')->icon('heroicon-o-trash')->color('danger'));
        RestoreAction::configureUsing(fn (RestoreAction $action) => $action->label('Pulihkan')->icon('heroicon-o-arrow-uturn-left')->color('success'));

        // Bulk Actions
        DeleteBulkAction::configureUsing(fn (DeleteBulkAction $action) => $action->label('Hapus')->icon('heroicon-o-trash')->color('danger'));
        ForceDeleteBulkAction::configureUsing(fn (ForceDeleteBulkAction $action) => $action->label('Hapus Permanen')->icon('heroicon-o-trash')->color('danger'));
        RestoreBulkAction::configureUsing(fn (RestoreBulkAction $action) => $action->label('Pulihkan')->icon('heroicon-o-arrow-uturn-left')->color('success'));
    }
}
