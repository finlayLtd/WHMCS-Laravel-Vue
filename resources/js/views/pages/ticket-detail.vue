<template>
  <section class="dashboard">

    <div class="container">
      <a ref="customLink" style="display: none;" target="_blank">Custom Link</a>
      <div class="title-button-wrapper ticket-detail">
        <router-link to="/support-ticket">
          <img class="status-arrow" src="/assets/img/status-arrow.svg" alt="" />
        </router-link>
        <h3 class="ticket-status-title color-in-work" v-if="ticket_detail && ticket_detail.status">
          {{ $t(ticket_detail.status) }}
        </h3>
        <h2 class="title mb-0 mt-2">{{ $t('Ticket') }} #{{ route.params.id }}</h2>
      </div>


      <template v-if="user && user.permissions.split(',').includes('tickets')">
        <div class="sub-section server-list-tab">
          <div class="row justify-content-between align-items-center">
            <div class="row mb-5 pe-0">
              <div class="col-12">
                <div class="card-item p-4 mb-4 support-item flex-column">
                  <div class="message-item-wrapper" v-if="ticket_detail.replies">
                    <div v-for="reply in ticket_detail.replies.reply" :key="reply.replyid" style="margin-bottom: 20px;">
                      <div class="message-item message-received" v-if="reply.requestor_type == 'Owner'">
                        <div class="message-item-header">
                          <div class="message-sender">
                            <span class="fs-15">{{ reply.requestor_name }}</span><span class="message-sent-time fs-13">{{
                              reply.date
                            }}</span>
                          </div>
                        </div>

                        <div class="message-content-wrapper">
                          <div class="message-body" v-if="reply.message && reply.message != ' '">
                            <div style="text-align: left;" v-html="formattedText(reply.message)">
                            </div>
                          </div>
                          <div class="message-body message-attachment-body" style="width: fit-content"
                            v-if="reply.attachment">
                            <a class="blackColor" @click="download_file(reply.replyid)"
                              :data-lightbox="'image-r' + reply.replyid" style="cursor: pointer">
                              <img src="/assets/img/download_icon.png" style="width: 24px" alt="" />
                              <span class="text-decoration-underline">{{
                                reply.attachment
                              }}</span>
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="message-item message-sent" v-else>
                        <div class="message-item-header">
                          <div class="message-sender">
                            <span class="fs-15">{{ reply.name }}</span><span class="message-sent-time fs-13">{{
                              reply.date
                            }}</span>
                          </div>
                        </div>

                        <div class="message-content-wrapper">
                          <div class="message-body" v-if="reply.message && reply.message != ' '">
                            <div style="text-align: left;" v-html="formattedText(reply.message)">
                            </div>
                          </div>

                          <div class="message-body message-attachment-body" style="width: fit-content; margin-left: auto"
                            v-if="reply.attachment">
                            <div>
                              <a class="blackColor" @click="download_file(reply.replyid)"
                                :data-lightbox="'image-r' + reply.replyid" style="cursor: pointer">
                                <img src="/assets/img/download_icon.png" style="width: 24px" alt="" />
                                <span class="text-decoration-underline">{{
                                  reply.attachment
                                }}</span>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="message-send-area-wrapper mt-4">
                    <div class="upload-attachment">
                      <label class="file-label" for="file"></label>
                      <input name="file" type="file" style="display: none" id="file" @change="handleFileInput"
                        ref="fileInput" />
                      <input name="ticket_id" type="hidden" id="ticket_id" :value="ticket_detail.id" />
                    </div>
                    <div class="message-box">
                      <textarea id="message" name="message" class="p-3" cols="30" rows="5" placeholder="Type messages.."
                        v-model="message"></textarea>
                      <div v-if="file">
                        {{ $t('File_Selected') }}: <span id="file-name" style="overflow-wrap: anywhere;"
                          v-if="file_name != ''">{{ file_name }}</span>
                        <span id="file-name" style="overflow-wrap: anywhere"></span>
                      </div>
                    </div>
                  </div>
                  <div class="mt-1" style="text-align: right">
                    <button class="btn-dark change-profile-btn fs-15" style="margin-right: 0px" @click="sendReply()"
                      :disabled="message == '' && file == null">
                      {{ $t('Send') }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        <NoPermission />
      </template>

    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch } from "vue";
import { commonApis } from "@/apis/commonApis";
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { showLoader } from "@/plugins/loading.js";
import { useRoute } from "vue-router";

// toast
import NoPermission from '@/components/NoPermission.vue';
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast({
    toastOptions: {
        zIndex: 99999, // set a high z-index value
    },
});

const route = useRoute();
const customLink = ref(null);
const commonApi = commonApis();
const store = useStore();
const user = computed(() => store.state.auth.user);
const ticket_detail = ref({});
const message = ref('');
const file = ref(null);
const file_name = ref('');


const params = ref({
  client_id: user.value.client_id,
  orderby: "",
  order: "",
});

const formattedText = (text) => {
  return text.replace(/\n/g, "<br>");
}

const getTicketDetail = () => {
  showLoader(true);
  commonApi
    .runPostApi("/get-ticketDetails", {
      id: route.params.id,
    })
    .then((res) => {
      showLoader(false);
      if(res.data.result == 'wrong_user') $toast.error("No permission on this ticket!");
      else ticket_detail.value = res.data.ticket_detail;
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
};

const handleFileInput = (event) => {
  file.value = event.target.files[0];
  file_name.value = event.target.files[0].name;
}

const download_file = (id) => {
  showLoader(true);
  commonApi
    .runPostApi("/download-file", {
      id: id
    })
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        // openInNewTab(res.data.redirect_url);
        customLink.value.href = res.data.redirect_url;
        customLink.value.click();
      }
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

const openInNewTab = (url) => {
  const newWindow = window.open(url, '_blank', 'noopener,noreferrer')
  if (newWindow) newWindow.opener = null
}

const sendReply = () => {
  showLoader(true);
  const formData = new FormData();
  if (file.value != null) {
    formData.append("file", file.value);
  }
  formData.append("ticket_id", route.params.id);
  formData.append("message", message.value);
  const headers = { "Content-Type": "multipart/form-data" };

  axios.post("/api/sendReply", formData, {
    headers: headers,
  })
    .then((res) => {
      showLoader(false);
      ticket_detail.value = res.data.ticket_detail;
      message.value = '';
      file.value = null;
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });

};



getTicketDetail();
</script>

<style scoped></style>
