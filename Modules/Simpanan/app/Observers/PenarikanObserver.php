<?php

namespace Modules\Simpanan\Observers;

use Modules\Simpanan\Models\Penarikan;
use Modules\Simpanan\Models\TotalSimpanan;

class PenarikanObserver
{
    public function saved(Penarikan $penarikan): void
    {
        TotalSimpanan::recalculate($penarikan->user_id);
    }

    public function deleted(Penarikan $penarikan): void
    {
        TotalSimpanan::recalculate($penarikan->user_id);
    }
}
