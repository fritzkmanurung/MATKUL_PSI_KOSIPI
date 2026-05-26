@props([
    'title',
    'link',
    'isFirst' => false,
    'isLast' => false,
])

<li @class([
    'flex items-center gap-4 py-2 relative',
    'before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:top-1/2 before:bottom-0 before:left-[0.4rem] before:absolute' => $isFirst,
    'before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:bottom-1/2 before:top-0 before:left-[0.4rem] before:absolute' => $isLast,
    'before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:top-0 before:bottom-0 before:left-[0.4rem] before:absolute' => !$isFirst && !$isLast,
])>
    <span class="relative py-1 bg-white dark:bg-[#161615]">
        <span class="flex items-center justify-center rounded-full bg-[#FDFDFC] dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border dark:border-[#3E3E3A] border-[#e3e3e0]">
            <span class="rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] w-1.5 h-1.5"></span>
        </span>
    </span>
    <span>
        <a href="{{ $link }}" target="_blank" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433]">
            <span>{{ $title }}</span>
            <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5">
                <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
            </svg>
        </a>
    </span>
</li>
