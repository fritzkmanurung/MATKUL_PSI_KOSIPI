<?php

namespace App\Filament\Member\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),

                // Fields Profil Kreditur (tambahan)
                TextInput::make('pekerjaan')
                    ->label('Pekerjaan')
                    ->default(null),
                Select::make('status_pegawai')
                    ->label('Status Pegawai')
                    ->options([
                        'PNS' => 'PNS',
                        'PPPK' => 'PPPK',
                        'Honorer' => 'Honorer',
                        'Swasta' => 'Swasta',
                        'Wiraswasta' => 'Wiraswasta',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->default(null),
                TextInput::make('masa_kontrak')
                    ->label('Masa Kontrak (Bulan)')
                    ->numeric()
                    ->default(null),
                Select::make('status_perkawinan')
                    ->label('Status Perkawinan')
                    ->options([
                        'Belum Kawin' => 'Belum Kawin',
                        'Kawin' => 'Kawin',
                        'Cerai Hidup' => 'Cerai Hidup',
                        'Cerai Mati' => 'Cerai Mati',
                    ])
                    ->default(null),
                TextInput::make('nama_suami_istri')
                    ->label('Nama Suami/Istri')
                    ->default(null),
            ]);
    }
}
