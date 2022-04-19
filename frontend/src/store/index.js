import { createStore } from "vuex";
import axios from "axios";

export default createStore({
  state: {
    status: "",
    token: localStorage.getItem("token") || "",
    user: {},
    error: {},
  },
  mutations: {
    auth_request(state) {
      state.status = "loading";
    },
    auth_success(state, token) {
      state.status = "success";
      state.token = token;
    },
    set_user(state, user) {
      state.user = user;
    },
    handle_error(state, error) {
      state.error = error;
    },
    logout(state) {
      state.status = "";
      state.token = "";
    },
  },
  actions: {
    login({ commit }, user) {
      return new Promise((resolve, reject) => {
        commit("auth_request");
        axios
          .post("login", user)
          .then((res) => {
            const token = "Bearer " + res.data.access_token;
            const user = res.data.user;
            localStorage.setItem("token", token);
            axios.defaults.headers.common["Authorization"] = token;
            commit("auth_success", token, user);
            commit("set_user", user);
            commit("handle_error", {});
            resolve(res);
          })
          .catch((err) => {
            localStorage.removeItem("token");
            reject(err);
          });
      });
    },
    register({ commit }, user) {
      return new Promise((resolve, reject) => {
        commit("auth_request");
        axios
          .post("register", user)
          .then((resp) => {
            const token = "Bearer " + resp.data.access_token;
            const user = resp.data.user;
            localStorage.setItem("token", token);
            axios.defaults.headers.common["Authorization"] = token;
            commit("auth_success", token, user);
            commit("set_user", user);
            commit("handle_error", {});
            resolve(resp);
          })
          .catch((error) => {
            localStorage.removeItem("token");
            reject(error);
          });
      });
    },
    logout({ commit }) {
      return new Promise((resolve) => {
        commit("logout");
        localStorage.removeItem("token");
        delete axios.defaults.headers.common["Authorization"];
        resolve();
      });
    },
    getUser({ commit }) {
      return new Promise((resolve) => {
        axios.get("user").then((res) => {
          commit("set_user", res.data);
          // commit("set_username", res.data.username);
          // console.log(res.data.username);
          // console.log(res.data.user);
          resolve(res);
        });
      });
    },
  },
  getters: {
    isLoggedIn: (state) => state.token,
    authStatus: (state) => state.status,
    getUser: (state) => state.user,
    getError: (state) => state.error,
  },
  // modules: {},
});
