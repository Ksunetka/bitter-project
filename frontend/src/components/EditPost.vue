<template>
  <div v-show="modalShow" id="postModal" class="modal fade">
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
          ></button>
        </div>
        <div class="modal-body">
          <input
            type="hidden"
            disabled
            class="form-control"
            v-model="edit_post_id"
            id="post_id"
          />
          <label for="message" class="form-label">Сообщение:</label>
          <textarea
            class="form-control"
            v-model="post_message"
            rows="5"
            placeholder="Введите текст сообщения"
            type="text"
            name="message"
            id="message"
          >
          </textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="updatePost">
            Сохранить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EditPost",
  props: ["onUpdatePost"],
  data() {
    return {
      post_message: "",
      edit_post_id: "",
      modalShow: false,
    };
  },
  methods: {
    updatePost() {
      this.onUpdatePost({
        post_message: this.post_message,
        edit_post_id: this.edit_post_id,
      });
      this.$refs.close.click();
      this.reset();
    },
    reset() {
      this.post_message = "";
      this.edit_post_id = "";
    },
  },
};
</script>
