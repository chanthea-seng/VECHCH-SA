<template>
  <div class="col-12 m-auto app-calendar">
    <loadingView v-if="pageLoading" />

    <div class="d-flex justify-content-between align-items-end mb-3">
      <div class="">
        <h4 class="text-color-900 fw-medium">Appointment Calendar</h4>
        <p class="m-0 fs-5 fw-medium">{{ currentTitle }}</p>
        <!-- <small class=""
          >Today
          <span class="text-color-950 fw-medium">{{
            currentTitle
          }}</span></small
        > -->
      </div>

      <div class="d-flex">
        <div class="d-flex align-items-center column-gap-2">
          <button @click="goToToday" class="btn text-color-900 me-2">
            <span
              >Today
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
      </div>
    </div>

    <!-- FullCalendar Component -->
    <FullCalendar :options="calendarOptions" ref="fullCalendar" />
    <!-- Appointment Details Canvas -->
    <div
      class="offcanvas offcanvas-end p-3"
      tabindex="-1"
      id="appointmentCanvas"
    >
      <div class="offcanvas-header d-block p-0">
        <div class="account-information w-100 mb-2">
          <h4
            class="offcanvas-title fs-6 text-color-900 fw-medium d-flex justify-content-between"
          >
            Appointments Date: {{ selectedDate }}
            <i class="bi bi-dot text-color-600"></i>
          </h4>
        </div>
        <p class="m-0">
          Total apppointment:
          <span class="fw-medium">
            {{ selectedDateAppointments.length }}
          </span>
        </p>
        <!-- <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button> -->
      </div>
      <hr class="my-2" />
      <div class="offcanvas-body p-0">
        <ul class="list-group">
          <li
            v-for="(appointment, index) in selectedDateAppointments"
            :key="index"
            class="list-group-item"
            :class="appointment.booking_status == 4 ? 'bg-danger' : ''"
          >
            <span class="fw-medium text-color-900">Status : </span>
            <span
              class="status p-0 mb-3 px-2 py-1"
              :class="appointment.is_complete == true ? 'completed' : 'pending'"
            >
              {{ appointment.is_complete == true ? "Complete" : "Pending" }}
            </span>
            <div class="d-flex">
              <h6 class="event-title fw-medium w-50">
                <span>{{
                  appointment.service_type == 0
                    ? "Consultant"
                    : appointment.service_type == 1
                    ? "Check-up"
                    : "Vaccine"
                }}</span>
              </h6>
              <small class="fw-medium text-grey-small">{{
                appointment.appointment
              }}</small>
            </div>
            <div class="d-flex flex-wrap">
              <div class="w-50">
                <label class="me-2">Name: </label>
                <span class="fw-medium">{{
                  appointment.local_name || appointment.name
                }}</span>
                <br />
                <label class="me-2">Phone: </label>
                <span class="fw-medium">{{ appointment.phone_number }}</span>
              </div>
              <div class="w-50">
                <label class="me-2">Gender: </label>
                <span class="fw-medium">{{
                  appointment.gender == 1 ? "Male" : "Female"
                }}</span>
                <br />
                <label class="me-2">Age: </label>
                <span class="fw-medium">{{ appointment.dob }}</span>
              </div>
              <div class="w-100 d-flex">
                <label class="me-2">Email: </label>
                <span class="limit-line-1 fw-medium">{{
                  appointment.email
                }}</span>
              </div>
              <div
                v-if="appointment.description"
                class="booking-desc mt-2 limit-line-2"
              >
                <span>{{ appointment.description }}</span>
              </div>
              <label
                for=""
                class="fw-medium text-color-800 mt-2 mb-1"
                v-if="appointment.doctor"
                >Consult with</label
              >
              <div
                v-if="appointment.doctor"
                class="d-flex align-items-center column-gap-2 card-doc"
              >
                <img
                  :src="appointment.doctor.avatar"
                  class="doc-avatar"
                  alt=""
                />
                <div>
                  <span class="fw-medium text-color-950"
                    >Dr.
                    {{
                      appointment.doctor.name ||
                      appointment.doctor.local_fullname
                    }}</span
                  >
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import loadingView from "@/components/loadingView.vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import axios from "axios";
import { Offcanvas } from "bootstrap";
import { useAuthStore } from "@/stores/userAuthStore";
import { parse, format } from "date-fns";
export default {
  components: {
    FullCalendar,
    loadingView,
  },
  data() {
    return {
      pageLoading: true,
      isMonthViewActive: true,
      isWeekViewActive: false,
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        headerToolbar: false,
        events: [],
        eventClick: this.handleEventClick,
        datesSet: (info) => {
          this.updateTitle(info);
        },
      },
      currentTitle: "",
      selectedDate: "",
      selectedDateAppointments: [],
    };
  },
  methods: {
    async fetchEvents() {
      try {
        const authStore = useAuthStore();
        authStore.loadToken();
        const response = await axios.get("/api/calendars/admin", {
          headers: {
            Authorization: `Bearer ${authStore.token}`,
          },
        });

        // Group events by date
        const groupedEvents = response.data.data.reduce((acc, event) => {
          // Parse appointment string (e.g., "28/03/2025 13:30")
          const parsedDate = parse(
            event.appointment,
            "dd/MM/yyyy HH:mm",
            new Date()
          );
          const date = format(parsedDate, "yyyy-MM-dd");
          const time = format(parsedDate, "HH:mm");
          const eventWithTime = { ...event, time };
          if (!acc[date]) acc[date] = [];
          acc[date].push(eventWithTime);
          return acc;
        }, {});

        this.groupedEvents = Object.keys(groupedEvents).map((date) => ({
          title: `${groupedEvents[date].length} Appointments`,
          start: date,
          extendedProps: {
            title: `${groupedEvents[date].length} Appointments`,
            appointments: groupedEvents[date],
          },
        }));
      } catch (error) {
        console.error("Error fetching events:", error);
      }
    },
    handleEventClick(info) {
      this.selectedDate = info.event.startStr;
      this.selectedDateAppointments =
        info.event.extendedProps.appointments || [];
      const offcanvas = new Offcanvas(
        document.getElementById("appointmentCanvas")
      );
      offcanvas.show();
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
      this.calendarOptions.events = this.groupedEvents;
    } catch (error) {
    } finally {
      this.pageLoading = false;
    }
  },
};
</script>
