<script setup>
  import Modal from '@/components/modals/Modal.vue';
  import DomainUpdateForm from '../partials/DomainUpdateForm.vue';

  defineProps(['model']);
</script>

<template>
  <div>
    <Modal
      size="max-w-2xl"
      :title="__('app.labels.change_company_domain')"
    >
      <DomainUpdateForm :model="model" />
    </Modal>
  </div>
</template>
