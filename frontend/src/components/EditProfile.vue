<template>
  <div v-show="show" id="profileModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Редактировать запись:
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            ref="close"
            @click="closeModal"
          ></button>
        </div>
        <div class="modal-body">
          <input
            type="hidden"
            disabled
            class="form-control"
            id="user_id"
            v-model="profile.id"
          />
          <div class="mb-3">
            <label for="first_name" class="form-label">Имя</label>
            <input
              type="text"
              class="form-control"
              id="first_name"
              v-model="profile.first_name"
            />
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Фамилия</label>
            <input
              type="text"
              class="form-control"
              id="last_name"
              v-model="profile.last_name"
            />
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Имя пользователя</label>
            <input
              type="text"
              class="form-control"
              id="username"
              v-model="profile.username"
            />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              aria-describedby="emailHelp"
              v-model="profile.email"
            />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="updateProfile">
            Сохранить
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            @click="closeModal"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EditProfile",
  props: ["onUpdateProfile"],
  data() {
    return {
      show: false,
      profile: Object,
    };
  },
  methods: {
    updateProfile() {
      this.onUpdateProfile({
        profile: this.profile,
      });
      this.closeModal();
    },
    closeModal() {
      this.$refs.close.click();
    },
  },
};
</script>
