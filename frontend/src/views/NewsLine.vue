<template>
  <div class="row justify-content-center">
    <div class="col-md-7">
      <all-posts></all-posts>
    </div>
  </div>
</template>

<script>
import allPosts from "@/components/AllPosts";

export default {
  name: "NewsLine",
  components: {
    allPosts,
  },
};
</script>
