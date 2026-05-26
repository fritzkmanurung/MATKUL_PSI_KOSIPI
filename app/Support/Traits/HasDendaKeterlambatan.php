<?php

namespace App\Support\Traits;

use Modules\Sistem\Models\DendaKeterlambatan;
use Modules\Sistem\Models\TenggatWaktu;
use Carbon\Carbon;

/**
 * Reusable trait for models that need late payment penalty calculation.
 */
trait HasDendaKeterlambatan
{
    /**
     * Determine if the record is late based on its due date.
     * Must be implemented by the consuming model.
     */
    abstract public function getIsTelatAttribute(): bool;

    /**
     * Get the number of days late.
     * Must be implemented by the consuming model.
     */
    abstract public function getJumlahHariTelatAttribute(): int;

    /**
     * Get the penalty type string for DendaKeterlambatan lookup.
     * Override in the model if different.
     */
    protected function getDendaJenis(): string
    {
        return 'Simpanan Wajib';
    }

    /**
     * Calculate the penalty amount.
     */
    public function getHitungDendaAttribute(): float
    {
        if (! $this->is_telat) {
            return 0;
        }

        $dendaRate = DendaKeterlambatan::getAktif($this->getDendaJenis());

        if (! $dendaRate) {
            return 0;
        }

        return (float) ($this->jumlah_hari_telat * $dendaRate->nominal_denda);
    }
}
