<aside
    x-data="{ 
        open: false, 
        active: 'timeline', 
        handleDisplay() {
            if(this.open === false) { 
               this.open = true 
               return
            }
            this.open = false
        } 
    }"
    class="w-48 flex flex-col aside-menu border-l border-gray-300"
    style="display: none"
    x-show="open"
    x-on:aside-menu-toggle.window="handleDisplay"
>
    <ul class="flex items-center bg-white border-b border-gray-300" role="tablist">
        <li class="nav-item border-r last:border-r-0">
            <x-button
                type="button"
                no-pad
                is-text
                size="sm"
                class="px-4 py-3"
                data-toggle="tab"
                @click="active = 'timeline'"
                role="tab"
            >
                <i class="icon-list"></i>
            </x-button>
        </li>
        <li class="nav-item border-r last:border-r-0">
            <x-button
                type="button"
                no-pad
                is-text
                size="sm"
                class="px-4 py-3"
                data-toggle="tab"
                @click="active = 'messages'"
                role="tab"
            >
                <i class="icon-speech"></i>
            </x-button>
        </li>
        <li class="nav-item border-r last:border-r-0">
            <x-button
                type="button"
                no-pad
                is-text
                size="sm"
                class="px-4 py-3"
                data-toggle="tab"
                @click="active = 'settings'"
                role="tab"
            >
                <i class="icon-settings"></i>
            </x-button>
        </li>
    </ul><!-- /.nav -->

    <!-- Tab panes -->
    <div class="w-full h-full flex flex-col">
        <div class="tab-pane" id="timeline" role="tabpanel" x-show="active === 'timeline'">
            <h6 class="my-3 mx-3">{{ __('Timeline') }}</h6>
        </div>
        <div class="tab-pane p-3" id="messages" role="tabpanel" x-show="active === 'messages'">
            <h6>{{ __('Messages') }}</h6>
        </div>
        <div class="tab-pane p-3" id="settings" role="tabpanel" x-show="active === 'settings'">
            <h6>{{ __('Settings') }}</h6>
        </div>
    </div><!-- /.tab-content -->
</aside>
