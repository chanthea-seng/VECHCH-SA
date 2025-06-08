<template>
  <main class="policyPrivacy">
    <Navbar />
    <section>
      <div class="container m-auto">
        <div class="row d-flex align-items-center justify-content-center">
          <div class="col-10">
            <h2 class="text-center title my-4">Privay Policy</h2>
            <span>
              Welcome to Vechch Sal. We are committed to protecting your privacy
              and ensuring that your personal information is handled in a safe
              and responsible manner. This Privacy Policy outlines how we
              collect, use, disclose, and safeguard your information when you
              visit our website.
            </span>
            <div class="mt-2">
              <span class="list-title"> 1. Introduction </span><br />
              Vechchsal Hospital and its affiliated entities (hereinafter
              referred to as the “Hospital” or “we”, as the case may be) are
              committed to providing high-quality medical care through
              accredited facilities and specialized healthcare services. As the
              data controller under applicable personal data protection laws, we
              are fully aware of the importance of safeguarding the personal
              data of our patients, contacts, emergency contacts, and anyone
              interacting with the Hospital (collectively referred to as “you”
              or “Data Subject”). We hereby announce this Privacy Notice
              (“Notice”) to inform you of how your personal data is collected,
              used, disclosed, and/or transferred (“processed”) and the steps we
              take to ensure its protection. We will only process your data for
              the purposes stated in this Notice unless you provide additional
              consent.
            </div>
            <div class="my-2">
              <span class="list-title"> 2. Definitions </span><br />
              "Personal Data" means any information that identifies or can be
              used to identify you, as collected by the Hospital under this
              Notice. "Sensitive Data" refers to data classified as sensitive
              under applicable law, such as health information, religious
              beliefs, biometric data, and others, which we will only process
              with your explicit consent or under legal allowances.
            </div>
            <div class="my-2">
              <span class="list-title">
                3. Personal Data Collected by the Hospital 3.1 General Personal
                Data </span
              ><br />
              This may include:
              <ul>
                <li>
                  Personal information (e.g., name, gender, date of birth,
                  nationality, identification numbers)
                </li>
                <li>
                  Contact details (e.g., mobile number, email address, physical
                  address)
                </li>
                <li>
                  Medical service usage (e.g., appointment records, treatment
                  history, room or service preferences)
                </li>
                <li>Educational and legal document data</li>
                <li>Emergency contact details</li>
                <li>
                  Financial information (e.g., billing records, bank account,
                  payment data)
                </li>
                <li>CCTV footage and audio recordings for security</li>
              </ul>
            </div>
            <div class="my-2">
              <span class="list-title"> 3.2 Sensitive Data </span><br />
              This may include health-related data such as medical records,
              allergies, diagnoses, lab results, genetic and biometric data, and
              surgical images or video.
            </div>
            <div class="my-2">
              <span class="list-title"> 4. Source of Your Personal Data </span
              ><br />
              We may collect your personal data directly via forms, apps, our
              website, or indirectly through family members, referrals, or
              partner hospitals and providers.
            </div>
            <div class="my-2">
              <span class="list-title">
                5. Disclosure of Your Personal Data </span
              ><br />
              Your data may be disclosed to authorized personnel, service
              providers, insurers, healthcare professionals, auditors, IT
              providers, and regulatory authorities. International transfers may
              occur with proper safeguards. Disclosure will only be for purposes
              stated herein or as legally required.
            </div>
            <div class="my-2">
              <span class="list-title">
                6. Collection of Personal Data from Minors and Others </span
              ><br />
              Where applicable, consent will be required from a parent or legal
              guardian for processing data of minors or legally dependent
              persons.
            </div>
            <div class="my-2">
              <span class="list-title"> 7. Data Subject’s Rights </span><br />
              You may:
              <ul>
                <li>Request access or correction of your data</li>
                <li>Request data transfer or deletion</li>
                <li>Object to or restrict processing</li>
                <li>Withdraw consent (where applicable)</li>
                <li>File a complaint with a supervisory authority</li>
              </ul>
            </div>
            <div class="my-2">
              <span class="list-title"> 7. Contact Us </span><br />
              If you have questions, wish to exercise your rights, or need more
              information, please contact:
              <br /><span class="list-title" style="font-size: 16px"
                >Vechchsal Hospital</span
              >
              <br />54 Street 606, Phnom Penh, Cambodia <br /><span
                class="list-title"
                style="font-size: 16px"
                >Data Protection Officer</span
              ><br />
              vechchsalHospital@gmail.com <br />
              +855 987654321
            </div>
          </div>
          <!-- <div class="policyHr"></div> -->
        </div>
      </div>
    </section>
    <FooterView />
  </main>
</template>

<script setup>
import loadingView from "./loading/loadingView.vue";
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import { appointmentStore } from "@/stores/appointmentstore";
import { computed, onMounted } from "vue";
import axios from "axios";
</script>
