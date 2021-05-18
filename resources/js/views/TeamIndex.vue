<template>
  <div>
    <div class="d-flex mb-2">
      <div>
        <strong>Teams</strong>
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
        <td>Name</td>
        <td>Abreviation</td>
        <td>Group</td>
        <td>ISO</td>
        <td>Action</td>
      </tr>
      <tr v-for="(item, index) of items" :key="item.id">
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td>{{ item.abr }}</td>
        <td>{{ item.group_id }}</td>
        <td>{{ item.iso }}</td>
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
          <h3>Add Team</h3>
          <button
            class="btn btn-secondary btn-sm ml-auto"
            @click="$modal.hide('add_modal')"
          >
            &times;
          </button>
        </div>
        <div class="card-body">
          <team-form mode="new" @created="add" />
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
          <h3>Edit Team</h3>
          <button
            class="btn btn-secondary btn-sm ml-auto"
            @click="$modal.hide('edit_modal')"
          >
            &times;
          </button>
        </div>
        <div class="card-body">
          <team-form mode="edit" :item_edit="in_edit_modal" @updated="update" />
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
  data() {
    return {
      path: "/teams",
    };
  },
  created() {},
  methods: {
    fetch() {
      console.log("fetching teams");
      axios.get("/api/teams").then(({ data }) => {
        console.log(data);
        this.items = data.teams;
      });
    },
  },
};
</script>

<style>
</style>
