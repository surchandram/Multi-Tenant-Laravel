<script setup>
import { Button } from '@/components/ui/button';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import LucideIcon from './../LucideIcon.vue';
import {inject} from "vue";

const __ = inject('$translate')

defineProps({
  variant: {
    type: String,
    default: 'ghost',
  },
  size: {
    type: String,
    default: 'sm',
  },
});
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button :variant="variant" :size="size">
        <LucideIcon name="bell" class="size-[1.2rem]" :stroke-width="1.5"/>
      </Button>
    </DropdownMenuTrigger>

    <DropdownMenuContent class="w-48" align="end">
      <div class="p-4">
        {{ __('app.labels.no_notifications') }}
      </div>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
