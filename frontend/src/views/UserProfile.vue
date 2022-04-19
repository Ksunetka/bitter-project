<template>
  <user-page v-if="showProfile" :pathName="pathName"></user-page>
  <def-page v-if="showDefPage"></def-page>
</template>

<script>
import userPage from "@/components/UserPage";
import defPage from "@/components/DefPage";

export default {
  name: "UserProfile",
  components: {
    userPage,
    defPage,
  },
  data() {
    return {
      api: "http://localhost:8081/api/auth/",
      username: "",
      showProfile: false,
      showDefPage: false,
      pathName: this.$route.params.name,
    };
  },
  mounted() {
    this.getAuthUsers();
  },
  methods: {
    getAuthUsers() {
      this.axios
        .get(this.api + "users")
        .then((response) => {
          let users = response.data.users;
          for (let value of users) {
            if (value == this.pathName) {
              this.username = value;
            }
          }
          if (this.username) {
            this.showProfile = true;
          } else {
            this.showDefPage = true;
          }
        })
        .catch(() => {});
    },
  },
};
</script>
