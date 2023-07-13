<template>
  <div class="sub-section server-list-tab">
    <div
      class="d-flex justify-content-between align-items-center title-button-wrapper"
    ></div>
    <div class="row justify-content-between align-items-center">
      <div class="row mb-5 pe-0">
        <h3 class="col-md-3 sub-title">My Products & Services</h3>

        <div class="col-md-9 d-flex justify-content-end pe-0 flex-wrap">
          <div class="sort-servers order-2 order-md-1">
            <div
              id="toggleButton"
              class="sort-item-active btn-chevron chevron-dark"
              @click="sortBy = !sortBy"
            >
              <span>Sort by name</span>
            </div>
            <div class="sorting-items" v-if="sortBy">
              <ul>
                <li>Created date</li>
                <li>Expiration date</li>
              </ul>
            </div>
          </div>

          <ul
            class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0"
            id="pills-tab"
            role="tablist"
          >
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active"
                id="pills-home-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-home"
                type="button"
                role="tab"
                aria-controls="pills-home"
                aria-selected="true"
              >
                Active
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link"
                id="pills-profile-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-profile"
                type="button"
                role="tab"
                aria-controls="pills-profile"
                aria-selected="false"
              >
                Consumed
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link"
                id="pills-profile-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-profile"
                type="button"
                role="tab"
                aria-controls="pills-profile"
                aria-selected="false"
              >
                Suspended
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link"
                id="pills-profile-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-profile"
                type="button"
                role="tab"
                aria-controls="pills-profile"
                aria-selected="false"
              >
                Attracted
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div
          class="tab-pane fade show active"
          id="pills-home"
          role="tabpanel"
          aria-labelledby="pills-home-tab"
        >
          <div class="row mb-5">
            <div class="col-12 col-lg-4 col-md-6 col-sm-12">
              <div class="card-item p-4 mb-4">
                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/windows-logo.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">UdodovVPS</h2>
                      <h3 class="detail">Windows RDP 2019</h3>
                    </div>
                    <div class="server-list-options">
                      <div class="options-toggle"></div>
                      <div class="options-toggle-dropdown">
                        <ul>
                          <li><a href="#">Launch Control Panel</a></li>
                          <li><a href="#">View Invoices</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img
                        class="dark-img-filter"
                        src="assets/img/cloud-connection.png"
                        alt=""
                      />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">192.178.12.14</h2>
                      <h3 class="detail">Created at 2023-13-03</h3>
                    </div>

                    <div class="server-list-options">
                      <button class="active-badge">
                        <span class="active-dot"></span>Active
                      </button>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/flag-nl.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">Netherlands</h2>
                      <h3 class="detail">1x Intel E5-2697v3 (14C, 28T)</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-md-6 col-sm-12">
              <div class="card-item p-4 mb-4">
                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/windows-logo.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">UdodovVPS</h2>
                      <h3 class="detail">Windows RDP 2019</h3>
                    </div>
                    <div class="server-list-options">
                      <div class="options-toggle"></div>
                      <div class="options-toggle-dropdown">
                        <ul>
                          <li><a href="#">Launch Control Panel</a></li>
                          <li><a href="#">View Invoices</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img
                        class="dark-img-filter"
                        src="assets/img/cloud-connection.png"
                        alt=""
                      />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">192.178.12.14</h2>
                      <h3 class="detail">Created at 2023-13-03</h3>
                    </div>

                    <div class="server-list-options">
                      <button class="active-badge">
                        <span class="active-dot"></span>Active
                      </button>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/flag-nl.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">Netherlands</h2>
                      <h3 class="detail">1x Intel E5-2697v3 (14C, 28T)</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-md-6 col-sm-12">
              <div class="card-item p-4 mb-4">
                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/windows-logo.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">UdodovVPS</h2>
                      <h3 class="detail">Windows RDP 2019</h3>
                    </div>
                    <div class="server-list-options">
                      <div class="options-toggle"></div>
                      <div class="options-toggle-dropdown">
                        <ul>
                          <li><a href="#">Launch Control Panel</a></li>
                          <li><a href="#">View Invoices</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img
                        class="dark-img-filter"
                        src="assets/img/cloud-connection.png"
                        alt=""
                      />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">192.178.12.14</h2>
                      <h3 class="detail">Created at 2023-13-03</h3>
                    </div>

                    <div class="server-list-options">
                      <button class="active-badge">
                        <span class="active-dot"></span>Active
                      </button>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/flag-nl.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">Netherlands</h2>
                      <h3 class="detail">1x Intel E5-2697v3 (14C, 28T)</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          class="tab-pane fade"
          id="pills-profile"
          role="tabpanel"
          aria-labelledby="pills-profile-tab"
        >
          <div class="row mb-5">
            <div class="col-12 col-lg-4 col-md-6 col-sm-12">
              <div class="card-item p-4 mb-4">
                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/windows-logo.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">UdodovVPS</h2>
                      <h3 class="detail">Windows RDP 2019</h3>
                    </div>
                    <div class="server-list-options">
                      <div class="options-toggle"></div>
                      <div class="options-toggle-dropdown">
                        <ul>
                          <li><a href="#">Launch Control Panel</a></li>
                          <li><a href="#">View Invoices</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img
                        class="dark-img-filter"
                        src="assets/img/cloud-connection.png"
                        alt=""
                      />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">192.178.12.14</h2>
                      <h3 class="detail">Created at 2023-13-03</h3>
                    </div>

                    <div class="server-list-options">
                      <button class="active-badge">
                        <span class="active-dot"></span>Active
                      </button>
                    </div>
                  </div>
                </div>

                <div class="server-list-item">
                  <div class="server-list-item-wrapper">
                    <div class="image-wrapper">
                      <img src="assets/img/flag-nl.png" alt="" />
                    </div>
                    <div class="list-item-detail">
                      <h2 class="list-name">Netherlands</h2>
                      <h3 class="detail">1x Intel E5-2697v3 (14C, 28T)</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount } from "vue";
const sortBy = ref(false);
</script>

<style scoped>
</style>
