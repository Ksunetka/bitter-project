<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid" v-if="isLoggedIn">
      <div class="navbar-header">
        <router-link class="navbar-brand" :to="{ name: 'NewsLine' }">
          <img
            src="../assets/bitter.png"
            alt="logo"
            width="32"
            height="32"
            class="d-inline-block align-text-top"
          />
          Bitter</router-link
        >
      </div>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarScrollingDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            >Пользователь
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <router-link class="dropdown-item" :to="'/profile/' + user.username"
              >Профиль</router-link
            >
            <li>
              <a class="dropdown-item" @click="logout()">Выйти</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="container-fluid" v-else>
      <div class="navbar-header">
        <router-link class="navbar-brand" :to="{ name: 'HomePage' }">
          <img
            src="../assets/bitter.png"
            alt=""
            width="32"
            height="32"
            class="d-inline-block align-text-top"
          />
          Bitter</router-link
        >
      </div>
      <ul class="navbar-nav">
        <router-link class="nav-item nav-link" :to="{ name: 'SignIn' }"
          >Вход</router-link
        >
        <router-link class="nav-item nav-link" :to="{ name: 'SignUp' }"
          >Регистрация</router-link
        >
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "NavBar",
  computed: {
    ...mapGetters({ user: "getUser" }),
    isLoggedIn() {
      return this.$store.getters.isLoggedIn;
    },
  },
  created() {
    if (this.isLoggedIn) {
      this.$store.dispatch("getUser");
    }
  },
  methods: {
    async logout() {
      await this.$store.dispatch("logout");
      await this.$router.push({ name: "SignIn" });
    },
  },
};
</script>
