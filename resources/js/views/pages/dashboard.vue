<template>
    <section class="dashboard">
      <div class="container">
        <div
          class="d-flex justify-content-between align-items-center title-button-wrapper position-relative"
        >
          <h2 class="title mb-0">Dashboard</h2>
          <button
            type="submit"
            class="btn btn-dark btn-chevron chevron-dark hover-dark-light options-toggle dropdown-toggle"
            data-bs-toggle="dropdown"
          >
            Create Server
          </button>
  
          <div class="options-toggle-dropdown create-server dropdown-menu dropdown-menu-end">
            <ul>
                <li>
                    <router-link to="/create-vps-server">Create VPS Server</router-link>
                </li>
            </ul>
          </div>
        </div>
  
        <div class="sub-section server-list-tab">
          <div class="row justify-content-between align-items-center">
            <div class="col-md-12">
              <div class="w-100 mb-2 mb-lg-5">
                <h3 class="sub-title">Support Tickets</h3>
              </div>
              <div class="w-100 support-table mb-4">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Ticket No</th>
                      <th scope="col">Title</th>
                      <th scope="col">Request Type</th>
                      <th scope="col">Date</th>
                      <th scope="col">Status</th>
                      <th scope="col" class="text-center">View Invoice</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>#123</td>
                      <td>Name about yes request..</td>
                      <td class="refund-request">Refund Request</td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="successful-cell"><span>Successful</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>#123</td>
                      <td>Name about yes request..</td>
                      <td class="refund-request">Refund Request</td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="cancelled-cell"><span>Cancelled</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>#123</td>
                      <td>Name about yes request..</td>
                      <td class="refund-request">Refund Request</td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="in-progress-cell"><span>In progress</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>#123</td>
                      <td>Name about yes request..</td>
                      <td class="refund-request">Refund Request</td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="in-progress-cell"><span>In progress</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>#123</td>
                      <td>Name about yes request..</td>
                      <td class="refund-request">Refund Request</td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="in-progress-cell"><span>In progress</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="w-100 server-list-pagination">
                <nav aria-label="...">
                  <ul class="pagination">
                    <li class="page-item disabled first">
                      <a
                        class="page-link"
                        href="#"
                        tabindex="-1"
                        aria-disabled="true"
                        >Previous</a
                      >
                    </li>
                    <li class="page-item inner-page-item">
                      <a class="page-link" href="#">1</a>
                    </li>
                    <li
                      class="page-item inner-page-item active"
                      aria-current="page"
                    >
                      <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
  
                    <li class="page-item inner-page-item d-none d-lg-block">
                      <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item inner-page-item d-none d-lg-block">
                      <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item inner-page-item d-none d-lg-block">
                      <a class="page-link" href="#">...</a>
                    </li>
                    <li class="page-item d-none d-lg-block">
                      <a class="page-link" href="#">124</a>
                    </li>
  
                    <li class="page-item last">
                      <a class="page-link" href="#">Next</a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>

        <!-- have to replace here with services table componenet -->
        <ServicesTable />
  
      </div>
    </section>
  </template>
  
  <script setup>
  import ServicesTable from "./tables/services.vue";
  </script>
  
  <style scoped>
  
  </style>
  