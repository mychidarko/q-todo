<template>
  <div>
    <Navbar />
    <div class="container mt-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from "@/app/general/components/Navbar.vue";

export default {
  name: "Main",
  components: {
    Navbar
  }
};
</script>