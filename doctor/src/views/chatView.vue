<template>
  <main class="bg-main chat">
    <loadingView v-if="pageLoading" />
    <div class="container-fluid p-0 h-100">
      <div class="row g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div class="col-10 p-0">
          <navhead />

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
                <div
                  class="tab-content patient-chat"
                  id="pills-tabContent"
                  v-if="conversations"
                >
                  <div class="tab-pane fade show active" id="general-patient">
                    <a
                      role="button"
                      v-for="patient in conversations"
                      :key="patient.id"
                      @click="getConversationMessage(patient.conversation_id)"
                    >
                      <div
                        class="patientAcc d-flex align-items-start justify-content-between"
                        :class="
                          currentChat.value == patient.conversation_id
                            ? 'bg-body-tertiary'
                            : 'bg-white'
                        "
                      >
                        <div class="d-flex justify-content-center">
                          <img
                            :src="patient.receiver.avatar"
                            class="patient-avatar me-2"
                            alt=""
                          />
                          <div class="d-flex flex-column align-items-start">
                            <span class="patient-name fw-medium">{{
                              patient.receiver.fullname
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
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Chat Area -->
            <div class="col position-relative">
              <div class="patient-detail bg-white w-100 px-4 py-2">
                <div class="d-flex align-items-center" v-if="activePatient">
                  <img class="p-avatar" :src="activePatient.avatar" alt="" />
                  <div class="d-flex flex-column">
                    <span class="patient-name fw-medium">{{
                      activePatient.fullname
                    }}</span>
                  </div>
                </div>
              </div>
              <div class="chat-area mt-5 pt-5">
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
  </main>
</template>

<script setup>
import { onMounted, ref, nextTick, registerRuntimeCompiler } from "vue";
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import loadingView from "@/components/global/loadingView.vue";
import { useAuthStore } from "@/stores/userAuthStore";
// import echo from "@/lib/echo";
import axios from "axios";
const authStore = useAuthStore();

const activePatient = ref(null);
var messages = ref(null);
var conversation = ref(null);
var conversations = ref(null);
var pagination = ref({});

var currentChat = ref(0);
var inputMessage = ref(null);
// check user id
let authUserId = ref(null);

const userConversation = ref(null);
const getActiveConversation = (id) => {
  userConversation.value = id;
  return (userConversation.value = id);
};
const pageLoading = ref(true);
onMounted(async () => {
  try {
    //   echo.channel("test-channel").listen(".TestEvent", (e) => {
    //     console.log("Test Event Received:", e.message);
    //   });
    //   echo
    //     .private("chat")
    //     .listen(".ChatMessageSent", (data) => {
    //       console.log("Received message:", data);
    //       messages.value.push(data);
    //     })
    //     .subscribed(() => {
    //       console.log("Subscribed to private-chat");
    //     })
    //     .error((error) => {
    //       console.error("Subscription error:", error);
    //     });
    authStore.loadToken();
    await getConversation();

    let conversation_id = sessionStorage.getItem("conversation_id");
    sessionStorage.clear();
    if (conversation_id) {
      getConversationMessage(conversation_id);
    }
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
// let echoInstance = null;

// const setupEcho = async (id) => {
//   const authStore = useAuthStore();
//   authStore.loadToken();
//   if (!authStore.token) {
//     console.error("🚫 No token");
//     return;
//   }
//   console.log("Token:", authStore.token);
//   console.log("API Host:", import.meta.env.VITE_API_HOST);
//   console.log(
//     "Auth Endpoint:",
//     `${import.meta.env.VITE_API_HOST}/api/broadcasting/auth`
//   );

//   // Fetch CSRF cookie
//   try {
//     await fetch(`${import.meta.env.VITE_API_HOST}/sanctum/csrf-cookie`, {
//       credentials: "include",
//     });
//     console.log("CSRF cookie fetched");
//   } catch (err) {
//     console.error("CSRF fetch error:", err);
//   }

//   if (!echoInstance) {
//     window.Pusher = Pusher;
//     window.Pusher.logToConsole = true;

//     const pusherClient = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
//       cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//       forceTLS: true,
//       authEndpoint: `${import.meta.env.VITE_API_HOST}/api/pusher/auth`,
//       authorizer: (channel, options) => {
//         return {
//           authorize: (socketId, callback) => {
//             axios
//               .post(
//                 `${import.meta.env.VITE_API_HOST}/api/pusher/auth`,
//                 {
//                   socket_id: socketId,
//                   channel_name: "private-" + channel.name,
//                 },
//                 {
//                   headers: {
//                     Authorization: `Bearer ${authStore.token}`,
//                     Accept: "application/json",
//                   },
//                 }
//               )
//               .then((response) => {
//                 console.log("Pusher Auth Success:", response.data);
//                 callback(null, response.data);
//               })
//               .catch((error) => {
//                 console.error("Pusher Auth Error:", error);
//                 callback(error, null);
//               });
//           },
//         };
//       },
//     });

//     echoInstance = new Echo({
//       broadcaster: "pusher",
//       client: pusherClient,
//       key: import.meta.env.VITE_PUSHER_APP_KEY,
//       cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//       forceTLS: true,
//     });

//     echoInstance.connector.pusher.connection
//       .bind("connected", () => console.log("✅ Pusher connected"))
//       .bind("error", (err) =>
//         console.error("💥 Pusher error:", err, err.status, err.message)
//       );
//   }

//   if (currentChat.value && currentChat.value !== id) {
//     echoInstance.leave(`chat.${currentChat.value}`);
//   }

//   console.log(`Subscribing to: chat.${id}`);
//   echoInstance
//     .private(`chat.${id}`)
//     .subscribed(() => console.log(`📡 Subscribed to chat.${id}`))
//     .error((error) =>
//       console.error("💥 Channel error:", error, error.status, error.message)
//     )
//     .listen(".MessageSent", (e) => {
//       console.log("📥 Message:", e);
//       messages.value.push(e.message);
//       nextTick(() => {
//         const chatBox = document.querySelector(".chat-area");
//         if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
//       });
//     });

//   currentChat.value = id;
// };
const setupEcho = async (id) => {
  //   echo.channel("test-channel").listen("TestEvent", (e) => {
  //     console.log("Received event:", e.message);
  //   });
  if (!authStore.token) {
    console.error("Cannot setup Echo: User not authenticated");
    return;
  }
  const echoInstance = echo;
  if (!echoInstance) return;
  echoInstance
    .private(`chat.${id}`)
    .subscribed(() => {
      console.log(`Subscribed to chat.${id}`);
    })
    .listen("MessageSent", (e) => {
      console.log("Received MessageSent:", e);
      messages.value.push({
        id: messageId++,
        sender: e.message.sender,
        text: e.message.text,
        // timestamp: new Date(e.message.created_at).toLocaleTimeString(),
      });
      nextTick(() => {
        const chatBox = document.querySelector(".chat-area");
        if (chatBox) {
          chatBox.scrollTop = chatBox.scrollHeight;
        }
      });
    })
    .error((error) => {
      console.error("Channel subscription error:", error, error.response);
    });
  currentChat.value = id;
};

// const setupEcho = (id) => {
//   if (!authStore.token) {
//     console.error("Cannot setup Echo: User not authenticated");
//     return;
//   }
//   if (!echo) return;
//   echo
//     .private(`chat.${id}`)
//     .subscribed(() => {
//       console.log(`Subscribed to chat.${id}`);
//     })
//     .listen("MessageSent", (e) => {
//       console.log("Received MessageSent:", e);
//       messages.value.push(e.message);
//       nextTick(() => {
//         const chatBox = document.querySelector(".chat-area");
//         if (chatBox) {
//           chatBox.scrollTop = chatBox.scrollHeight;
//         }
//       });
//     })
//     .error((error) => {
//       console.error("Channel subscription error:", error, error.response);
//     });
//   currentChat.value = id;
// };

// Setup Echo for real-time updates
// const setupEcho = () => {
//   // Leave previous channel if it exists
//   if (currentChat.value) {
//     echo.leave(`chat.${currentChat.value}`);
//   }
//   echo.options.auth = {
//     headers: {
//       Authorization: `Bearer ${authStore.token}`,
//       Origin: currentOrigin,
//     },
//   };

//   echo
//     .private(`chat.${currentChat.value}`)
//     .subscribed(() => {
//       console.log(`Subscribed to chat.${currentChat.value}`);
//     })
//     .listen("MessageSent", (e) => {
//       console.log("Received MessageSent:", e);
//       messages.value.push(e.message);
//       nextTick(() => {
//         const chatBox = document.querySelector(".chat-area");
//         chatBox.scrollTop = chatBox.scrollHeight;
//       });
//     });
// };

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
    console.error("Invalid token:", error);
  }
};
let channel = null; // Store the channel subscription

const getConversationMessage = async (id) => {
  try {
    // const echo = useEcho(); // Initialize Echo with authStore.token
    // let channel;

    // Leave the previous channel if it exists
    // if (channel) {
    //   channel.stopListening("MessageSent");
    //   echo.leave(`chat.${currentChat.value}`);
    //   console.log(`Left channel chat.${currentChat.value}`);
    // }

    // // Wait for Echo to connect
    // await echo.connector.connection();
    // console.log("Echo connected!");

    // // Subscribe to the new channel
    // channel = echo
    //   .private(`chat.${id}`)
    //   .listen("MessageSent", (e) => {
    //     messages.value.push(e.MessageSent.message);
    //     console.log("New message received:", messages.value);
    //   })
    //   .subscribed(() => {
    //     console.log(`Subscribed to chat.${id}`);
    //   })
    //   .error((error) => {
    //     console.error("Channel subscription error:", error);
    //   });

    // Fetch initial messages
    const response = await axios.get(`/api/chat/messages/${id}`, {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        Accept: "application/json",
      },
    });
    const responseData = response.data.data;
    messages.value = responseData.messages;
    conversation.value = responseData.conversation;
    activePatient.value = responseData.conversation.receiver;
    currentChat.value = id;
    pagination.value = responseData.pagination;
    nextTick(() => {
      const chatBox = document.querySelector(".chat-area");
      if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
      }
    });
  } catch (error) {
    console.error(
      "Error:",
      error.response?.status,
      error.response?.data,
      error.message
    );
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

const createConversation = async (patientId) => {
  if (!token) {
    // console.error("Error: No authentication token found.");
    alert("Session expired. Please log in again.");
    router.push("/login");
    return;
  }

  try {
    const response = await axios.post(
      "/api/chat/conversations",
      { patient_id: patientId },
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
          Accept: "application/json",
        },
      }
    );

    if (response.data) {
      //   activePatient.value = patients.value.find((p) => p.id === patientId);
    }
  } catch (error) {
    console.error(
      "Error creating conversation:",
      error.response?.data || error.message
    );
    alert(
      "Error: " + (error.response?.data?.message || "Something went wrong.")
    );
  }
};

// Handle Click on Patient
const onClickDetail = (id) => {
  if (!id) {
    console.error("Error: Patient ID is undefined!");
    return;
  }
  createConversation(id);
};
</script>
