<template>
  <div>
    <div class="d-flex mb-2">
      <div>
        <strong>Groups</strong>
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
        <td>Action</td>
      </tr>
      <tr v-for="(item, index) of items" :key="item.id">
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
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
          <h3>Add group</h3>
          <button
            class="btn btn-secondary btn-sm ml-auto"
            @click="$modal.hide('add_modal')"
          >
            &times;
          </button>
        </div>
        <div class="card-body">
          <group-form mode="new" @created="add" />
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
          <h3>Edit group</h3>
          <button
            class="btn btn-secondary btn-sm ml-auto"
            @click="$modal.hide('edit_modal')"
          >
            &times;
          </button>
        </div>
        <div class="card-body">
          <group-form
            mode="edit"
            :item_edit="in_edit_modal"
            @updated="update"
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
  data() {
    return {
      path: "/groups",
    };
  },
  created() {},
  methods: {
    fetch() {
      axios.get("/api/groups").then(({ data }) => {
        this.items = data.groups;
      });
    },
  },
};
</script>

<style>
</style>
