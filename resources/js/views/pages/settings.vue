<template>
  <section class="overview">
    <div class="container">
      <div
        class="d-flex flex-column justify-content-start align-items-start title-button-wrapper"
      >
        <div class="overview-header">
          <h2 class="title mb-0">Settings</h2>
        </div>
      </div>

      <div class="sub-section overview-tab">
        <div class="row justify-content-between align-items-center">
          <div class="row mb-2 mb-lg-5 pe-0">
            <div class="col-md-12 d-flex justify-content-start pe-0 flex-wrap">
              <ul
                style="overflow-x: unset"
                class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap"
                id="pills-tab"
                role="tablist"
              >
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="pills-overview-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-overview"
                    type="button"
                    role="tab"
                    aria-controls="pills-overview"
                    aria-selected="true"
                  >
                    Profile
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="pills-analytics-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-analytics"
                    type="button"
                    role="tab"
                    aria-controls="pills-analytics"
                    aria-selected="false"
                  >
                    Security
                  </button>
                </li>
              </ul>
            </div>
          </div>

          <div class="tab-content settings-tab-content" id="pills-tabContent">
            <!--overview-->
            <div
              class="tab-pane fade show active"
              id="pills-overview"
              role="tabpanel"
              aria-labelledby="pills-overview-tab"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">Profile</h3>
                </div>
                <div class="divider"></div>
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <div class="col-12 col-lg-6 tab-inner py-0 p-mb-0">
                    <h3 class="fs-15 mb-1">Change Avatar</h3>

                    <div class="settings-header mt-4">
                      <img src="assets/img/profile.png" alt="" />
                      <button class="btn-dark change-profile-btn fs-15">
                        <img src="assets/img/icon-upload.svg" alt="" />Change
                      </button>
                      <button class="btn-red delete-profile-btn fs-15">
                        <img src="assets/img/icon-delete.svg" alt="" />Delete
                      </button>
                    </div>

                    <div class="divider" style="margin: 20px 0"></div>

                    <h3 class="fs-15 mb-4">Change Nickname</h3>
                    <p class="fs-13-5">Current nickname</p>

                    <div class="overview-input mb-4">
                      <div class="d-inline current-nickname">
                        <input type="text" disabled value="Udodov228" />
                      </div>
                    </div>

                    <p class="fs-13-5">New Nickname</p>

                    <div class="overview-input mb-4">
                      <input type="text" placeholder="Write new nickname" />
                    </div>

                    <div class="overview-button-wrapper pt-0">
                      <button class="btn-dark px-4 me-2 hover-dark-light">
                        Change nickname
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!--analytics-->
            <div
              class="tab-pane fade"
              id="pills-analytics"
              role="tabpanel"
              aria-labelledby="pills-analytics-tab"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">Security</h3>
                </div>
                <div class="divider"></div>
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <div
                    class="col-12 col-lg-6 tab-inner py-0 p-mb-0 settings-tab-border"
                  >
                    <h3 class="fs-15 mb-4">Change Password</h3>

                    <p class="fs-13-5">Current password</p>

                    <div class="overview-input mb-4">
                      <div class="d-inline current-password">
                        <input
                          type="password"
                          class="settings-password"
                          value="12345678"
                        />

                        <img
                          src="assets/img/eye.svg"
                          class="settings-password-img icon-password eye-closed"
                        />
                        <img
                          src="assets/img/eye-open.svg"
                          class="settings-password-img icon-password eye-open"
                          style="display: none"
                        />
                      </div>
                    </div>

                    <p class="fs-13-5">New password</p>

                    <div class="overview-input mb-4">
                      <div class="d-inline current-password">
                        <input
                          type="password"
                          class="settings-password"
                          placeholder="Write new password"
                        />

                        <img
                          src="assets/img/eye.svg"
                          class="settings-password-img icon-password eye-closed"
                        />
                        <img
                          src="assets/img/eye-open.svg"
                          class="settings-password-img icon-password eye-open"
                          style="display: none"
                        />
                      </div>
                    </div>

                    <p class="fs-13-5">Confirm new password</p>

                    <div class="overview-input mb-4">
                      <div class="d-inline current-password">
                        <input
                          type="password"
                          class="settings-password"
                          placeholder="Write new password"
                        />

                        <img
                          src="assets/img/eye.svg"
                          class="settings-password-img icon-password eye-closed"
                        />
                        <img
                          src="assets/img/eye-open.svg"
                          class="settings-password-img icon-password eye-open"
                          style="display: none"
                        />
                      </div>
                    </div>

                    <div class="overview-button-wrapper pt-0">
                      <button class="btn-dark px-4 me-2 hover-dark-light">
                        Change Password
                      </button>
                    </div>
                  </div>

                  <div
                    class="col-12 col-lg-6 tab-inner py-0 p-mb-0 mt-5 mt-lg-0"
                  >
                    <h3 class="fs-15 mb-4">Change Email</h3>

                    <p class="fs-13-5">Current email</p>

                    <div class="overview-input mb-4">
                      <div class="d-inline current-nickname">
                        <input
                          type="email"
                          disabled
                          value="designlzt@gmail.com"
                        />
                      </div>
                    </div>

                    <p class="fs-13-5">New email</p>

                    <div class="overview-input mb-4">
                      <input type="text" placeholder="Write new mail" />
                    </div>

                    <p class="fs-13-5">Code from email</p>

                    <div class="overview-input mb-4">
                      <input type="text" value="123456" />
                    </div>

                    <div class="overview-button-wrapper pt-0">
                      <button class="btn-dark px-4 me-2 hover-dark-light">
                        Continue
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

<style scoped>
</style>
