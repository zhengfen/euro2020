
<template>
  <form
    v-on:submit.prevent="mode == 'new' ? add() : update()"
    class="container"
  >
    <div class="form-match row">
      <label for="group_id" class="col-sm-3">Group</label>
      <select v-model="item.group_id" class="form-control col-sm-7">
        <option v-for="group in groups" :key="group.id" :value="group.id">
          {{ group.name }}
        </option>
      </select>

      <label for="team_h" class="col-sm-3"
        >Team Home<span class="text-danger">*</span></label
      >
      <select v-model="item.team_h" class="form-control col-sm-7">
        <option v-for="team in teams" :key="team.id" :value="team.id">
          {{ team.name }}
        </option>
      </select>

      <label for="team_a" class="col-sm-3"
        >Team Away<span class="text-danger">*</span></label
      >
      <select v-model="item.team_a" class="form-control col-sm-7">
        <option v-for="team in teams" :key="team.id" :value="team.id">
          {{ team.name }}
        </option>
      </select>

      <label for="date" class="col-sm-3"
        >Date<span class="text-danger">*</span></label
      >
      <input
        id="date"
        type="datetime-local"
        class="form-control col-sm-7"
        v-model="item.date"
        required
        @change="log()"
      />

      <label for="stadium_id" class="col-sm-3"
        >Stadium<span class="text-danger">*</span></label
      >
      <select v-model="item.stadium_id" class="form-control col-sm-7" required>
        <option
          v-for="stadium in stadiums"
          :key="stadium.id"
          :value="stadium.id"
        >
          {{ stadium.name }}
        </option>
      </select>
      <label for="score_h" class="col-sm-3"
        >Score Home<span class=""></span
      ></label>
      <input
        id="score_h"
        type="text"
        class="form-control col-sm-7"
        v-model="item.score_h"
      />
      <label for="score_a" class="col-sm-3"
        >Score Away<span class=""></span
      ></label>
      <input
        id="score_a"
        type="text"
        class="form-control col-sm-7"
        v-model="item.score_a"
      />
      <label for="type" class="col-sm-3"
        >Match Phase [0->5]<span class=""></span
      ></label>
      <input
        id="type"
        type="text"
        class="form-control col-sm-7"
        v-model="item.type"
      />
      <label for="qual_h" class="col-sm-3"
        >Qualification Home<span class=""></span
      ></label>
      <input
        id="qual_h"
        type="text"
        class="form-control col-sm-7"
        v-model="item.qual_h"
      />
      <label for="qual_a" class="col-sm-3"
        >Qualification Away<span class=""></span
      ></label>
      <input
        id="qual_a"
        type="text"
        class="form-control col-sm-7"
        v-model="item.qual_a"
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
    teams: {
      type: Array,
      default: [],
    },
    stadiums: {
      type: Array,
      default: [],
    },
    groups: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      item: {},
      date: null,
    };
  },
  created() {
    if (this.mode == "edit") {
      this.item = this.item_edit;
      console.log(this.item);
    }
  },
  methods: {
    add() {
      axios
        .post("/matches", this.item)
        .then(({ data }) => {
          console.log("post return data", data);
          this.$emit("created", data.match);
          flash("Added success!", "success");
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
    update() {
      axios
        .patch("/matches/" + this.item.id, this.item)
        .then(({ data }) => {
          console.log("patch return data", data);
          this.$emit("updated", data.match);
          flash("Edited success!", "success");
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
    log() {
      console.log(this.item.date);
    },
  },
};
</script>
