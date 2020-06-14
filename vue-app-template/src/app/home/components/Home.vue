<template>
  <div>
    <Navbar />
    <new-todo />
    <div class="login">Home</div>
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