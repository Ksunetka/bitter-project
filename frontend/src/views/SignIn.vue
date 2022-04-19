<template>
  <form v-on:submit.prevent="signIn">
    <h1 class="text-center">Войти</h1>
    <div class="mb-3">
      <label for="username" class="form-label">Логин</label>
      <input
        type="text"
        v-model="logData.username"
        class="form-control"
        id="username"
        placeholder="Введите имя пользователя"
      />
      <span class="text-danger" v-if="errors.username && !showError">{{
        errors.username[0]
      }}</span>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Пароль</label>
      <input
        type="password"
        v-model="logData.password"
        class="form-control"
        id="password"
        placeholder="Введите пароль"
      />
      <span class="text-danger" v-if="errors.password && !showError">{{
        errors.password[0]
      }}</span>
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1" />
      <label class="form-check-label" for="exampleCheck1">Запомнить</label>
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
  </form>
  <div v-if="showError" class="alert alert-danger mt-2" role="alert">
    {{ authError }}
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "SignIn",
  data() {
    return {
      logData: {
        username: "",
        password: "",
      },
      showError: false,
      authError: "",
    };
  },
  computed: {
    ...mapGetters({ errors: "getError" }),
  },
  methods: {
    ...mapActions(["login"]),
    signIn() {
      this.$store
        .dispatch("login", this.logData)
        .then(() => {
          this.$router.push({ path: "/profile/" + this.logData.username });
        })
        .catch((error) => {
          if (error.response.data.error) {
            this.showError = true;
            this.authError = error.response.data.error;
          }
        });
    },
  },
};
</script>
