<script>
  export default {
    name: "Landing",
  };
</script>

<script setup>
  import { Head } from "@inertiajs/vue3";
  import Header from "@/components/landing/Header.vue";
  import Footer from "@/components/landing/Footer.vue";

  import "../../css/landing/icofont.min.css";
  import "../../css/landing/gordita-font.css";
  import "../../css/landing.css";

  import "/node_modules/@glidejs/glide/src/assets/sass/glide.core.scss";
  import "/node_modules/@glidejs/glide/src/assets/sass/glide.theme.scss";
</script>

<template>
  <div class="w-full min-h-screen grid bg-slate-200">
    <Head :title="$page.props.appTagline" />

    <!-- Header section -->
    <Header></Header>

    <!-- Main -->
    <main>
      <slot></slot>
    </main>

    <!-- Footer section -->
    <Footer></Footer>
  </div>
</template>
