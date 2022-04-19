<template>
  <section style="background-color: #9de2ff">
    <div class="container py-5">
      <div class="flex-card">
        <div class="col col-md-9 col-lg-7 col-xl-5">
          <div class="card" style="border-radius: 15px">
            <div class="card-body p-4">
              <div class="d-flex text-black">
                <div v-if="show" class="flex-avatar">
                  <div class="avatar-upload">
                    <div class="avatar-edit">
                      <input
                        type="file"
                        id="imageUpload"
                        class="form-control form-control-sm"
                        ref="reset"
                        @change="imageSelected"
                      />
                      <div class="save-image" v-if="imagePreview">
                        <label for="imageUpload"></label>
                        <i class="bi bi-check-lg" @click="uploadImage"></i>
                        <i class="bi bi-x-lg" @click="closeModal"></i>
                      </div>
                      <label for="imageUpload" v-else>
                        <i class="bi bi-camera"></i>
                      </label>
                      <div v-if="imagePreview">
                        <img
                          :src="imagePreview"
                          class="img-fluid"
                          alt="avatar"
                        />
                      </div>
                      <div class="upload-image" v-else>
                        <div v-if="user.avatar">
                          <img
                            :src="'../storage/img/' + user.avatar"
                            class="img-fluid"
                            alt="avatar"
                          />
                        </div>
                        <div v-else-if="user.gender == 'woman'">
                          <img
                            src="../assets/img/default/woman_avatar.png"
                            class="img-fluid"
                          />
                        </div>
                        <div v-else-if="user.gender == 'man'">
                          <img
                            src="../assets/img/default/man_avatar.png"
                            class="img-fluid"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <a
                    class="link-info mt-3"
                    data-bs-toggle="modal"
                    data-bs-target="#profileModal"
                    @click="editProfile(user)"
                  >
                    Редактировать
                  </a>
                </div>
                <div v-else class="flex-avatar">
                  <div class="avatar-image">
                    <div v-if="user.avatar">
                      <img
                        :src="'../storage/img/' + user.avatar"
                        class="img-fluid"
                        alt="avatar"
                      />
                    </div>
                    <div v-else-if="user.gender == 'woman'">
                      <img
                        src="../assets/img/default/woman_avatar.png"
                        class="img-fluid"
                      />
                    </div>
                    <div v-else-if="user.gender == 'man'">
                      <img
                        src="../assets/img/default/man_avatar.png"
                        class="img-fluid"
                      />
                    </div>
                  </div>
                </div>
                <div class="flex-info">
                  <h5 class="mb-1">
                    {{ user.first_name }} {{ user.last_name }}
                  </h5>
                  <p class="mb-1 pb-1">{{ "@" + user.username }}</p>
                  <p class="email mb-2">{{ user.email }}</p>
                  <div class="flex-list p-2 mb-2">
                    <div class="d-flex flex-column align-items-center">
                      <p class="small text-muted mb-1">Articles</p>
                      <p class="mb-0" id="count-posts">{{ count }}</p>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                      <p class="small text-muted mb-1">Followers</p>
                      <p class="mb-0">{{ user.id }}</p>
                    </div>
                  </div>
                  <div class="d-flex pt-1" v-if="!show">
                    <button type="button" class="btn btn-primary flex-grow-1">
                      Follow
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-7">
        <div v-if="show">
          <bitter-form :onSave="savePost"></bitter-form>
        </div>
        <div class="card mb-3" v-for="post in posts" :key="post.id">
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
              v-if="authUser.id == post.user_id"
              class="d-grid gap-2 d-sm-flex justify-content-sm-end"
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
        <div
          v-if="found"
          class="alert alert-light d-flex justify-content-center mt-2"
          role="alert"
        >
          Записей нет
        </div>
        <edit-post ref="editPost" :onUpdatePost="updatePost"></edit-post>
      </div>
    </div>
  </section>
  <edit-profile ref="editProfile" :onUpdateProfile="updateProfile">
  </edit-profile>
</template>

<script>
import { mapGetters } from "vuex";
// import userPosts from "@/components/UserPosts";
import moment from "moment";
import editProfile from "@/components/EditProfile";
import bitterForm from "@/components/BitterForm";
import editPost from "@/components/EditPost";

export default {
  name: "UserProfile",
  components: {
    // userPosts,
    bitterForm,
    editPost,
    editProfile,
  },
  data() {
    return {
      api: "http://localhost:8081/api/auth/",
      moment: moment,
      user: [],
      posts: [],
      count: "",
      show: false,
      found: false,
      image: null,
      imagePreview: null,
    };
  },
  props: ["pathName"],
  mounted() {
    this.getProfile();
  },
  computed: {
    ...mapGetters({ authUser: "getUser" }),
  },
  methods: {
    getProfile() {
      this.axios
        .get(this.api + "profile/" + this.pathName)
        .then((response) => {
          this.user = response.data.user;
          this.posts = response.data.posts;
          this.count = response.data.count;
          if (this.user.id == this.authUser.id) {
            this.show = true;
          }
          if (this.posts.length == 0) {
            this.found = true;
          }
        })
        .catch(() => {});
    },
    imageSelected(e) {
      if (
        e.target.files[0]["type"] === "image/jpeg" ||
        e.target.files[0]["type"] === "image/png"
      ) {
        this.image = e.target.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(this.image);
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
      } else {
        this.$swal({
          type: "error",
          title: "Ошибка",
          text: "Изображение должно быть формата .jpg, .jpeg, или .png",
        });
        this.getProfile();
      }
    },
    uploadImage() {
      let data = new FormData();
      data.append("avatar", this.image);
      this.axios.post(this.api + "upload-avatar", data).then(() => {
        this.getProfile();
        this.closeModal();
      });
    },
    closeModal() {
      this.image = null;
      this.imagePreview = null;
      this.$refs.reset.value = "";
    },
    editProfile(user) {
      this.$refs.editProfile.show = true;
      this.$refs.editProfile.profile = user;
    },
    updateProfile(data) {
      let Data = {
        first_name: data.profile.first_name,
        last_name: data.profile.last_name,
        email: data.profile.email,
        username: data.profile.username,
      };
      this.axios.post(this.api + "update-profile", Data).then(() => {
        this.$router.push({ path: "/profile/" + data.profile.username });
      });
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
          this.getProfile();
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
            this.getProfile();
          });
      }
    },
    deletePost(id) {
      if (id) {
        this.axios.delete(this.api + "delete-post/" + id).then(() => {
          this.getProfile();
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
