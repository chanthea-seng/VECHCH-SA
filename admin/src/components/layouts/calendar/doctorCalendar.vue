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
        <div class="group-radio d-flex">
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
        </div>
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
                I’ve been having a really bad headache for the past three days.
                The pain feels like a dull ache, and I’d rate it about 6 out of
                10. It’s mostly around my forehead and temples.
              </p>
            </li>
            <li class="list-group-item border-0 p-0">
              <h6 class="m-0 mb-2">ពេលវេលាណាត់ជួប</h6>
              <div
                class="card-bg-grey fw-medium d-flex justify-content-between"
              >
                <span
                  ><i class="bi bi-calendar4-week me-1"></i> ថ្ងៃអង្គារ ទី15
                  ខែកុម្ភៈ ឆ្នាំ2025</span
                >
                <span>|</span>
                <span><i class="bi bi-clock me-1"></i> 07:00-8:00</span>
              </div>
            </li>
            <li class="list-group-item border-0 p-0">
              <h6 class="m-0 mb-2">ព័ត៌មានអ្នកជំងឺ</h6>
              <div class="card-bg-grey fw-medium">
                <h5 class="text-color-900">សុខ ចាន់នី</h5>
                <div class="d-flex justify-content-between align-items-center">
                  <small><i class="bi bi-telephone"></i> +855 989876543</small>
                  <i class="bi bi-circle-fill text-color-600"></i>
                  <small
                    ><i class="bi bi-envelope"></i> sokchanny@gmail.com</small
                  >
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="card-footer p-0 border-0 bg-transparent">
          <div class="d-flex justify-content-between">
            <button class="main-btn w-100 me-2">
              <span>កំណត់ត្រាជំងឺ</span>
            </button>
            <button class="sub-btn w-100 ms-2">
              <span>កំណត់ត្រាជំងឺ</span>
            </button>
          </div>
        </div>
      </div>
    </div>

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
        events: [],
        eventContent: (arg) => {
          // Customize the event content
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
        slotDuration: "01:00:00", // Each slot is 30 minutes

        eventClick: this.handleEventClick,
        allDaySlot: false,
        eventOverlap: true,
        eventColor: "transparent",
        eventTextColor: "#000",
        dayHeaderDidMount: this.makeHeadersClickable,

        titleFormat: { year: "numeric", month: "long" },
        dayHeaderFormat: { weekday: "short", day: "numeric" },
        dayHeaderClassNames: (args) => {
          // Check if the day has events
          const hasEvent = this.calendarOptions.events.some(
            (event) => event.date === args.date.toISOString().split("T")[0]
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
  methods: {
    async fetchEvents() {
      try {
        const response = await axios.get("/api/v1/books");
        this.calendarOptions.events = response.data.data.map((event) => {
          const startDateTime = new Date(`${event.date}T${event.time}`);
          const endDateTime = new Date(startDateTime);
          endDateTime.setHours(startDateTime.getHours() + 1);
          return {
            title: event.username,
            start: startDateTime.toISOString(),
            end: endDateTime.toISOString(),
            date: event.date,
          };
        });
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    },
    handleEventClick(info) {
      this.showEventPopover = false; // Reset before showing a new one
      setTimeout(() => {
        this.eventPopoverMessage = `Appointment: ${
          info.event.title
        } \n ${this.formatDateTime(info.event.start)} - ${this.formatDateTime(
          info.event.end
        )}`;

        const rect = info.jsEvent.target.getBoundingClientRect();
        let topPos = rect.top + window.scrollY - 40;
        let leftPos = rect.left + window.scrollX + 140;

        // Get viewport dimensions
        const popoverWidth = 400; // Adjust based on actual popover width
        const popoverHeight = 150; // Adjust based on actual popover height
        const windowWidth = window.innerWidth;
        const windowHeight = window.innerHeight;

        // Buffer to prevent clipping
        const buffer = 20; // Add extra spacing to avoid cut-off issues

        // Adjust for bottom overflow
        if (topPos + popoverHeight + 100 > windowHeight + window.scrollY) {
          topPos = rect.top + window.scrollY - popoverHeight - buffer - 230;
        }
        // Adjust for top overflow
        if (topPos < window.scrollY) {
          topPos = rect.bottom + window.scrollY + buffer;
        }

        // Adjust for right overflow (with buffer)
        if (leftPos + popoverWidth + 100 > windowWidth + window.scrollX) {
          leftPos = rect.left + window.scrollX - popoverWidth - buffer;
        }
        // console.log(leftPos + popoverWidth);
        // console.log(windowWidth + window.scrollX);

        // Adjust for left overflow
        if (leftPos < window.scrollX) {
          leftPos = rect.right + window.scrollX + buffer;
        }

        this.eventPopoverStyle = {
          top: `${topPos}px`,
          left: `${leftPos}px`,
          maxWidth: `${popoverWidth}px`, // Prevents horizontal overflow
        };
        this.showEventPopover = true;
      }, 10);
    },
    makeHeadersClickable(info) {
      info.el.style.cursor = "pointer";
      info.el.addEventListener("click", (event) => {
        const date = info.date; // Ensure the correct date is passed
        this.handleHeaderClick(event, date);
      });
    },
    handleHeaderClick(event, date) {
      this.showHeaderPopover = false; // Reset before showing a new one
      setTimeout(() => {
        // const targetDate = new Date(date).toLocaleDateString("en-CA"); // "YYYY-MM-DD"
        const targetDate = new Date(date).toLocaleDateString("en-CA", {
          timeZone: "Asia/Phnom_Penh",
        });

        const appointmentCount = this.calendarOptions.events.filter((event) => {
          const eventDate = new Date(event.start).toLocaleDateString("en-CA");
          // console.log(`Checking Event: ${eventDate} === ${targetDate}`);
          return eventDate === targetDate;
        }).length;

        this.headerPopoverMessage = `Total Appointments: ${appointmentCount}`;
        const rect = event.target.getBoundingClientRect();
        let topPos = rect.top + window.scrollY + 45;
        let leftPos = rect.left + window.scrollX;

        const popoverWidth = 400; // Adjust based on actual popover width
        const windowWidth = window.innerWidth;
        if (topPos < window.scrollY) {
          topPos = rect.bottom + window.scrollY;
        }
        if (leftPos + popoverWidth + 230 > windowWidth + window.scrollX) {
          leftPos = rect.left + window.scrollX - popoverWidth + 170;
        }
        this.headerPopoverStyle = {
          top: `${topPos}px`,
          left: `${leftPos}px`,
          maxWidth: `${popoverWidth}px`, // Prevents horizontal overflow
        };
        this.showHeaderPopover = true;
      }, 10);
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
  mounted() {
    this.fetchEvents();
    document.addEventListener("click", this.closePopovers);
  },
  beforeUnmount() {
    document.removeEventListener("click", this.closePopovers);
  },
};
</script>