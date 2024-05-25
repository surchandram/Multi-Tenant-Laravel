<script setup>
  import { ref, computed } from 'vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AddressCreator from '@/components/addresses/AddressCreator.vue';
  import Address from '@/components/addresses/Address.vue';

  const props = defineProps({
    company: {
      required: true,
      type: Object,
    },
    addresses: {
      type: Array,
      default: () => [],
    },
    countries: {
      type: Array,
      default: () => [],
    },
  });

  const showForm = ref(false);
  const editing = ref(null);
  const selecting = ref(false);

  const selectedAddress = computed(() => _.find(props.addresses, 'default'));

  const edit = (address) => {
    editing.value = address;
    showForm.value = true;
  };

  const confirmDelete = (address) => {
    if (!confirm(`Are you sure you want to delete ${address.name} from addresses?`)) {
      return;
    }

    console.log('delete...');
  };
</script>

<template>
  <div>
    <AddressCreator
      v-if="showForm"
      v-model="editing"
      :action="route('companies.addresses.store', company)"
      :countries="countries"
      @close="showForm = false"
    >
      <template #buttons>
        <AppLightButton @click="showForm = false"> Cancel </AppLightButton>
      </template>
    </AddressCreator>

    <!-- Address Selector -->
    <div
      v-else-if="selecting"
      class="w-full flex flex-col"
    >
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <Address
          v-for="address in addresses"
          :key="address.id"
          :address="address"
        >
          <template #bottom>
            <div class="w-full flex flex-wrap gap-3 mt-5">
              <AppButton @click="edit(address)"> <i class="bi bi-pencil"></i> Edit </AppButton>

              <AppLightButton @click="confirmDelete(address)"> <i class="bi bi-trash"></i> Delete </AppLightButton>
            </div>
          </template>
        </Address>
      </div>
    </div>
    <!-- /Address Selector -->

    <template v-else>
      <div class="flex items-center">
        <p class="text-sm text-slate-600">Manage address information for your company here.</p>

        <aside class="flex items-center ml-auto gap-3">
          <AppButton @click="showForm = !showForm"> Add Address </AppButton>

          <!-- Change Address -->
          <AppButton
            v-if="addresses.length"
            @click="selecting = !selecting"
          >
            Change Address
          </AppButton>
        </aside>
      </div>

      <!-- Selected Address -->
      <div class="py-3 mt-3">
        <template v-if="selectedAddress">
          <p class="text-sm font-semibold mb-5">Current Address</p>

          <Address :address="selectedAddress" />
        </template>

        <p
          v-else
          class="text-xs text-slate-400 font-semibold"
        >
          No address information found.
        </p>
      </div>
    </template>
  </div>
</template>
