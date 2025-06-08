<template>
  <div class="container position-relative overflow-hidden">
    <div class="d-flex justify-content-between align-items-end mb-3">
      <div class="">
        <h4 class="text-color-900 fw-medium">
          កាលវិភាគជំនួបពិគ្រោះជាមួយអ្នកជំងឺ
        </h4>
        <p class="m-0 fs-5 fw-medium">{{ currentTitle }}</p>
        <small class=""
          >ថ្ងៃនេះគឺជា
          <span class="text-color-950 fw-medium">{{
            currentTitle
          }}</span></small
        >
      </div>

      <div class="d-flex">
        <div class="d-flex align-items-center column-gap-2">
          <button @click="goToToday" class="btn text-color-900 me-2">
            <span
              >ថ្ងៃនេះ
              <i class="bi bi-pin-angle"></i>
            </span>
          </button>
          <button @click="goToPrev" class="date-nav-btn">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button @click="goToNext" class="date-nav-btn">
            <i class="bi bi-chevron-right"></i>
          </button>
          <div></div>
        </div>
        <!-- <div class="group-radio d-flex">
          <div class="">
            <input
              type="radio"
              name="appointment"
              class="d-none"
              checked
              id="appointmentAll"
            />
            <label for="appointmentAll">ទាំងអស់</label>
          </div>
          <div>
            <input
              type="radio"
              name="appointment"
              class="d-none"
              id="appointmentCon"
            />
            <label for="appointmentCon">ពិគ្រោះយោបល់</label>
          </div>
          <div>
            <input
              type="radio"
              name="appointment"
              class="d-none"
              id="appointmentService"
            />
            <label for="appointmentService">ពិនិត្យសុខភាព</label>
          </div>
        </div> -->
      </div>
    </div>

    <FullCalendar
      ref="fullCalendar"
      :options="calendarOptions"
      class="bg-white rounded-4"
    />

    <!-- Event Popover -->
    <div
      v-if="showEventPopover"
      class="event-popover"
      :style="eventPopoverStyle"
    >
      <div class="card border-0 row-gap-3 p-2">
        <div
          class="card-header d-flex p-0 border-0 bg-transparent justify-content-between align-items-center"
        >
          <p class="m-0 fs-cus text-color-800 fw-medium">ព័ត៌មានបន្ថែម</p>
          <small class="text-color-700">
            <i class="bi bi-circle-fill"></i>
          </small>
        </div>
        <hr class="hr-cus" />
        <div class="card-body p-0 border-0 bg-transparent">
          <ul class="list-group row-gap-3">
            <li class="list-group-item border-0 p-0">
              <h6 class="m-0 mb-2">អការៈរបស់អ្នកជំងឺ</h6>
              <p class="m-0 fs-6">
                {{
                  selectedEvent?.extendedProps?.description || "No description"
                }}
              </p>
            </li>
            <li class="list-group-item border-0 p-0">
              <h6 class="m-0 mb-2">ពេលវេលាណាត់ជួប</h6>
              <div
                class="card-bg-grey fw-medium d-flex justify-content-between"
              >
                <div>
                  <p class="m-0">
                    <i class="bi bi-calendar4-week me-1"></i>
                  </p>
                  <span>
                    {{ selectedEvent?.extendedProps?.date || "Unknown" }}
                  </span>
                </div>
                <div>
                  <p class="m-0">
                    <i class="bi bi-clock me-1"></i>
                  </p>
                  <span>
                    {{ formatTime(selectedEvent?.start) }} -
                    {{ formatTime(selectedEvent?.end) }}
                  </span>
                </div>
              </div>
            </li>
            <li class="list-group-item border-0 p-0">
              <h6 class="m-0 mb-2">ព័ត៌មានអ្នកជំងឺ</h6>
              <div class="card-bg-grey fw-medium">
                <h5 class="text-color-900">
                  {{ selectedEvent?.extendedProps?.patient?.name || "Unknown" }}
                </h5>
                <div class="d-flex justify-content-between align-items-center">
                  <small>
                    <i class="bi bi-telephone"></i>
                    {{
                      selectedEvent?.extendedProps?.patient?.phone || "No phone"
                    }}
                  </small>
                  <i class="bi bi-circle-fill text-color-600"></i>
                  <small>
                    <i class="bi bi-envelope"></i>
                    {{
                      selectedEvent?.extendedProps?.patient?.email || "No email"
                    }}
                  </small>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="card-footer p-0 border-0 bg-transparent">
          <div class="d-flex justify-content-between">
            <a
              v-if="
                selectedEvent?.extendedProps?.isComplete == 0 &&
                isToday(selectedEvent?.extendedProps?.date_app)
              "
              role="button"
              @click="
                onClickCreateMedicalRecord(selectedEvent?.extendedProps?.data)
              "
              class="main-btn w-100 me-2"
            >
              <span><i class="fa-light fa-print"></i> កំណត់ត្រាជំងឺ</span>
            </a>
            <a
              role="button"
              @click="onClickDetailBooking(selectedEvent?.extendedProps?.id)"
              class="sub-btn w-100 ms-2"
            >
              <span>ព័ត៌មានបន្ថែម</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Header Popover -->
    <div
      v-if="showHeaderPopover"
      class="header-popover"
      :style="headerPopoverStyle"
    >
      <div class="card border-0 row-gap-3 p-2">
        <div
          class="card-header d-flex p-0 border-0 bg-transparent justify-content-between align-items-center"
        >
          <p class="m-0 fs-cus text-color-800 fw-medium">
            ចំនួនកិច្ចការដែលត្រូវបំពេញ
          </p>
          <!-- <strong>{{ headerPopoverMessage }}</strong> -->
          <small class="text-color-700">
            <i class="bi bi-circle-fill"></i>
          </small>
        </div>
        <hr class="hr-cus" />
        <div class="card-body p-0 border-0 bg-transparent">
          <div class="accordion" id="accordionExample">
            <div class="accordion-item border-0 p-0 mb-3">
              <div class="accordion-header p-0" id="headingOne">
                <button
                  class="accordion-button collapsed p-0"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseOne"
                >
                  <h6>
                    ផ្នែកប្រឹក្សាពិគ្រោះ
                    <small class="text-red">(ចំនួន​សរុប 2)</small>
                  </h6>
                </button>
              </div>
              <div
                id="panelsStayOpen-collapseOne"
                class="accordion-collapse collapse show"
              >
                <div class="accordion-body p-0 border-0">
                  <table>
                    <thead>
                      <th>
                        <small> ឈ្មោះ </small>
                      </th>
                      <th><small> ម៉ោង </small></th>
                      <th><small>ស្ថានភាព</small></th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>សុខ ចាន់នី</td>
                        <td>9:00AM-10:00AM</td>
                        <td>មិនទាន់បំពេញ</td>
                        <td>
                          <div class="dropdown">
                            <a
                              role="button"
                              class="dropdown-toggle"
                              data-bs-toggle="dropdown"
                              ><i class="bi bi-three-dots-vertical"></i
                            ></a>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li>
                                <a class="dropdown-item" href="#">
                                  <small> ព័ត៌មានបន្ថែម </small>
                                </a>
                              </li>
                              <li>
                                <a class="dropdown-item" href="#"
                                  ><small>កំណត់ត្រាជំងឺ</small></a
                                >
                              </li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>សុខ ចាន់នី</td>
                        <td>9:00AM-10:00AM</td>
                        <td>មិនទាន់បំពេញ</td>
                        <td>
                          <a role="button"
                            ><i class="bi bi-three-dots-vertical"></i
                          ></a>
                        </td>
                      </tr>
                      <tr>
                        <td>សុខ ចាន់នី</td>
                        <td>9:00AM-10:00AM</td>
                        <td>មិនទាន់បំពេញ</td>
                        <td>
                          <a role="button"
                            ><i class="bi bi-three-dots-vertical"></i
                          ></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="accordion-item border-0 p-0">
              <div class="accordion-header p-0" id="headingOne">
                <button
                  class="accordion-button collapsed p-0"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseTwo"
                >
                  <h6>
                    ផ្នែកប្រឹក្សាពិគ្រោះ
                    <small class="text-red">(ចំនួន​សរុប 2)</small>
                  </h6>
                </button>
              </div>
              <div
                id="panelsStayOpen-collapseTwo"
                class="accordion-collapse collapse show"
              >
                <div class="accordion-body p-0 border-0">
                  <table>
                    <thead>
                      <th>
                        <small> ឈ្មោះ </small>
                      </th>
                      <th><small> ម៉ោង </small></th>
                      <th><small>ស្ថានភាព</small></th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>សុខ ចាន់នី</td>
                        <td>9:00AM-10:00AM</td>
                        <td>មិនទាន់បំពេញ</td>
                        <td>
                          <a role="button"
                            ><i class="bi bi-three-dots-vertical"></i
                          ></a>
                        </td>
                      </tr>
                      <tr>
                        <td>សុខ ចាន់នី</td>
                        <td>9:00AM-10:00AM</td>
                        <td>មិនទាន់បំពេញ</td>
                        <td>
                          <a role="button"
                            ><i class="bi bi-three-dots-vertical"></i
                          ></a>
                        </td>
                      </tr>
                      <tr>
                        <td>សុខ ចាន់នី</td>
                        <td>9:00AM-10:00AM</td>
                        <td>មិនទាន់បំពេញ</td>
                        <td>
                          <a role="button"
                            ><i class="bi bi-three-dots-vertical"></i
                          ></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <p>
        <strong>{{ headerPopoverMessage }}</strong>
      </p>
      <button class="btn btn-sm btn-danger" @click="showHeaderPopover = false">
        Close
      </button> -->
    </div>
  </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue3";
import timeGridPlugin from "@fullcalendar/timegrid";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import kmLocale from "@fullcalendar/core/locales/km";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
import { useAppointmentStore } from "@/stores/appointmentStore";
import { dashboardGeneralStore } from "@/stores/dashboardStore";
import { ref } from "vue";
export default {
  name: "FullCalendarComponent",
  components: { FullCalendar },
  data() {
    return {
      calendarOptions: {
        locales: [kmLocale],
        locale: "km",
        plugins: [timeGridPlugin, dayGridPlugin, interactionPlugin],
        initialView: "timeGridWeek",
        headerToolbar: false,

        eventContent: (arg) => {
          return {
            html: `
              <div class="custom-event">
                <div class="event-title"> <h6> ${arg.event.title} </h6></div>
                <div class="event-time"><i class="bi bi-clock"></i> ${arg.timeText}</div>
              </div>
            `,
          };
        },
        datesSet: this.updateTitle,
        height: "100%",
        slotMinTime: "08:00:00",
        slotMaxTime: "17:00:00",
        slotDuration: "01:00:00",

        eventClick: this.handleEventClick,
        allDaySlot: false,
        eventOverlap: true,
        eventColor: "transparent",
        eventTextColor: "#000",
        dayHeaderDidMount: this.makeHeadersClickable,

        titleFormat: { year: "numeric", month: "long" },
        dayHeaderFormat: { weekday: "short", day: "numeric" },
        dayHeaderClassNames: (args) => {
          const dateObj = new Date(args.date);

          if (isNaN(dateObj.getTime())) {
            // console.error("Invalid date value:", args.date);
            return "";
          }

          const dateStr = dateObj.toISOString().split("T")[0];

          if (
            !this.calendarOptions?.events ||
            !Array.isArray(this.calendarOptions.events)
          ) {
            return "";
          }

          const hasEvent = this.calendarOptions.events.some(
            (event) => event.date === dateStr
          );

          return hasEvent ? "has-event" : "";
        },

        dayHeaderContent: (args) => {
          const khmerDays = [
            "អាទិត្យ",
            "ចន្ទ",
            "អង្គារ",
            "ពុធ",
            "ព្រហស្បតិ៍",
            "សុក្រ",
            "សៅរ៍",
          ];
          return `${khmerDays[args.date.getDay()]} ${args.date.getDate()}`;
        },
      },
      currentTitle: "",
      showEventPopover: false,
      showHeaderPopover: false,
      eventPopoverMessage: "",
      headerPopoverMessage: "",
      eventPopoverStyle: { top: "0px", left: "0px" },
      headerPopoverStyle: { top: "0px", left: "0px" },
    };
  },
  setup() {
    const { onClickCreateMedicalRecord } = useAppointmentStore();
    const { onClickDetailBooking } = dashboardGeneralStore();
    return {
      pageLoading: true,
      onClickCreateMedicalRecord,
      onClickDetailBooking,
    };
  },
  methods: {
    formatTime(date) {
      if (!date) return "Unknown";
      const d = new Date(date);
      return isNaN(d.getTime()) ? "Invalid date" : d.toLocaleTimeString();
    },
    async fetchEvents() {
      try {
        const authStore = useAuthStore();
        authStore.loadToken();
        const response = await axios.get("/api/calendars", {
          // const response = await axios.get("/api/bookings", {
          headers: {
            Authorization: `Bearer ${authStore.token}`,
          },
        });
        // Update only the events property, preserving other options
        this.calendarOptions.events = response.data.data.map((event) => {
          const [datePart, timePart] = event.appointment.split(" ");
          const [day, month, year] = datePart.split("/");
          const [hour, minute] = timePart.split(":");

          const formattedDate = `${year}-${month}-${day}T${hour}:${minute}:00`;
          const appointmentDate = new Date(formattedDate);
          if (isNaN(appointmentDate.getTime())) {
            // console.error("Invalid appointment date:", event.appointment);
            return {};
          }

          const endDateTime = new Date(appointmentDate);
          endDateTime.setHours(appointmentDate.getHours() + 1);

          return {
            title: event.local_name || event.name,
            start: appointmentDate.toISOString(),
            end: endDateTime.toISOString(),
            extendedProps: {
              data: event,

              id: event.id,
              date: event.appointment,
              date_app: event.appointment,
              isComplete: event.is_complete,
              user_id: event.user.id,
              description: event.description,
              patient: {
                name: event.local_name || event.name,
                phone: event.phone_number,
                email: event.email,
              },
            },
          };
        });
      } catch (error) {
        // console.error("Error fetching events:", error);
      }
    },
    isToday(dateString) {
      if (!dateString) return false;
      // Example for '18/04/2025 10:00'
      const [day, month, yearAndTime] = dateString.split("/");
      const [year] = yearAndTime.split(" ");
      const inputDate = new Date(`${year}-${month}-${day}`);
      if (isNaN(inputDate.getTime())) return false;
      const today = new Date();
      return (
        inputDate.getDate() === today.getDate() &&
        inputDate.getMonth() === today.getMonth() &&
        inputDate.getFullYear() === today.getFullYear()
      );
    },
    handleEventClick(info) {
      try {
        this.selectedEvent = info.event;
        this.showEventPopover = false;
        setTimeout(() => {
          const rect = info.jsEvent.target.getBoundingClientRect();
          const scrollX = window.scrollX;
          const scrollY = window.scrollY;

          const popoverWidth = 400;
          const popoverHeight = 150;

          let topPos = rect.bottom + scrollY + 10 - 200;
          let leftPos = rect.left + scrollX - 120;

          const windowWidth = window.innerWidth;
          const windowHeight = window.innerHeight;
          const buffer = 20;

          // Adjust for right overflow (move to the left if it overflows)

          if (leftPos + popoverWidth + 250 > windowWidth + scrollX) {
            leftPos = rect.left + scrollX - popoverWidth - 10 - 300; // Place to the left with 10px buffer
          }

          // Adjust for left overflow (ensure it doesn't go left of the viewport)
          if (leftPos < scrollX) {
            leftPos = rect.right + scrollX + buffer; // Fallback to right with buffer
          }
          // Adjust for bottom overflow (move up if it overflows)
          if (topPos + popoverHeight + 500 > windowHeight + scrollY) {
            topPos = windowHeight + scrollY - popoverHeight - buffer - 500; // Align to bottom of viewport
          }

          // Adjust for top overflow (ensure it doesn't go above the viewport)
          if (topPos < scrollY) {
            topPos = scrollY + buffer; // Align near the top of the viewport
          }
          this.eventPopoverStyle = {
            top: `${topPos}px`,
            left: `${leftPos}px`,
            maxWidth: `${popoverWidth}px`,
          };
          this.showEventPopover = true;
        }, 10);
      } catch (error) {
        console.error("Error in handleEventClick:", error);
      }
    },
    closePopovers(event) {
      if (
        !event.target.closest(".event-popover") &&
        !event.target.closest(".header-popover")
      ) {
        this.showEventPopover = false;
        this.showHeaderPopover = false;
      }
    },
    updateTitle(info) {
      this.currentTitle = info.view.title;
    },
    goToPrev() {
      this.$refs.fullCalendar.getApi().prev();
    },
    goToNext() {
      this.$refs.fullCalendar.getApi().next();
    },
    goToToday() {
      this.$refs.fullCalendar.getApi().today();
    },
    formatDateTime(date) {
      return new Date(date).toLocaleString();
    },
  },
  async mounted() {
    try {
      await this.fetchEvents();
      document.addEventListener("click", this.closePopovers);
    } catch (error) {
      console.error(error);
    }
  },
  beforeUnmount() {
    document.removeEventListener("click", this.closePopovers);
  },
};
</script>
