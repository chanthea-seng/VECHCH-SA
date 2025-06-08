import { defineStore } from "pinia";
import axios from 'axios';

export const calenderStore = defineStore('calenderstore', {
    state: () => ({
        selectedDate: null,
        selectedTime: null,
        disabledDates: [
            "2025-01-30",
            "2025-02-10",
            new Date().toLocaleDateString('en-US'),
        ],
        timeSlots: [
            "08:00", "09:00", "10:00", "11:00", "12:00",
            "13:00", "14:00", "15:00", "16:00", "17:00"
        ],
        availableSlots: [],
        loading: false,
        error: null,
    }),
    getters: {
        fullAppointmentTime: (state) => {
            if (!state.selectedDate || !state.selectedTime) return null;
            const dateTime = new Date(state.selectedDate);
            const [hours, minutes] = state.selectedTime.split(':');
            dateTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
            return dateTime.toISOString();
        },
    },
    actions: {
        setSelectedDate(date) {
            this.selectedDate = date;
            // console.log(this.selectedDate)
        },
        setSelectedTime(time) {
            this.selectedTime = time;
            //alert(this.selectedTime);
        },
        // setSelectedDate(date) {
        //     this.selectedDate = date;
        // }

        async fetchAvailableSlots(doctorId, date) {
            this.loading = true;
            this.error = null;
            this.availableSlots = [];

            try {
                const response = await axios.put(`/api/bookings/checkAvailability/${doctorId}`, {
                    appointment_time: date,
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });

                if (response.data.results) {
                    this.availableSlots = response.data.available_slots;
                } else {
                    this.error = response.data.error;
                }
            } catch (err) {
                this.error = err.response?.data?.error || 'Failed to fetch available slots';
            } finally {
                this.loading = false;
            }
        },

        clearError() {
            this.error = null;
        },
    }
});