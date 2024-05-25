<script setup>
  //
</script>

<template>
  <div class="hk-pg-header pg-header-wth-tab pt-7">
    <div class="d-flex">
      <div class="d-flex flex-wrap justify-content-between flex-1">
        <div class="mb-lg-0 mb-2 me-8">
          <h1 class="pg-title">Welcome back, {{ $page.props.auth.user.first_name }}</h1>
          <p>Create pages using a variety of features that leverage jampack components</p>
        </div>
        <div class="pg-header-action-wrap">
          <div class="input-group w-300p">
            <span class="input-affix-wrapper">
              <span class="input-prefix"><span class="feather-icon"><i data-feather="calendar"></i></span></span>
              <input class="form-control form-wth-icon daterangepicker" name="datetimes" value="Aug 18,2020 - Aug 19, 2020">
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
