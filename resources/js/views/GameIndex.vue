<template>
  <div>
    <div class="d-flex mb-2">
      <div>
        <strong>Games</strong>
      </div>
      <div class="flex-right-parent ml-auto">
        <input
          type="text"
          v-model="search_input"
          placeholder="recherche"
          v-on:keyup.enter="fetch()"
          class="search-input"
        />
        <button
          class="btn btn-sm btn-primary"
          @click="$modal.show('add_modal')"
        >
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>
    <table class="table table-sm">
      <tr>
        <td>ID</td>
        <td>Team Home</td>
        <td>Team Away</td>
        <td>Time</td>
        <td>Stadium</td>
        <td>Score Home</td>
        <td>Score Away</td>
        <td>Phase</td>
        <td>Qualification Home</td>
        <td>Qualification Away</td>
        <td>Group</td>
        <td>Action</td>
      </tr>
      <tr v-for="item of items" :key="item.id">
        <td>{{ item.id }}</td>
        <td>{{ getTeamName(item.team_h) }}</td>
        <td>{{ getTeamName(item.team_a) }}</td>
        <td>{{ item.date }}</td>
        <td>{{ getStadiumName(item.stadium_id) }}</td>
        <td>{{ item.score_h }}</td>
        <td>{{ item.score_a }}</td>
        <td>{{ item.type }}</td>
        <td>{{ item.qual_h }}</td>
        <td>{{ item.qual_a }}</td>
        <td>{{ getGroupName(item.group_id) }}</td>
        <td>
          <i class="fas fa-edit text-info" @click="show_edit_modal(item)"></i>
          <i
            class="fas fa-trash-alt text-danger"
            @click="show_delete_modal(item, index)"
          ></i>
        </td>
      </tr>
    </table>
    <modal name="add_modal" width="900" height="auto" :scrollable="true">
      <div class="card">
        <div class="card-header">
          <h3>Add game</h3>
          <button
            class="btn btn-secondary btn-sm ml-auto"
            @click="$modal.hide('add_modal')"
          >
            &times;
          </button>
        </div>
        <div class="card-body">
          <game-form
            mode="new"
            @created="add"
            :teams="teams"
            :stadiums="stadiums"
            :groups="groups"
          />
        </div>
      </div>
    </modal>

    <modal
      name="edit_modal"
      width="900"
      height="auto"
      :scrollable="true"
      @before-open="
        (event) => {
          in_edit_modal = event.params.item;
        }
      "
    >
      <div class="card">
        <div class="card-header">
          <h3>Edit game</h3>
          <button
            class="btn btn-secondary btn-sm ml-auto"
            @click="$modal.hide('edit_modal')"
          >
            &times;
          </button>
        </div>
        <div class="card-body">
          <game-form
            mode="edit"
            :item_edit="in_edit_modal"
            @updated="update"
            :teams="teams"
            :stadiums="stadiums"
            :groups="groups"
          />
        </div>
      </div>
    </modal>

    <modal name="delete_modal" width="900" height="auto" :scrollable="true">
      <div class="p4">
        <p>Sure to delete?</p>
        <div class="text-right">
          <button class="btn btn-info text-white" @click="delete_item">
            Confirm
          </button>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import collection from "../mixins/collection";
export default {
  mixins: [collection],
  props: {
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
      path: "/games",
    };
  },
  created() {
  },
  methods: {
    fetch() {
      axios.get("/api/games").then(({ data }) => {
        this.items = data.games;
      });
    },
    getTeamName(id) {
      const item = this.teams.find((elem) => elem.id == id);
      if (item) return item.name;
    },
    getStadiumName(id) {
      const item = this.stadiums.find((elem) => elem.id == id);
      if (item) return item.name;
    },
    getGroupName(id) {
      const item = this.groups.find((elem) => elem.id == id);
      if (item) return item.name;
    },
  },
};
</script>

<style>
</style>
