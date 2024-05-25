<script setup>
  import { useColorMode } from '@vueuse/core';
  import { Button } from '@/components/ui/button';
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu';
  import LucideIcon from './LucideIcon.vue';

  const mode = useColorMode();

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
      <Button
        :variant="variant"
        :size="size"
      >
        <LucideIcon
          name="moon"
          class="size-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0"
        />

        <LucideIcon
          name="sun"
          class="absolute size-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100"
        />
        <span class="sr-only">Toggle theme</span>
      </Button>
    </DropdownMenuTrigger>

    <DropdownMenuContent
      class="w-48"
      align="end"
    >
      <DropdownMenuItem @click="mode = 'light'">
        <LucideIcon
          v-if="mode == 'light'"
          name="check"
          class="mr-1 size-4"
        />
        Light
      </DropdownMenuItem>
      <DropdownMenuItem @click="mode = 'dark'">
        <LucideIcon
          v-if="mode == 'dark'"
          name="check"
          class="mr-1 size-4"
        />
        Dark
      </DropdownMenuItem>
      <DropdownMenuItem @click="mode = 'auto'">
        <LucideIcon
          v-if="mode == 'auto'"
          name="check"
          class="mr-1 size-4"
        />
        System
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
./LucideIcon.vue
