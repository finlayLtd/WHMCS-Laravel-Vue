<template>
  <section class="dashboard">
    <div class="container">
      <div class="title-button-wrapper ticket-detail">
        <router-link to="/support-ticket">
          <img class="status-arrow" src="assets/img/status-arrow.svg" alt=""
          />
        </router-link>
        <h3 class="ticket-status-title color-in-work">In Work</h3>
        <h2 class="title mb-0 mt-2">Ticket #1667135379414894</h2>
      </div>
      <div class="sub-section server-list-tab">
        <div class="row justify-content-between align-items-center">
          <div class="row mb-5 pe-0">
            <div class="col-12">
              <div class="card-item p-4 mb-4 support-item flex-column">
                <div class="message-item-wrapper">
                  <div class="message-item message-sent">
                    <div class="message-item-header">
                      <div class="message-sender-image">
                        <img src="assets/img/message-profile.png" alt="" />
                      </div>
                      <div class="message-sender">
                        <span class="fs-15">Udodov</span
                        ><span class="message-sent-time fs-13">11:29</span>
                      </div>
                    </div>

                    <div class="message-content-wrapper">
                      <div class="message-body">
                        <div>
                          Lorem ipsum dolor sit amet, consectetur adipiscing
                          elit, sed do eiusmod tempor incididunt ut labore et
                          dolore magna aliqua?
                        </div>
                      </div>
                      <div class="message-attachment">
                        <img src="assets/img/message-img.png" alt="" />
                      </div>
                    </div>
                  </div>

                  <div class="message-item message-received">
                    <div class="message-item-header">
                      <div class="message-sender-image">
                        <img src="assets/img/profile-support.png" alt="" />
                      </div>
                      <div class="message-sender">
                        <span class="fs-15">Udodov</span
                        ><span class="message-sent-time fs-13">11:30</span>
                      </div>
                    </div>

                    <div class="message-content-wrapper">
                      <div class="message-body">
                        <div>
                          <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua.
                          </p>
                          <p>
                            Ut enim ad minim veniam, quis nostrud exercitation
                            ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu fugiat nulla
                            pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="message-item message-sent">
                    <div class="message-item-header">
                      <div class="message-sender-image">
                        <img src="assets/img/message-profile.png" alt="" />
                      </div>
                      <div class="message-sender">
                        <span class="fs-15">Udodov</span
                        ><span class="message-sent-time fs-13">11:31</span>
                      </div>
                    </div>

                    <div class="message-content-wrapper">
                      <div class="message-body">
                        <div>Thank you!</div>
                      </div>
                      <div class="message-attachment">
                        <img src="assets/img/message-img.png" alt="" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="message-send-area-wrapper mt-4">
                  <div class="upload-attachment">
                    <label class="file-label" for="file-upload"></label>
                    <input type="file" style="display: none" id="file-upload" />
                  </div>

                  <div class="message-box">
                    <textarea
                      class="p-3"
                      name=""
                      id=""
                      cols="30"
                      rows="5"
                      placeholder="Type a message.."
                    ></textarea>
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
