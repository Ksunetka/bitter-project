<template>
  <navigation></navigation>
  <div class="container">
    <router-view :key="$route.fullPath"></router-view>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar";

export default {
  name: "App",
  components: {
    navigation: NavBar,
  },
};
</script>

<style></style>
