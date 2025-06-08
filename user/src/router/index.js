import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import articleView from '@/views/article/article.vue'
import articleDetailView from '@/views/article/article-detail.vue'
import findArticleView from '@/views/article/find-article.vue'
import RegisterView from '@/views/Auth/RegisterView.vue'
import LoginView from '@/views/Auth/LoginView.vue'
import Forgetpassword from '@/views/Auth/forgetpassword.vue'
import Find_doctor from '@/views/doctor/Find_doctor.vue'
import doctor_profile from '@/views/doctor/doctor_profile.vue'
import profilesetting from '@/views/setting/profilesetting.vue'
import account from '@/views/setting/account.vue'
import patientinfo from '@/views/setting/patientinfo.vue'
import appointment from '@/views/setting/appointment.vue'
import save from '@/views/setting/save.vue'
import packageDetailView from '@/views/package/PackageDetailView.vue'
import BookAppointment from '@/views/booking/bookAppointment.vue'
import BackToTop from '@/components/layouts/backToTop.vue'
import packagee from '@/views/package/package.vue'
import findDisease from '@/views/article/findDisease.vue'
import notification from '@/views/notification/notification.vue'
import contact from '@/views/contact.vue'
import aboutus from '@/views/aboutus.vue'
import transportation from '@/views/transportation.vue'
import invoiceView from '@/views/invoiceView.vue'
import medicalRecordView from '@/views/medicalRecordView.vue'
import medicalRecord from '@/views/setting/medicalRecord.vue'
import chatView from '@/views/chatView.vue'
import loadingView from '@/views/loading/loadingView.vue'
import policyPrivacy from '@/views/policyPrivacy.vue'
const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'HomeView',
			component: HomeView,
			meta: {
				title: 'Home - VechchSal'
			}
		},
		{
			path: '/article',
			name: 'article',
			component: articleView,			
			meta: {
				title: 'Article - VechchSal'
			}
		},
		{
			path: '/article_detail/:id',
			name: 'article_detail',
			component: articleDetailView,
			meta: {
				title: 'ArticleDetail - VechchSal'
			}
		},
		{
			path: '/findArticle',
			name: 'findArticle',
			component: findArticleView,
			meta: {
				title: 'FindArticle - VechchSal'
			}
		}, {
			path: '/forgetpassword',
			name: 'Forgetpassword',
			component: Forgetpassword,
			meta: {
				title: 'ForgotPassword - VechchSal'
			}
		},
		{
			path: '/register',
			name: 'register',
			component: RegisterView,
			meta: {
				title: 'Register - VechchSal'
			}
		},
		{
			path: '/login',
			name: 'login',
			component: LoginView,
			meta: {
				title: 'LogIn - VechchSal'
			}
		},
		{
			path: '/finddoctor',
			name: 'finddoctor',
			component: Find_doctor,
			meta: {
				title: 'FindDoctor - VechchSal'
			}
		},
		{
			path: '/doctorprofile/:id',
			name: 'doctorprofile',
			component: doctor_profile,
			meta: {
				title: 'DoctorProfile - VechchSal'
			}
		},
		{
			path: '/profilesetting',
			name: 'profilesetting',
			component: profilesetting,
			meta: {
				title: 'Setting - VechchSal'
			}
		},
		{
			path: '/account',
			name: 'account',
			component: account,
			meta: {
				title: 'Dashboard - VechchSal'
			}
		},
		{
			path: '/patientinfo',
			name: 'patientinfo',
			component: patientinfo,
			meta: {
				title: 'No - VechchSal'
			}
		},
		{
			path: '/appointment',
			name: 'appointment',
			component: appointment,
			meta: {
				title: 'Appointment - VechchSal'
			}
		},
		{
			path: '/save',
			name: 'save',
			component: save,
			meta: {
				title: 'Save - VechchSal'
			}
		},
		{
			path: '/packagedetail',
			name: 'PackageDetail',
			component: packageDetailView,
			meta: {
				title: 'PackageDetail - VechchSal'
			}
		},
		{
			path: '/book-appointment',
			name: 'bookAppointment',
			component: BookAppointment,
			meta: {
				title: 'BookAppointment - VechchSal'
			}
		},
		{
			path: '/package',
			name: 'package',
			component: packagee,
			meta: {
				title: 'Package - VechchSal'
			}
		},
		{
			path: '/backToTop',
			name: 'backToTop',
			component: BackToTop,
		},
		{
			path: '/findDisease',
			name: 'findDisease',
			component: findDisease,
			meta: {
				title: 'FindDisease - VechchSal'
			}
		},
		{
			path: '/notification',
			name: 'notification',
			component: notification,
			meta: {
				title: 'Notification - VechchSal'
			}
		},
		{
			path: '/contact',
			name: 'contact',
			component: contact,
			meta: {
				title: 'ContactUs - VechchSal'
			}
		},
		{
			path: '/aboutus',
			name: 'aboutus',
			component: aboutus,
			meta: {
				title: 'AboutUs - VechchSal'
			}
		},
		{
			path: '/transportation',
			name: 'transportation',
			component: transportation,
			meta: {
				title: 'Transportation - VechchSal'
			}
		},
		{
			path: '/invoice',
			name: 'invoice',
			component: invoiceView,
			meta: {
				title: 'Invoice - VechchSal'
			}
		}, 
		{
			path: '/medical-record',
			name: 'medical-record',
			component: medicalRecordView,
			meta: {
				title: 'MedicalRecord - VechchSal'
			}
		},
		{
			path: '/medical-record-setting',
			name: 'medicalRecordSetting',
			component: medicalRecord,
			meta: {
				title: 'RecordSetting - VechchSal'
			}
		}, 
		{
			path: '/chat',
			name: 'chat',
			component: chatView,
			meta: {
				title: 'PackageDetail - VechchSal'
			}
		}, 
		{
			path: '/policyPrivacy',
			name: 'policyPrivacy',
			component: policyPrivacy,
			meta: {
				title: 'Policy&Privacy - VechchSal'
			}
		},
	],
})
router.beforeEach((to, from, next) => {
	document.title = to.meta.title || 'Your Default Title';
	next();
});


export default router
