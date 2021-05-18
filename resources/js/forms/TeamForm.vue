
<template>
  <form
    v-on:submit.prevent="mode == 'new' ? add() : update()"
    class="container"
  >
    <div class="form-team row">
      <label for="title" class="col-sm-3"
        >Name<span class="text-danger">*</span></label
      >
      <input
        id="title"
        type="text"
        class="form-control col-sm-7"
        v-model="item.name"
        required
      />
      <label for="abr" class="col-sm-3"
        >Abreviation<span class="text-danger">*</span></label
      >
      <input
        id="abr"
        type="text"
        class="form-control col-sm-7"
        v-model="item.abr"
        required
      />
      <label for="group_id" class="col-sm-3"
        >Group<span class="text-danger">*</span></label
      >
      <input
        id="group_id"
        type="number"
        class="form-control col-sm-7"
        v-model="item.group_id"
        required
      />
      <label for="iso" class="col-sm-3"
        >ISO<span class="text-danger">*</span></label
      >
      <input
        id="iso"
        type="text"
        class="form-control col-sm-7"
        v-model="item.iso"
        required
      />
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn-primary">Valider</button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    mode: {
      type: String,
      default: "new",
    },
    item_edit: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      item: {},
    };
  },
  created() {
    if (this.mode == "edit") {
      this.item = this.item_edit;
    }
  },
  methods: {
    add() {
      axios
        .post("/teams", this.item)
        .then(({ data }) => {
          console.log("post return data", data);
          this.$emit("created", data.team);
          flash("Added success!", "success");
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
    update() {
      axios
        .patch("/teams/" + this.item.id, this.item)
        .then(({ data }) => {
          console.log("patch return data", data);
          this.$emit("updated", data.team);
          flash("Edited success!", "success");
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
  },
};
</script>
