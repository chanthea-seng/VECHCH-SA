<template>
  <main>
    <loadingView v-if="pageLoading" />

    <Navbar />
    <div class="bg-main chat">
      <div class="container-fluid p-0 h-100">
        <div class="row g-0">
          <div class="col-12 p-0">
            <!-- Sidebar for Patients -->
            <div class="row g-0">
              <div class="h-100" style="width: 340px">
                <div class="card-wrapper w-100 h-100">
                  <ul
                    class="nav w-100 d-flex align-items-center justify-content-center patient-option"
                    id="pills-tab"
                    role="tablist"
                  >
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link active"
                        id="general-patient-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#general-patient"
                        type="button"
                      >
                        ទូទៅ
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link"
                        id="new-patient-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#new-patient"
                        type="button"
                      >
                        អ្នកជំងឺថ្មីៗ
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link"
                        id="notRp-chat-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#notRp-chat"
                        type="button"
                      >
                        មិនទាន់បានតប
                      </button>
                    </li>
                  </ul>

                  <!-- Patients List -->
                  <div class="tab-content patient-chat" id="pills-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="general-patient"
                      v-if="conversations"
                    >
                      <a
                        v-for="patient in conversations"
                        :key="patient.id"
                        class="patientAcc d-flex align-items-start justify-content-between text-decoration-none"
                        @click="getConversationMessage(patient.conversation_id)"
                      >
                        <div class="d-flex justify-content-center">
                          <img
                            :src="patient.sender.avatar"
                            class="patient-avatar me-2"
                            alt=""
                          />
                          <div class="d-flex flex-column align-items-start">
                            <span class="patient-name fw-medium">{{
                              patient.sender.local_fullname
                            }}</span>
                            <small
                              class="last-action-nrp fw-medium"
                              v-if="patient.message"
                            >
                              {{ patient.message?.message || "no message" }}
                            </small>
                          </div>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                          <small class="time-rp">{{
                            patient.message?.created_at || "..."
                          }}</small>
                          <!-- <div class="n-reply fw-medium">1</div> -->
                        </div>
                      </a>
                    </div>
                    <p v-else class="mt-4 text-center text-color-800 fw-medium">
                      មិនមានទំនាក់ទំនងជាមួយវេជ្ជបណ្ឌិតទេ <br />
                      <span class="badge-empty">
                        <i class="fa-light fa-address-book"></i>
                      </span>
                    </p>
                  </div>
                </div>
              </div>

              <!-- Chat Area -->
              <div class="col position-relative my-5">
                <div class="patient-detail bg-white w-100 px-4 py-2">
                  <div class="d-flex align-items-center" v-if="activePatient">
                    <img class="p-avatar" :src="activePatient.avatar" alt="" />
                    <div class="d-flex flex-column">
                      <span class="patient-name fw-medium">{{
                        activePatient.local_fullname
                      }}</span>
                    </div>
                  </div>
                </div>
                <div class="chat-area">
                  <div
                    v-for="msg in messages"
                    :key="msg.id"
                    :class="
                      msg.sender_id == authUserId
                        ? 'chat-sender'
                        : 'chat-receiver'
                    "
                  >
                    <span>
                      {{ msg.message }}
                    </span>
                  </div>
                </div>

                <!-- Text Input -->
                <div class="text-area position-absolute bottom-0 w-100 bg-main">
                  <form class="position-relative d-flex align-items-center">
                    <label for="file-input" class="file-icon-input">
                      <i class="fa-light fa-paperclip"></i>
                    </label>
                    <input type="file" class="d-none" id="file-input" />
                    <textarea
                      class=""
                      placeholder="ផ្ញើរសារ"
                      v-model="inputMessage"
                      rows="1"
                    ></textarea>
                    <a
                      v-if="currentChat"
                      @click="onClickSendMessage()"
                      role="button"
                      class="btn rounded-circle position-absolute submit-text"
                    >
                      <i class="fa-light fa-arrow-up"></i>
                    </a>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Row -->
          </div>
        </div>
      </div>
    </div>
    <FooterView />
  </main>
</template>

<script setup>
import { ref, onMounted, nextTick } from "vue";
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import { useAuthStore } from "@/stores/authTokenStore";
import loadingView from "./loading/loadingView.vue";
import axios from "axios";
import { find } from "lodash";

const activePatient = ref(null);
var messages = ref(null);
var conversation = ref(null);
var conversations = ref(null);
var pagination = ref({});

var chatWith = ref(null);
var currentChat = ref(null);
var inputMessage = ref(null);
// check user id
let authUserId = ref(null);

const authStore = useAuthStore();
const pageLoading = ref(true);
onMounted(async () => {
  try {
    window.scrollTo({ top: 0, behavior: "smooth" });

    authStore.loadToken();
    await getConversation();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

const getConversation = async () => {
  try {
    const response = await axios.get("/api/chat/conversations", {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        Accept: "application/json",
      },
    });
    conversations.value = response.data.data;
    await getId();
  } catch (error) {
    // console.error("Invalid token:", error);
  }
};
let channel = null; // Store the channel subscription

const getConversationMessage = async (id) => {
  try {
    const response = await axios.get(`/api/chat/messages/${id}`, {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        Accept: "application/json",
      },
    });
    const responseData = response.data.data;
    activePatient.value = responseData.conversation.sender;
    messages.value = responseData.messages;
    conversation.value = responseData.conversation;
    currentChat.value = id;
    // currentChat.value = chatWith.value.conversation_id;
    pagination.value = responseData.pagination;
    nextTick(() => {
      const chatBox = document.querySelector(".chat-area");
      if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
      }
    });
  } catch (error) {
    // console.error(
    //   "Error:",
    //   error.response?.status,
    //   error.response?.data,
    //   error.message
    // );
  }
};

const getId = async () => {
  try {
    const response = await axios.get("/api/chat/whoami", {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        Accept: "application/json",
      },
    });
    authUserId = response.data.data.id;
  } catch (error) {
    // console.error("Invalid token:", error);
  }
};

const onClickSendMessage = async () => {
  try {
    const frmData = new FormData();
    frmData.append("message", inputMessage.value);
    frmData.append("conversation_id", currentChat.value);
    const response = await axios.post("/api/chat/messages", frmData, {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
      },
    });
    inputMessage.value = "";
    await getConversationMessage(currentChat.value);
  } catch (error) {
    // console.error(error);
  }
};
// Patient List
// const patients = ref([{ id: 1, name: "Sokha Vireak" }]);

// const activePatient = ref(null);
// const messages = ref({}); // Object to store messages per patient
// const newMessage = ref("");

// Chat functionality
const selectPatient = (patient) => {
  activePatient.value = patient;
  // Initialize empty messages array for this patient if not exists
  if (!messages.value[patient.id]) {
    messages.value[patient.id] = [];
  }
};

const getPatientMessages = (patientId) => {
  return messages.value[patientId] || [];
};

const sendMessage = () => {
  if (newMessage.value.trim() !== "" && activePatient.value) {
    const currentTime = new Date().toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    });
    // Ensure patient messages array exists
    if (!messages.value[activePatient.value.id]) {
      messages.value[activePatient.value.id] = [];
    }

    // Add user message
    messages.value[activePatient.value.id].push({
      text: newMessage.value,
      sender: "user",
      time: currentTime,
    });

    const userMessage = newMessage.value;
    newMessage.value = "";

    // Add bot reply after user message
    setTimeout(() => {
      const botReply = generateBotReply(userMessage);
      messages.value[activePatient.value.id].push({
        text: botReply,
        sender: "bot",
        time: new Date().toLocaleTimeString([], {
          hour: "2-digit",
          minute: "2-digit",
        }),
      });
    }, 500);
  }
};

const generateBotReply = (message) => {
  const responses = {
    // Hello-related responses
    hello: "សួស្តីណារិទ្ធិ! តើមានបញ្ហាអ្វីដែលនាំអ្នកមកនៅថ្ងៃនេះ?",
    ជម្រាបសួរលោកគ្រូ: "សួស្តីណារិទ្ធិ! តើមានបញ្ហាអ្វីដែលនាំអ្នកមកនៅថ្ងៃនេះ?",

    // Help-related responses
    help: "លទ្ធផលតេស្តចេញហើយ! អ្នកគ្រាន់តែមានផ្តាសាយធម្មតា មិនមែន COVID-19 ឬអ្វីធ្ងន់ធ្ងរទេ។ សូមបន្តសំរាក, ផឹកទឹកច្រើន និងប្រើថ្នាំបំបាត់ក្អកបន្តិចបន្តួច។ អ្នកគួរដល់ពេលប្រសើរឡើងក្នុង ២-៣ ថ្ងៃបន្ទាប់!",
    "ខ្ញុំនៅតែមានអាការៈអស់កម្លាំង និងក្តៅខ្លួន ប៉ុន្តែអន់បន្តិចជាងមុន។ តើលទ្ធផលតេស្តរបស់ខ្ញុំចេញហើយឬនៅ?":
      "លទ្ធផលតេស្តចេញហើយ! អ្នកគ្រាន់តែមានផ្តាសាយធម្មតា មិនមែន COVID-19 ឬអ្វីធ្ងន់ធ្ងរទេ។ សូមបន្តសំរាក, ផឹកទឹកច្រើន និងប្រើថ្នាំបំបាត់ក្អកបន្តិចបន្តួច។ អ្នកគួរដល់ពេលប្រសើរឡើងក្នុង ២-៣ ថ្ងៃបន្ទាប់!",
    ឈឺ: "លទ្ធផលតេស្តចេញហើយ! អ្នកគ្រាន់តែមានផ្តាសាយធម្មតា មិនមែន COVID-19 ឬអ្វីធ្ងន់ធ្ងរទេ។ សូមបន្តសំរាក, ផឹកទឹកច្រើន និងប្រើថ្នាំបំបាត់ក្អកបន្តិចបន្តួច។ អ្នកគួរដល់ពេលប្រសើរឡើងក្នុង ២-៣ ថ្ងៃបន្ទាប់!",

    // Doctor-related responses

    // Goodbye-related responses
    bye: "Goodbye! Take care!",
    អរគុណលោកគ្រូ: "បាទណារិទ្ធិ!សូមថែរក្សាសុខភាព!",
  };

  const lowerCaseMessage = message.toLowerCase();

  for (const keyword in responses) {
    if (
      (keyword.match(/^[a-zA-Z]+$/) && lowerCaseMessage.includes(keyword)) ||
      (!keyword.match(/^[a-zA-Z]+$/) && message.includes(keyword))
    ) {
      return responses[keyword];
    }
  }

  return "ខ្ញុំអាចជួយអ្នកបាន! សូមប្រាប់ខ្ញុំបន្ថែមអំពីអ្វីដែលអ្នកត្រូវការ។";
};
const getLastMessage = (patientId) => {
  const patientMessages = messages.value[patientId] || [];
  return patientMessages.length > 0
    ? patientMessages[patientMessages.length - 1].text.substring(0, 20) + "..."
    : "No messages yet";
};

const getLastMessageTime = (patientId) => {
  const patientMessages = messages.value[patientId] || [];
  return patientMessages.length > 0
    ? patientMessages[patientMessages.length - 1].time
    : "N/A";
};

const getUnreadCount = (patientId) => {
  const patientMessages = messages.value[patientId] || [];
  return patientMessages.filter((m) => m.sender === "bot").length > 0
    ? "1"
    : "0";
};
</script>

<style scoped>
.patient-side {
  display: flex;
  align-items: flex-start;
  margin: 10px 0;
}

.user-message {
  flex-direction: row-reverse;
}

.user-message .chat-msg {
  align-items: flex-start;
}

.chat-msg {
  margin: 0 10px;
}
</style>
