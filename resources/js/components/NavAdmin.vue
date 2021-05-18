<template>
  <nav id="sidebar">
    <div class="sidebar-header">
      <a href="/">
        <h3>Euro2020</h3>
      </a>
    </div>

    <ul class="list-unstyled components">
      <li>
        <a href="/groups" :class="{ active: ['/groups'].includes(pathname) }">
          Groups
        </a>
      </li>
      <li>
        <a href="/teams" :class="{ active: ['/teams'].includes(pathname) }">
          Teams
        </a>
      </li>
      <li>
        <a href="/matches" :class="{ active: ['/matches'].includes(pathname) }">
          Matches
        </a>
      </li>
      <li>
        <a
          href="/stadiums"
          :class="{ active: ['/stadiums'].includes(pathname) }"
        >
          Stadiums
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      pathname: window.location.pathname,
    };
  },
};
</script>

<style>
</style>
