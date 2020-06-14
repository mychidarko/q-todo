<template>
  <div>
    <Navbar />
    <div class="container mt-4">
      <new-todo />
      <div class="login">Home</div>
    </div>
  </div>
</template>

<script>
import Navbar from "@/app/general/components/Navbar.vue";
export default {
  name: "Home",
  components: {
    Navbar
  }
};
</script>