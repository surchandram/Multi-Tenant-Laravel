<div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
>
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            @if (isset($header))
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        {{ $header }}
                    </tr>
                </thead>
            @endif
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
