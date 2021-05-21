
<template>
  <form
    v-on:submit.prevent="mode == 'new' ? add() : update()"
    class="container"
  >
    <div class="form-stadium row">
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
      <label for="city" class="col-sm-3"
        >City<span class="text-danger">*</span></label
      >
      <input
        id="city"
        type="text"
        class="form-control col-sm-7"
        v-model="item.city"
        required
      />
      <label for="lat" class="col-sm-3"
        >Latitude<span class="text-danger">*</span></label
      >
      <input
        id="lat"
        type="decimal"
        class="form-control col-sm-7"
        v-model="item.lat"
        required
      />
      <label for="lng" class="col-sm-3"
        >Longitude<span class="text-danger">*</span></label
      >
      <input
        id="lng"
        type="decimal"
        class="form-control col-sm-7"
        v-model="item.lng"
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
        .post("/stadiums", this.item)
        .then(({ data }) => {
          this.$emit("created", data.stadium);
          flash("Added success!", "success");
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
    update() {
      axios
        .patch("/stadiums/" + this.item.id, this.item)
        .then(({ data }) => {
          this.$emit("updated", data.stadium);
          flash("Edited success!", "success");
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
  },
};
</script>
