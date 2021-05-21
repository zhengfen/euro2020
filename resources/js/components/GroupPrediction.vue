<template>
  <article class="col mb-3">
    <div class="card card--group">
      <div class="card-header">Group {{ group.name }}</div>
      <table class="table-bordered" v-if="withstanding">
        <thead>
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col" class="text-center">
              <abbr title="Played">Pld</abbr>
            </th>
            <th scope="col" class="text-center">
              <abbr title="Wins - Draws - Lost">W-D-L</abbr>
            </th>
            <th scope="col" class="text-center">
              <abbr title="Goals">G</abbr>
            </th>
            <th scope="col" class="text-center">
              <abbr title="Goal difference">GD</abbr>
            </th>
            <th scope="col" class="text-center">
              <abbr title="Points">Pts</abbr>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(standing, index) in getpredictionStandingsByGroup(group.id)"
            :key="index"
            :class="{
              'table-success': index === 0,
              'table-info': index === 1,
            }"
          >
            <td>
              <span class="team--name">
                <teamname :team="standing.team" />
              </span>
            </td>
            <td class="text-center">{{ standing.played }}</td>
            <td class="text-center text-nowrap">
              {{ standing.wins }} - {{ standing.draws }} -
              {{ standing.losses }}
            </td>
            <td class="text-center text-nowrap">
              {{ standing.goalsFor }} - {{ standing.goalsAgainst }}
            </td>
            <td class="text-center">
              {{ standing.goalsFor - standing.goalsAgainst }}
            </td>
            <td class="text-center">
              {{ standing.wins * 3 + standing.draws }}
            </td>
          </tr>
        </tbody>
      </table>
      <div class="card-footer p-0">
        <table class="table-groups">
          <tbody :class="[show() ? 'tbody--open' : 'tbody--close']">
            <prediction
              v-for="(game, index) in getGamesByGroup(group.id)"
              :id="group.name"
              :game="game"
              :key="index"
            ></prediction>
          </tbody>
        </table>
        <button
          v-if="withstanding"
          @click="isShow = !isShow"
          type="button"
          :class="[show ? 'close--close' : 'close--plus']"
          class="close"
        >
          <span>&times;</span>
        </button>
      </div>
    </div>
  </article>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    withstanding: {
      type: Boolean,
      required: false,
      default: true,
    },
    group: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isShow: false,
    };
  },
  methods: {
    prediction(id) {
      return this.predictions.find(function (obj) {
        return obj.game_id === id;
      });
    },
    show() {
      if (!this.withstanding) {
        return true;
      }
      return this.isShow;
    },
  },
  computed: {
    ...mapGetters("games", [
      "getGamesByGroup",
      "getpredictionStandingsByGroup",
    ]),
  },
};
</script>
