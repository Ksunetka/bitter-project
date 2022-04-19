<template>
  <bitter-form :onSave="savePost" :onUpdate="updatePost" ref="editPost">
  </bitter-form>
  <div class="card mb-3 mt-4" v-for="post in posts" :key="post.id">
    <div class="card-header">Запись:</div>
    <div class="card-body">
      <div class="d-flex card-title">
        <div v-if="post.user.avatar">
          <img
            :src="'storage/img/' + post.user.avatar"
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
        <div class="d-flex flex-column -2">
          <router-link class="username" :to="'/profile/' + post.user.username">
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
  <edit-post ref="editPost" :onUpdatePost="updatePost"></edit-post>
</template>

<script>
import moment from "moment";
import bitterForm from "@/components/BitterForm";
import editPost from "@/components/EditPost";
import { mapGetters } from "vuex";

export default {
  name: "AllPosts",
  components: {
    bitterForm,
    editPost,
  },
  data() {
    return {
      api: "http://localhost:8081/api/auth/",
      posts: {},
      errors: [],
      moment: moment,
    };
  },
  mounted() {
    this.getPosts();
  },
  computed: {
    ...mapGetters({ user: "getUser" }),
  },
  methods: {
    getPosts() {
      this.axios
        .get(this.api + "all-posts")
        .then((response) => {
          this.posts = response.data.allPosts;
        })
        .catch(() => {});
    },
    savePost(data) {
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
        this.axios.post(this.api + "save-post", Data).then(() => {
          this.getPosts();
        });
      }
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
            this.getPosts();
          });
      }
    },
    deletePost(id) {
      if (id) {
        this.axios.delete(this.api + "delete-post/" + id).then(() => {
          this.getPosts();
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
