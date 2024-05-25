<script>
  export default {
    name: "Guest",
  };
</script>

<script setup>
  import "../../css/app.css";

  import { Modal } from "momentum-modal";
</script>

<template>
  <div class="min-h-screen">
    <!-- Main Content -->
    <main>
      <slot></slot>
    </main>
    <!-- /Main Content -->

    <!-- Modal -->
    <Modal />
    <!-- END Modal -->
  </div>
</template>
