<template>
  <form v-on:submit.prevent="signUp">
    <h1 class="text-center">Регистрация</h1>
    <div class="mb-3">
      <label for="first_name" class="form-label">Имя</label>
      <input
        type="text"
        v-model="regData.first_name"
        class="form-control"
        id="first_name"
      />
      <span class="text-danger" v-if="errors.first_name">{{
        errors.first_name[0]
      }}</span>
    </div>
    <div class="mb-3">
      <label for="last_name" class="form-label">Фамилия</label>
      <input
        type="text"
        v-model="regData.last_name"
        class="form-control"
        id="last_name"
      />
      <span class="text-danger" v-if="errors.last_name">{{
        errors.last_name[0]
      }}</span>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input
        type="email_address"
        v-model="regData.email"
        class="form-control"
        id="email"
      />
      <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Имя пользователя</label>
      <div class="input-group">
        <span class="input-group-text" id="basic-addon1">@</span>
        <input
          type="text"
          v-model="regData.username"
          class="form-control"
          id="username"
          aria-describedby="basic-addon1"
        />
      </div>
      <span class="text-danger" v-if="errors.username">{{
        errors.username[0]
      }}</span>
    </div>
    <div class="mb-3">
      <label for="gender" class="form-label">Пол</label>
      <select
        class="form-select"
        v-model="regData.gender"
        id="gender"
        aria-label="Default select example"
      >
        <option value="man">Мужской</option>
        <option value="woman">Женский</option>
      </select>
      <span class="text-danger" v-if="errors.gender">{{
        errors.gender[0]
      }}</span>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Пароль</label>
      <input
        type="password"
        v-model="regData.password"
        class="form-control"
        id="password"
      />
      <span class="text-danger" v-if="errors.password">{{
        errors.password[0]
      }}</span>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Подтвердить пароль</label>
      <input
        type="password"
        v-model="regData.password_confirmation"
        class="form-control"
        id="password_confirmation"
      />
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
  </form>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "SignUp",
  data() {
    return {
      regData: {
        first_name: "",
        last_name: "",
        email: "",
        username: "",
        gender: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  computed: {
    ...mapGetters({ errors: "getError" }),
  },
  methods: {
    ...mapActions(["register"]),
    signUp() {
      this.$store
        .dispatch("register", this.regData)
        .then(() => {
          this.$router.push({ path: "/profile/" + this.regData.username });
        })
        .catch(() => {});
    },
  },
};
</script>
