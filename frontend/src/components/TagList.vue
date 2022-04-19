<template>
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card mb-3 mt-4" v-for="post in post_tag" :key="post.id">
        <div class="card-header">Запись:</div>
        <div class="card-body">
          <div class="d-flex card-title">
            <div v-if="post.user.avatar">
              <img
                :src="'../storage/img/' + post.user.avatar"
                class="img-fluid img-post"
                alt="avatar"
              />
            </div>
            <div v-else-if="post.user.gender == 'woman'">
              <img
                src="../assets/img/default/woman_avatar.png"
                class="img-fluid img-post"
              />
            </div>
            <div v-else-if="post.user.gender == 'man'">
              <img
                src="../assets/img/default/man_avatar.png"
                class="img-fluid img-post"
              />
            </div>
            <div class="d-flex flex-column ms-2">
              <router-link
                class="username"
                :to="'/profile/' + post.user.username"
              >
                {{ "@" + post.user.username }}
              </router-link>
              <small class="text-muted time-post">{{
                moment(post.updated_at).format("HH:mm:ss / DD.MM.YYYY")
              }}</small>
            </div>
          </div>
          <p class="post-message">
            <dynamic-link :message="post.message"></dynamic-link>
          </p>
          <div
            v-if="user.id == post.user_id"
            class="d-grid gap-2 d-md-flex justify-content-md-end"
          >
            <button
              type="button"
              class="update-post btn btn-info"
              data-bs-toggle="modal"
              data-bs-target="#postModal"
              @click="editPost(post.id, post.message)"
            >
              <i class="bi bi-pencil-fill"></i>
            </button>
            <button
              type="button"
              class="delete-post btn btn-danger"
              @click="deletePost(post.id)"
            >
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <edit-post ref="editPost" :onUpdatePost="updatePost"></edit-post>
</template>

<script>
import moment from "moment";
import { mapGetters } from "vuex";
import editPost from "@/components/EditPost";

export default {
  name: "TagList",
  components: {
    editPost,
  },
  data() {
    return {
      api: "http://localhost:8081/api/auth/",
      post_tag: {},
      tag_name: "",
      moment: moment,
    };
  },
  mounted() {
    this.getPostByTag();
  },
  computed: {
    ...mapGetters({ user: "getUser" }),
  },
  methods: {
    getPostByTag() {
      this.tag_name = this.$route.params.name;
      this.axios
        .get(this.api + "tag/" + this.tag_name)
        .then((response) => {
          this.post_tag = response.data.posts;
        })
        .catch(() => {});
    },
    updatePost(data) {
      if (data.post_message.length > 0) {
        let tags = [];
        let usernames = [];
        let Data = {
          message: data.post_message,
        };
        tags = data.post_message.match(/#([\S]*)/g);
        if (tags) {
          tags = tags.map((name) => name.replace(/#/g, ""));
          Data = { ...Data, tags: tags };
        }
        usernames = data.post_message.match(/@([\S]*)/g);
        if (usernames) {
          usernames = usernames.map((name) => name.replace(/@/g, ""));
          Data = { ...Data, usernames: usernames };
        }
        this.axios
          .patch(this.api + "update-post/" + data.edit_post_id, Data)
          .then(() => {
            this.getPostByTag();
          });
      }
    },
    deletePost(id) {
      if (id) {
        this.axios.delete(this.api + "delete-post/" + id).then(() => {
          this.getPostByTag();
        });
      }
    },
    editPost(id, message) {
      this.$refs.editPost.modalShow = true;
      this.$refs.editPost.post_message = message;
      this.$refs.editPost.edit_post_id = id;
    },
  },
};
</script>
