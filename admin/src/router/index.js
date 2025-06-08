import { createRouter, createWebHistory } from 'vue-router'
import loginView from '@/views/login.vue'
import dashboardView from '@/views/admin/dashboard.vue'
import calendarView from '@/views/admin/calendar.vue'
import appointmentView from '@/views/admin/appointment.vue'
import CreateService from '@/views/admin/service/CreateService.vue'
import serviceView from '@/views/admin/service/serviceView.vue'
import profileView from '@/views/admin/profileView.vue'
import doctorView from '@/views/admin/doctor/doctor.vue'
import doctorProfileView from '@/views/admin/doctor/doctorProfile.vue'
import listDoctorCalendar from '@/views/admin/doctor/listDoctorCalendar.vue'
import contactDetailView from '@/views/admin/contact/contactDetailView.vue'
import inspectAppoint from '@/views/admin/appointment/inspectAppoint.vue'
import contactView from '@/views/admin/contact/contactView.vue'
import patientView from '@/views/admin/patient/patientView.vue'
import ContentView from '@/views/admin/contentView.vue'
import serviceDetailView from '@/views/admin/service/serviceDetailView.vue'
import medicalRecordView from '@/views/medicalRecordView.vue'
const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'login',
			component: loginView,
			meta: {
				title: 'Login Page',
				body: 'Login page'
			}
		},
		{
			path: '/dashboard',
			name: 'dashboard',
			component: dashboardView,
			meta: {
				title: 'Dashboard Page',
				body: 'Welcome Back Admin!'
			}
		},
		{
			path: '/calendar',
			name: 'calendar',
			component: calendarView,
			meta: {
				title: 'Calendar Page',
				body: 'Appointment Calendar!'
			}
		},
		{
			path: '/appointment',
			name: 'appointment',
			component: appointmentView,
			meta: {
				title: 'Appointmnent Page',
				body: 'Welcome Back Admin!'
			}
		},
		{
			path: '/create-service',
			name: 'createService',
			component: CreateService,
			meta: {
				title: 'Create Service Page',
				body: 'Welcome Back Admin!'
			}
		},
		{
			path: '/service',
			name: 'service',
			component: serviceView,
			meta: {
				title: 'Create Service Page',
				body: 'Welcome Back Admin!'
			}
		},
		{
			path: '/service-detail',
			name: 'service-detail',
			component: serviceDetailView,
			meta: {
				title: 'Edit service',
				body: 'service detail!'
			}
		},
		{
			path: '/doctor',
			name: 'doctor',
			component: doctorView,
			meta: {
				title: 'Doctor Page',
				body: 'Doctor'
			}
		},
		{
			path: '/profile',
			name: 'profile',
			component: profileView,
			meta: {
				title: 'Doctor Page',
				body: 'Doctor'
			}
		},
		{
			path: '/doctor-profile',
			name: 'doctorprofile',
			component: doctorProfileView,
			meta: {
				title: 'Doctor profile',
				body: 'Doctor'
			}
		},
		{
			path: '/doctor-detail',
			name: 'listDoctorCalendar',
			component: listDoctorCalendar,
			meta: {
				title: 'Doctor detail',
				body: 'Doctor'
			}
		},
		{
			path: '/inspect-appointment',
			name: 'inspectAppoint',
			component: inspectAppoint,
			meta: {
				title: 'View detail',
				body: 'detail'
			}
		},
		{
			path: '/contact',
			name: 'contact',
			component: contactView,
			meta: {
				title: 'contact Page',
				body: 'account overview'
			}
		},
		{
			path: '/profile',
			name: 'profile',
			component: profileView,
			meta: {
				title: 'profile Page',
				body: 'account overview'
			}
		},
		{
			path: '/contact-detail',
			name: 'contact detail',
			component: contactDetailView,
			meta: {
				title: 'contact Page',
				body: 'contact'
			}
		},
		{
			path: '/content',
			name: 'content',
			component: ContentView,
			meta: {
				title: 'Article & Disease',
				body: 'Article & Disease'
			}
		},
		{
			path: '/patient-information',
			name: 'patient-information',
			component: patientView,
			meta: {
				title: 'Patient-information',
				body: 'Patient'
			}
		},
		{
			path: '/patient-medical-record',
			name: 'patient-medical-record',
			component: medicalRecordView,
			meta: {
				title: 'Patient-medical-record',
				body: 'medical record'
			}
		},
	],
})
router.beforeEach((to, from, next) => {
	document.title = to.meta.title || 'VCS';
	next();
});

export default router
