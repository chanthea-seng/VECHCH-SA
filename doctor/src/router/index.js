import { createRouter, createWebHistory } from 'vue-router'
import articleView from '@/views/article/articleView.vue'
import postArticle from '@/views/article/postArticleView.vue'
import chatView from '@/views/chatView.vue'
import calendarView from '@/views/calendarView.vue'
import loginView from '@/views/loginView.vue'
import dashboardView from '@/views/dashboardView.vue'
import appointmentDetailView from '@/views/appointmentDetailView.vue'
import chooseContent from '@/views/article/chooseContent.vue'
import prescriptionView from '@/views/prescriptionView.vue'
import accountSettingView from '@/views/accountSettingView.vue'
import patientView from '@/views/patientView.vue'
import medicalRecordView from '@/views/medicalRecordView.vue'
const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'login',
			component: loginView,
			meta: {
				title: 'ចូលគណនី',
				title_page: 'Login - VechchSal'
			}
		},
		{
			path: '/dashboard',
			name: 'dashboard',
			component: dashboardView,
			meta: {
				title: 'ទិដ្ឋភាពទូទៅ',
				title_page: 'Dashboard - VechchSal'
			}
		},
		{
			path: '/article',
			name: 'article',
			component: articleView,
			meta: {
				title: 'អត្ថបទ',
				title_page: 'Article - VechchSal'
			}
		},
		{
			path: '/postarticle',
			name: 'postarticle',
			component: postArticle,
			meta: {
				title: 'សរសេរអត្ថបទ',
				title_page: 'Post Article - VechchSal'
			}
		},
		{
			path: '/chooseContent',
			name: 'Content',
			component: chooseContent,
			meta: {
				title: 'ជ្រើសរើសអត្ថបទមាតិកា',
				title_page: 'Choose Content - VechchSal'
			}
		},
		{
			path: '/chat',
			name: 'chat',
			component: chatView,
			meta: {
				title: 'ផ្ញើរសារ',
				title_page: 'Chat - VechchSal'
			}
		},
		{
			path: '/calendar',
			name: 'calendar',
			component: calendarView,
			meta: {
				title: 'កាលវិភាគ',
				title_page: 'Calendar - VechchSal'
			}
		},
		{
			path: '/appointment-detail',
			name: 'appointment-detail',
			component: appointmentDetailView,
			meta: {
				title: 'ព័ត៌មានលម្អិតនៃការណាត់ជួប',
				title_page: 'Appointment Detail - VechchSal'
			}
		},
		{
			path: '/medical-record',
			name: 'medical-record',
			component: prescriptionView,
			meta: {
				title: 'វេជ្ជបញ្ជា',
				title_page: 'Write Medical - VechchSal'

			}
		},
		{
			path: '/patient',
			name: 'patient',
			component: patientView,
			meta: {
				title: 'ព័ត៌មានអ្នកជំងឺ',
				title_page: 'Patient - VechchSal'
			}
		},
		{
			path: '/accountSetting',
			name: 'accountSetting',
			component: accountSettingView,
			meta: {
				title: 'គ្រប់គ្រងគណនី',
				title_page: 'Account - VechchSal'
			}
		},
		{
			path: '/medicaldetail',
			name: 'medicalRecordView',
			component: medicalRecordView,
			meta: {
				title: 'កំណត់ត្រាវេជ្ជសាស្រ្ត',
				title_page: 'Medical Record - VechchSal'

			}
		},

	],
})
router.beforeEach((to, from, next) => {
	document.title = to.meta.title_page || 'VCS';
	next();
});
export default router
