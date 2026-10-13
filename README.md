# CarePulse AI – Intelligent Telehealth & Smart Hospital Platform

[![PHP 8](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![MySQL 8](https://img.shields.io/badge/MySQL-8.0%20%2F%20MariaDB-orange.svg)](https://mysql.com)
[![Python Scikit-Learn](https://img.shields.io/badge/Python-Scikit--learn%20v1.6-green.svg)](https://scikit-learn.org)
[![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)](https://getbootstrap.com)
[![WebRTC](https://img.shields.io/badge/Telemedicine-WebRTC-red.svg)](#)
[![License](https://img.shields.io/badge/License-MIT-teal.svg)](#)

CarePulse AI is a complete, production-ready, AI-powered healthcare web application that combines Artificial Intelligence, Telemedicine, Secure Online Payments, Smart Queue Prediction, Digital Prescriptions, and Predictive Hospital Analytics.

---

## 🌐 Application Access URL

The entire platform and all portals are accessible from the primary project entry point:

**`http://localhost/carepulse-ai/`**

The homepage features a centralized **Platform Command Center** providing direct navigation to:
1. **Patient Portal**
2. **AI Symptom Checker**
3. **Book Appointment**
4. **Online Consultation (Telemedicine Hub)**
5. **Doctor Login**
6. **Admin Dashboard**

---

## 🔑 Demo Login Accounts

Pre-configured credentials for all three user roles (all use the same password):

| Role | Email | Password | Primary Capabilities |
| :--- | :--- | :--- | :--- |
| **Hospital Administrator** | `admin@carepulse.ai` | `Password@123` | ML OPD Inflow Predictor, 4 Chart.js Visualizations, Consultation Funnel, Cancellation Telemetry |
| **Doctor (Specialist)** | `doctor.sharma@carepulse.ai` | `Password@123` | OPD Queue Desk, WebRTC Video Suite, Live Clinical Notes, Digital Rx Generator |
| **Patient** | `patient@carepulse.ai` | `Password@123` | AI Symptom Checker, ACID Slot Booking, Fast Checkout, Queue Tracker, Medical Record Vault |

*(1-click demo login buttons are also provided directly on the homepage and login screen for rapid evaluation.)*

---

## 🏗️ 9 Core Production Modules

### Module 1: AI Clinical Symptom Checker
- **Scikit-learn Natural Language Processing Engine**: TF-IDF Vectorizer with Calibrated Multi-class Logistic Regression trained on multi-specialty clinical symptoms.
- **Output Format**: Displays predicted department (**Cardiology**, **Neurology**, **Orthopedics**, **Dermatology**, **General Medicine**, **Pediatrics**, **Psychiatry**, **ENT**), confidence percentage, clinical urgency level, recommended top doctors, and real-time available consultation slots.
- **Audit Logging**: Saves triage results to patient symptom history with instant slot booking transition.

### Module 2: Smart Appointment Booking
- **Consultation Modes**: In-Hospital Physical Visit or Online HD Video Consultation.
- **Real-Time Doctor Availability & ACID Transactional Locking**: Uses `SELECT ... FOR UPDATE` database locking to prevent concurrent double-booking.
- **Dynamic Slot Generation**: Automatically evaluates doctor practice hours and reserved slots to prevent scheduling conflicts.
- **Unique Queue Tokens**: Allocates sequential daily queue numbers and human-readable appointment codes.

### Module 3: Online Payment Gateway & Invoicing
- **Multi-Method Gateway**: Supports **UPI** (Dynamic QR & Virtual Payment Address), **Credit/Debit Cards** (with Luhn format validation), and **Net Banking**.
- **Payment Verification**: Confirms appointment status immediately upon payment settlement.
- **Printable Invoices**: Generates digital receipts with transaction hashes, timestamps, and hospital billing details.

### Module 4: Smart Queue & Dynamic Wait-Time Prediction
- **Adaptive Estimation Algorithm**: Computes real-time estimated wait time:
  $$\text{Wait Time} = (\text{Queue Position} - \text{Current Serving Token}) \times \text{Doctor Consult Speed} \times \text{Delay Factor}$$
- **Real-Time Polling**: Live status displays currently serving token number, patients ahead, and progress bar.

### Module 5: WebRTC Telemedicine Suite
- **Encrypted Video Room**: Zero-install browser-based video consultation with camera toggle, microphone mute, and screen sharing.
- **In-Call Communication**: Real-time live text chat and doctor clinical scratchpad with auto-saving notes.
- **Clinical Handover**: Seamless transition to digital prescription generation upon session conclusion.

### Module 6: Digital Prescription & Medical Records Vault
- **Clinical Prescription Builder**: Dosage scheduler with Morning/Afternoon/Night timeline and clinical instructions.
- **Formal Printable Format**: Clean hospital header, doctor qualification, diagnosis, Rx symbol, and digital signature.
- **Medical Records Vault**: Secure file uploads with **MIME validation (`finfo`)** and cryptographically randomized filenames for PDFs and imaging scans.

### Module 7: Medication Reminder Engine
- **Automated Scheduling**: Morning (08:00 AM), Afternoon (01:00 PM), and Night (08:30 PM) routines.
- **Multi-Channel Dispatch**: Notification dispatch engine supporting WhatsApp, SMS, and Email channels.
- **Simulation Console**: Includes interactive "Send Test Alert" tool for immediate verification.

### Module 8: Comprehensive Hospital Operational Analytics
- **Executive KPIs**: Registered patients, active specialists, scheduled consultations, and settled telehealth revenue.
- **Consultation Status Funnel**: 5-stage conversion pipeline tracking:
  $$\text{Booked} \longrightarrow \text{Confirmed/Checked-in} \longrightarrow \text{In Consultation} \longrightarrow \text{Completed} \longrightarrow \text{Prescriptions Issued}$$
- **Cancellation Rate Telemetry**: Tracks cancellation percentage benchmarked against industry standard (< 8.5%).
- **4 Chart.js Visualizations**:
  1. **Line Chart**: 30-Day Patient Volume Dynamics (Total Inflow vs Online vs Hospital)
  2. **Doughnut Chart**: Department-wise Consultation Share
  3. **Bar Chart**: Monthly Revenue & Inflow Comparison
  4. **Area Chart**: Patient Volume vs Doctor Roster Capacity Ceiling

### Module 9: Predictive Hospital Analytics (AI/ML)
- **Scikit-learn Machine Learning Model**: Trained `RandomForestRegressor` with 120 estimators achieving $R^2 = 0.927$ goodness of fit and $\text{MAE} \pm 5.49$ patients.
- **Features Evaluated**: Day of week, holiday flag, month, season, lag-1 visit count, and 7-day moving average.
- **Prominent UI Callouts**:
  - `Predicted Patients Tomorrow: <volume>` (with 95% confidence interval)
  - `Expected Peak Time: 10:00 AM – 01:00 PM`
  - `Highest Demand Department: Cardiology / General Medicine`
- **Required Doctor Allocation Table**: Departmental patient breakdown, required specialist count on duty, and staffing surge recommendations.

---

## 🔒 Security Standards Implemented

1. **Prepared SQL Statements (PDO)**: Every database query uses parameterized statements with emulated prepares disabled to prevent SQL injection.
2. **CSRF Tokens**: All mutating POST/AJAX requests validate unique cryptographic CSRF tokens transmitted via hidden fields or `X-CSRF-Token` headers.
3. **BCRYPT Password Hashing**: Passwords hashed with `PASSWORD_BCRYPT` (Cost 10).
4. **Email OTP Authentication**: 6-digit one-time verification passcodes with 10-minute expiry windows.
5. **Strict File MIME Validation**: File uploads validated using PHP `finfo` inspecting file headers directly (PDF, JPEG, PNG, WebP only).
6. **Cryptographic Filenames**: Uploads saved with `bin2hex(random_bytes(16))` filenames to eliminate path traversal vulnerabilities.
7. **Rate Limiting**: Built-in IP/Session rate limiters preventing brute-force password and OTP guessing.

---

## 🚀 Running the Platform

1. **Start Services**:
   Run `run.bat` in the project directory, which starts MariaDB (Port 3307) and Apache (Port 80) if not already active.
2. **Access the Application**:
   Open your web browser and navigate directly to:
   **`http://localhost/carepulse-ai/`**

## ☁️ Deploying the Landing Page to Vercel and the App to Render

The PHP application (including its interactive portals and API) runs on Render. Vercel serves a separate static landing page from `vercel-frontend/`; it links visitors to the Render application and does not run PHP or connect directly to the database.

### 1. Prepare a MySQL database

Create an externally hosted MySQL 8 or MariaDB database that accepts connections from Render. Render's built-in database service is PostgreSQL and is not compatible with this application's MySQL schema. Keep the database host, port, name, username, and password for the Render environment settings.

Import `database/schema.sql` and then `database/seed.sql` into a **new, empty database**. The schema drops and recreates the application's tables. If your provider assigns a database name other than `carepulse_db`, update the `USE` statements in both SQL files to the assigned name before importing.

### 2. Deploy the PHP application on Render

1. In Render, create a **Blueprint** from this GitHub repository and apply `render.yaml`.
2. In the `carepulse-ai-backend` web service's environment settings, set `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASS` to the MySQL database values. The blueprint declares these variables; the secret password is entered in the Render dashboard.
3. Wait for the Docker build and deploy to finish, then open the service URL (the default service name maps to `https://carepulse-ai-backend.onrender.com` if that name is available).

The Docker image provides PHP 8.2 with PDO MySQL and Python/scikit-learn for the AI endpoints. Render's free web services can sleep when idle, and their local filesystem is ephemeral; uploaded medical records will not persist across restarts or deploys on that plan. Use persistent storage or external object storage before relying on uploads.

### 3. Deploy the static landing page on Vercel

1. Import the same GitHub repository as a new Vercel project.
2. Keep the project root at the repository root; `vercel.json` selects `vercel-frontend/` as the static output directory.
3. Deploy. Vercel will publish the static landing page at the project URL.

The landing page's app links point to `https://carepulse-ai-backend.onrender.com`. If Render assigns a different URL, replace that URL in `vercel-frontend/index.html` and redeploy Vercel.
