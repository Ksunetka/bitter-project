import { createApp } from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "../src/assets/css/style.css";

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8081/api/auth";
const token = localStorage.getItem("token");
if (token) {
  axios.defaults.headers.common["Authorization"] = token;
}

axios.interceptors.response.use(
  function (response) {
    return response;
  },
  function (error) {
    if (error) {
      console.log(error.response.data);
      const originalRequest = error.config;
      if (error.response.status === 401 && !originalRequest._retry) {
        originalRequest._retry = true;
        store.dispatch("logout").then(() => {
          return router.push({ name: "SignIn" });
          // return Promise.reject(error);
        });
      } else {
        store.commit(
          "handle_error",
          JSON.parse(JSON.stringify(error.response.data.errors))
        );
      }
      return Promise.reject(error);
    }
  }
);

createApp(App)
  .use(VueAxios, axios)
  .use(router)
  .use(store)
  .use(VueSweetalert2)
  .component("dynamic-link", {
    template: '<component v-bind:is="transformed"></component>',
    props: ["message"],
    methods: {
      convertPostMessage: function (message) {
        const spanned = `${message}`;
        return spanned
          .replace(/#([\S]*)/g, '<router-link to="/tag/$1">#$1</router-link>')
          .replace(
            /@([\S]*)/g,
            '<router-link to="/profile/$1">@$1</router-link>'
          );
      },
    },
    computed: {
      transformed() {
        const template = this.convertPostMessage(this.message);
        return {
          template: template,
          props: this.$options.props,
        };
      },
    },
  })
  .mount("#app");
