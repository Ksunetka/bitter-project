<template>
  <div class="card mb-3 mt-3">
    <div class="card-header">Стена</div>
    <div class="card-body">
      <div class="mb-3">
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
      <div class="mb-3">
        <button type="button" class="btn btn-info text-white" @click="savePost">
          Добавить
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BitterForm",
  props: ["onSave", "onUpdate"],
  data() {
    return {
      post_message: "",
      edit_post_id: "",
    };
  },
  methods: {
    savePost() {
      this.onSave({
        post_message: this.post_message,
      });
      this.post_message = "";
    },
  },
};
</script>
