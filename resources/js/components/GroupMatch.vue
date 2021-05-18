<template>
  <!-- group match table with standings -->
  <article class="col mb-3">
    <div class="card card--group">
      <div class="card-header">Groupe {{ group.name }}</div>
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
            v-for="(standing, index) of getStandingsByGroup(group.id)"
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
          <tbody :class="[isShow ? 'tbody--open' : 'tbody--close']">
            <match-display
              v-for="match in getMatchesByGroup(group.id)"
              :match="match"
              :key="match.id"
              :gametype="'groups'"
            />
          </tbody>
        </table>
        <button
          v-if="withstanding"
          @click="isShow = !isShow"
          type="button"
          :class="[isShow ? 'close--close' : 'close--plus']"
          class="close"
        >
          <span>&times;</span>
        </button>
      </div>
    </div>
  </article>
</template>

<script>
// https://github.com/lsv/fifa-worldcup-2018-jsfrontend/blob/bf8616b1a3b58d06869bce0f386918ba9ce43ec6/src/Components/Group.vue
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
  computed: {
    ...mapGetters("matches", ["getMatchesByGroup", "getStandingsByGroup"]),
  },
};
</script>

<style>
</style>
