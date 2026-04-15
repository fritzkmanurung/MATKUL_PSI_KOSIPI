<?php

namespace Modules\Simpanan\Observers;

use Modules\Simpanan\Models\Simpanan;
use Modules\Simpanan\Models\TotalSimpanan;

class SimpananObserver
{
    public function saved(Simpanan $simpanan): void
    {
        TotalSimpanan::recalculate($simpanan->user_id);
    }

    public function deleted(Simpanan $simpanan): void
    {
        TotalSimpanan::recalculate($simpanan->user_id);
    }
}
