<?php

namespace App\Filament\Member\Widgets;

use Filament\Widgets\Widget;

class MemberWelcomeWidget extends Widget
{
    protected string $view = 'filament.member.widgets.member-welcome-widget';
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = -1;
}
