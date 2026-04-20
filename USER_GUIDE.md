# 📘 TaskFlow — User Guide (Gabay sa Paggamit)

> **Movaflex Task Manager (TaskFlow)**
> Petsa: April 13, 2026

---

## 📋 Talaan ng Nilalaman

1. [Pag-login sa System](#1-pag-login-sa-system)
2. [Dashboard (Main Screen)](#2-dashboard-main-screen)
3. [Navigation — Sidebar at Navbar](#3-navigation--sidebar-at-navbar)
4. [Dark Mode (Madilim na Tema)](#4-dark-mode-madilim-na-tema)
5. [Tasks — Pamamahala ng Gawain](#5-tasks--pamamahala-ng-gawain)
6. [Kanban Board](#6-kanban-board)
7. [Task Calendar](#7-task-calendar)
8. [Projects — Pamamahala ng Proyekto](#8-projects--pamamahala-ng-proyekto)
9. [Notifications — Mga Abiso](#9-notifications--mga-abiso)
10. [Email Alerts — Paalala sa Deadline](#10-email-alerts--paalala-sa-deadline)
11. [Group Chat](#11-group-chat)
12. [Reports — Mga Ulat](#12-reports--mga-ulat)
13. [Audit Logs — Talaan ng Aktibidad](#13-audit-logs--talaan-ng-aktibidad)
14. [Admin Panel — Para sa Administrator](#14-admin-panel--para-sa-administrator)
15. [Mga Role at Permissions](#15-mga-role-at-permissions)
16. [FAQ — Mga Madalas na Tanong](#16-faq--mga-madalas-na-tanong)

---

## 1. Pag-login sa System

### Paano mag-log in:
1. Buksan ang browser at pumunta sa **https://taskmanagement.test**
2. Ilalagay sa **Login Page**:
   - **Work Email** — ang iyong email address
   - **Password** — ang iyong password
3. I-check ang **"Keep me signed in"** kung gusto mong hindi ka agad ma-logout
4. I-click ang **"Log in"** button

### Pag nag-expire ang session:
- Automatic kang ire-redirect sa login page
- I-login mo ulit ang iyong account

### Pag nakalimutan ang password:
- I-contact ang Administrator para ma-reset ang iyong password

---

## 2. Dashboard (Main Screen)

Pagkatapos mag-login, makikita mo ang **Dashboard** — ang iyong main overview ng lahat ng gawain.

### KPI Cards (Mga Numero sa Itaas):
| Card | Ibig Sabihin |
|------|-------------|
| **Active Projects** | Bilang ng mga aktibong proyekto |
| **My Tasks** | Bilang ng mga task na naka-assign sa iyo |
| **Pending Review** | Mga task na naghihintay ng approval |
| **Overdue** | Mga task na lagpas na sa deadline |

### Charts:
- **Task Status Overview** — Pie/donut chart na nagpapakita kung ilan ang todo, in progress, for review, at done
- **Tasks Over Time** — Line chart na nagpapakita ng trend ng tasks sa mga nakaraang araw

### Sidebar (Kaliwang Panel):
- Listahan ng mga navigation links
- Pwedeng i-collapse (paliitin) o i-expand (palakihin) gamit ang toggle button

### Recent Activity:
- Makikita ang mga pinakabagong pagbabago sa tasks at projects

---

## 3. Navigation — Sidebar at Navbar

### Top Navbar (Itaas na Bar):
| Icon/Link | Gamit |
|-----------|-------|
| **Dashboard** | Bumalik sa main dashboard |
| **Projects** | Pumunta sa listahan ng projects |
| **Task Manager** | Pumunta sa listahan ng lahat ng tasks |
| **Kanban** | Pumunta sa Kanban board view |
| **Audit Logs** | Pumunta sa activity log table |
| 🌙 / ☀️ **Dark Mode** | I-toggle ang madilim/maliwanag na tema |
| 🔔 **Bell Icon** | Mga notifications (may red dot kung may bago) |
| ✉️ **Mail Icon** | Email Alerts — tignan ang deadline warnings |
| 💬 **Chat Icon** | Buksan ang Group Chat panel |
| 👤 **Profile** | Dropdown — Logout option |

### Sidebar Links (Kaliwa):
- Dashboard
- Projects
- Task Manager
- Kanban Board
- Calendar
- Notifications
- Reports *(para sa Manager/Lead/Admin)*
- Admin Panel *(para sa Admin lang)*

---

## 4. Dark Mode (Madilim na Tema)

### Paano gamitin:
1. Sa **top navbar**, hanapin ang **moon icon** 🌙 (o sun icon ☀️ kung dark mode na)
2. **I-click** ito para mag-toggle
3. Agad magbabago ang kulay ng buong website
4. **Naka-save** ang preference mo — kahit mag-refresh, nandoon pa rin ang pinili mong tema

---

## 5. Tasks — Pamamahala ng Gawain

### 5.1 Paano Mag-create ng Task:
1. Pumunta sa **Task Manager** page
2. I-click ang **"Create Task"** button
3. Punan ang mga field:
   - **Title** — Pangalan ng task
   - **Description** — Detalye ng gagawin
   - **Project** — Piliin kung saang project
   - **Assignees** — Piliin sino ang gagawa (pwedeng marami)
   - **Priority** — Low, Medium, High, o Urgent
   - **Due Date** — Deadline ng task
4. I-click **"Save"** o **"Create"**

### 5.2 Task Status Flow:
```
Todo → In Progress → For Review → Done
                  ↕
               Blocked
```

| Status | Ibig Sabihin |
|--------|-------------|
| **Todo** | Bagong gawa, hindi pa sinimulan |
| **In Progress** | Ginagawa na |
| **Blocked** | Hindi maipagpatuloy (may hadlang) |
| **For Review** | Tapos na, naghihintay ng approval |
| **Done** | Approved at kumpleto na |

> ⚠️ **Tandaan:** Ang **"For Review → Done"** ay mga **Lead, PM, o Admin** lang ang pwedeng mag-approve.

### 5.3 Task Features:
- **Attachments** — Mag-upload ng files (documents, images)
- **Checklists** — Mag-add ng sub-tasks/checklist items sa loob ng task
- **Time Tracking** — I-start/stop ang timer para ma-track ang oras na ginugol
- **Comments** — Mag-iwan ng comment para sa discussion sa team
- **Activity Log** — Makikita ang lahat ng pagbabago sa task

### 5.4 Paano Mag-edit ng Task:
1. Sa Task Manager list, i-click ang task na gusto mong i-edit
2. I-click ang **"Edit"** button
3. Baguhin ang mga kailangan
4. I-click **"Save/Update"**

---

## 6. Kanban Board

### Ano ang Kanban:
Visual na board na may mga columns para sa bawat status ng task.

### Paano Gamitin:
1. Pumunta sa **Kanban** sa navbar o sidebar
2. Makikita ang 4 na columns:
   - **Todo** | **In Progress** | **For Review** | **Done**
3. **Drag and Drop** — I-drag ang task card papunta sa ibang column para baguhin ang status
4. **I-click ang task card** para makita ang buong detalye
5. Pwede rin mag-filter ayon sa:
   - Project
   - Assignee
   - Priority

---

## 7. Task Calendar

### Paano Gamitin:
1. Pumunta sa **Calendar** sa sidebar
2. Makikita ang mga tasks na naka-plot ayon sa **deadline date**
3. Useful para makita kung may **overload** sa specific dates
4. I-click ang araw para makita ang mga task na due sa petsa na iyon

---

## 8. Projects — Pamamahala ng Proyekto

### 8.1 Paano Mag-create ng Project:
1. Pumunta sa **Projects** page
2. I-click ang **"Create Project"** button
3. Punan ang:
   - **Name** — Pangalan ng project
   - **Description** — Detalye ng project
4. I-click **"Save"**

### 8.2 Paano Mag-add ng Members:
1. Buksan ang project
2. Hanapin ang **Members** section
3. I-add ang mga team member na kasali sa project

### 8.3 Project Progress:
- May **progress bar** na nagpapakita ng overall completion
- Based sa bilang ng **Done** tasks vs total tasks

> ⚠️ **Note:** Ang mga **Member/Employee** ay makikita lang ang tasks sa projects kung saan sila naka-assign.

---

## 9. Notifications — Mga Abiso

### In-App Notifications:
1. I-click ang **🔔 Bell Icon** sa navbar
2. Makikita ang listahan ng notifications:
   - Task assignments
   - Status changes
   - New comments
   - Deadline warnings
3. May **red dot** kung may unread notifications
4. I-click ang **"Mark as Read"** sa bawat notification
5. O i-click ang **"Mark All as Read"** para i-clear lahat

### Auto-Refresh:
- Ang notifications ay automatic na nagre-refresh every **15 seconds**
- Hindi kailangan mag-refresh ng page

---

## 10. Email Alerts — Paalala sa Deadline

### Awtomatikong Email Alerts:
Ang system ay nagpapadala ng **daily email alerts** tuwing **8:00 AM** para sa mga tasks na malapit na o lagpas na sa deadline.

### Alert Levels:
| Level | Ibig Sabihin |
|-------|-------------|
| ⚠️ **Warning** | May 7 araw pa bago ang deadline |
| 🔴 **Critical** | May 3 araw na lang |
| 📌 **Reminder** | Due date ngayon! |
| ❗ **Overdue** | Lampas na sa deadline |

### Email Alerts Page:
1. I-click ang **✉️ Mail Icon** sa navbar
2. Makikita ang:
   - Sino ang padadalhan ng email (To, CC, BCC)
   - Listahan ng tasks per alert level
   - Status ng bawat task

---

## 11. Group Chat

### Paano Gamitin:
1. I-click ang **💬 Chat Icon** sa navbar
2. Mag-bubukas ang **chat panel** sa kanang bahagi
3. I-type ang message sa input field
4. Pindutin ang **Enter** o **Send** button
5. Makikita ang lahat ng messages ng team

### Features:
- **Real-time polling** — Automatic na nagre-refresh every 3 seconds
- **Unread dot** — May notification dot kung may bagong message habang nakaclose ang panel
- Makikita ang pangalan at oras ng bawat message

---

## 12. Reports — Mga Ulat

> *(Available para sa Lead, PM, at Admin)*

### Mga Uri ng Reports:
| Report | Laman |
|--------|-------|
| **Overdue Report** | Lahat ng tasks na lagpas na sa deadline |
| **Overdue by Assignee** | Breakdown ng overdue per team member |
| **Completed Tasks** | Listahan ng lahat ng natapos na tasks |
| **Cycle Time** | Gaano katagal bago natapos ang bawat task |

### Paano Gamitin:
1. Pumunta sa **Reports** sa sidebar
2. Piliin ang uri ng report
3. Pwedeng i-**export** bilang:
   - **CSV** — Para i-open sa Excel
   - **PDF** — Para i-print o i-share

---

## 13. Audit Logs — Talaan ng Aktibidad

### Ano ang Audit Logs:
Kompletong talaan ng lahat ng aksyon na ginawa sa system — sino, ano, kailan.

### Paano Tingnan:
1. Pumunta sa **Audit Logs** sa navbar
2. Makikita ang table na may mga columns:
   - **User** — Sino ang gumawa
   - **Action** — Ano ang ginawa (created, updated, deleted, etc.)
   - **Type** — Anong uri (task, project, etc.)
   - **Reference** — Pangalan ng affected item
   - **Details** — Mga specific na pagbabago
   - **Date** — Kailan ginawa
   - **IP** — IP address ng user
3. May **pagination** — 10 entries per page

---

## 14. Admin Panel — Para sa Administrator

> *(Admin role lang ang may access dito)*

### 14.1 User Management:
1. Pumunta sa **Create User** sa navbar (Admin only)
2. Punan ang details:
   - Name, Email, Password
   - **Role:** Admin, PM, Lead, o Member
3. I-save ang bagong user

### 14.2 System Configuration:
1. Pumunta sa **Admin → Configuration**
2. Mga settings na pwedeng baguhin:

| Setting | Paliwanag |
|---------|-----------|
| **Logo Upload** | Palitan ang logo ng company |
| **Companies** | I-manage ang mga companies/divisions |
| **Processes** | I-define ang business processes |
| **Teams** | Gumawa o mag-edit ng mga team |
| **System Announcement** | Maglagay ng announcement banner para sa lahat |
| **Personal Alert Email** | Sino ang padadalhan ng task alerts |
| **Daily Report Recipients** | Sino ang makakatanggap ng daily report |
| **Deadline Alert BCC** | Archive email para sa compliance |

### 14.3 Chatbot Knowledge Base:
1. Pumunta sa **Admin → Chatbot Knowledge**
2. Mag-add ng Q&A entries (English at Filipino)
3. Ang mga ito ay gagamitin ng built-in help chatbot

---

## 15. Mga Role at Permissions

### Apat na Uri ng User:

| Role | Paliwanag |
|------|-----------|
| **Member (Employee)** | Regular na user — gumagawa ng sariling tasks |
| **Lead (Team Lead)** | Nag-a-approve ng tasks, gumagawa ng projects |
| **PM (Project Manager)** | Namamahala ng maraming projects at teams |
| **Admin (Administrator)** | Full access — user management, system config |

### Detalyadong Permission Matrix:

| Aksyon | Member | Lead | PM | Admin |
|--------|--------|------|----|-------|
| Mag-login | ✅ | ✅ | ✅ | ✅ |
| Mag-view ng Dashboard | ✅ | ✅ | ✅ | ✅ |
| Gumawa ng Task | ✅ | ✅ | ✅ | ✅ |
| Mag-edit ng sariling Task | ✅ | ✅ | ✅ | ✅ |
| Mag-edit ng ibang Task | ❌ | ✅ | ✅ | ✅ |
| Mag-approve (For Review → Done) | ❌ | ✅ | ✅ | ✅ |
| Gumawa ng Project | ❌ | ✅ | ✅ | ✅ |
| Mag-delete ng Project | ❌ | ❌ | ❌ | ✅ |
| Mag-view ng Reports | Sarili lang | Team | Project | Lahat |
| Gumawa ng Meeting/Holiday | ❌ | ✅ | ✅ | ✅ |
| Mag-manage ng Users | ❌ | ❌ | ❌ | ✅ |
| Mag-access ng Admin Config | ❌ | ❌ | ❌ | ✅ |
| Gamitin ang Group Chat | ✅ | ✅ | ✅ | ✅ |
| Mag-upload ng Attachments | ✅ | ✅ | ✅ | ✅ |
| Mag-view ng Audit Logs | ✅ | ✅ | ✅ | ✅ |

---

## 16. FAQ — Mga Madalas na Tanong

### Q: Paano ko babaguhin ang password ko?
**A:** Pwede mong palitan ang iyong password mag-isa:
1. I-click ang iyong **profile/name** sa kanang itaas ng navbar
2. I-click ang **"Account Settings"**
3. Hanapin ang **"Update Password"** section
4. Ilagay ang iyong **Current Password** (kasalukuyang password)
5. Ilagay ang **New Password** at **Confirm Password**
6. I-click ang **"Update Password"** button
7. Lalabas ang "Saved successfully" kapag na-update na

### Q: Bakit hindi ko makita ang isang project?
**A:** Kailangan kang ma-add bilang member ng project. Humingi sa Lead o PM mo.

### Q: Paano ko ire-assign ang task sa iba?
**A:** Buksan ang task → Edit → Palitan ang Assignee → Save.

### Q: Paano ko malalaman kung may overdue na task ako?
**A:** Tignan ang **Overdue** count sa Dashboard card, o mag-check ng email alerts tuwing umaga.

### Q: Bakit hindi ako makapag-approve ng task (For Review → Done)?
**A:** Ang feature na ito ay para sa **Lead, PM, o Admin** lang. Kung Member ka, humingi ng approval sa iyong lead.

### Q: Paano gamitin ang Kanban?
**A:** Drag and drop ang task card sa tamang column (Todo → In Progress → For Review → Done).

### Q: Paano mag-export ng report?
**A:** Pumunta sa Reports → Piliin ang report → I-click ang **CSV** o **PDF** button.

### Q: Hindi nagana ang Dark Mode?
**A:** I-click ang moon/sun icon sa navbar. Kung hindi pa rin, i-clear ang browser cache at i-refresh.

### Q: Hindi ko naririnig ang chat notifications?
**A:** Automatic na may red dot sa chat icon kapag may bagong message. Buksan ang chat panel para makita.

### Q: Paano ko makikita ang history ng isang task?
**A:** Buksan ang task → Hanapin ang **Activity/Timeline** section para makita ang lahat ng pagbabago.

### Q: Paano mag-upload ng file/attachment sa task?
**A:** Buksan ang task → Hanapin ang **Attachments** section → I-click ang upload button → Piliin ang file mula sa iyong computer → Automatic itong mase-save.

### Q: Paano mag-download ng attachment?
**A:** Buksan ang task na may attachment → I-click ang **Download** button o link sa tabi ng filename.

### Q: Paano mag-delete ng attachment?
**A:** Buksan ang task → Sa Attachments section, i-click ang **Delete** button sa tabi ng file na gusto mong tanggalin.

### Q: Paano gamitin ang Time Tracking sa task?
**A:** Buksan ang task → I-click ang **Start Timer** button para simulan. Kapag tapos ka na, i-click ang **Stop Timer**. Automatic na mare-record ang oras na ginugol mo.

### Q: Paano mag-add ng checklist items sa task?
**A:** Buksan ang task → Hanapin ang **Checklist** section → I-type ang item → I-click Add. Para markahan na tapos, i-check ang checkbox sa tabi.

### Q: Pwede bang mag-assign ng isang task sa maraming tao?
**A:** Oo! Sa Create o Edit Task, pwede kang pumili ng **multiple assignees**. Lahat sila makakakita ng task sa kanilang dashboard.

### Q: Paano ko malalaman kung sino ang nag-edit ng task?
**A:** Pumunta sa **Audit Logs** page o buksan ang task at tignan ang **Activity Log/Timeline** section — nakadocument doon ang bawat pagbabago kasama ang pangalan ng user.

### Q: Ano ang ibig sabihin ng "Blocked" status?
**A:** Ibig sabihin may hadlang at hindi maipagpatuloy ang task. Halimbawa: naghihintay ng approval mula sa client, kulang sa resources, o may dependency sa ibang task.

### Q: Paano ko babaguhin ang status ng task sa Kanban?
**A:** I-drag ang task card mula sa isang column (halimbawa "Todo") at i-drop sa gustong column (halimbawa "In Progress"). Automatic na magbabago ang status.

### Q: Paano mag-create ng Meeting?
**A:** Pumunta sa **Meetings** section (available sa Lead, PM, at Admin) → I-click **Create Meeting** → Punan ang details (title, date, time, participants) → Save.

### Q: Paano mag-create ng Holiday entry?
**A:** Pumunta sa **Holidays** section (available sa Lead, PM, at Admin) → I-click **Create Holiday** → Ilagay ang holiday name at date → Save. Makikita ito sa Calendar view.

### Q: Bakit hindi ko makita ang Reports page?
**A:** Ang Reports page ay para sa **Lead, PM, at Admin** roles lang. Kung Member/Employee ka, wala kang access sa reports. Humingi sa iyong manager kung kailangan mo ng data.

### Q: Paano ko malalaman kung may bago akong notification?
**A:** Tignan ang **🔔 Bell Icon** sa navbar — kung may **red dot**, ibig sabihin may unread notification ka. I-click ito para makita ang listahan.

### Q: Gaano kadalas nag-a-update ang notifications?
**A:** Automatic na nag-re-refresh ang notifications every **15 seconds** — hindi mo kailangang i-refresh ang page.

### Q: Gaano kadalas nag-a-update ang Group Chat?
**A:** Every **3 seconds** — halos real-time ang chat. Automatic na lumalabas ang mga bagong messages.

### Q: Paano ko maki-chat ang team ko?
**A:** I-click ang **💬 Chat Icon** sa navbar → Mag-bubukas ang panel sa kanan → I-type ang message → Pindutin Enter. Lahat ng naka-login na users makakakita ng messages.

### Q: Pwede bang i-cancel o i-delete ang isang task?
**A:** Depende sa iyong role. Ang **Lead, PM, at Admin** ang may karapatan mag-delete ng task. Ang Member ay pwede lang mag-edit ng sariling task.

### Q: Paano ko mababago ang aking profile o email?
**A:** I-click ang iyong **profile/name** sa navbar → **"Account Settings"** → Sa **"Profile Information"** section, pwede mong palitan ang iyong **Full Name**, **Email Address**, at **Profile Photo**. I-click **"Save Changes"** pagkatapos.

### Q: Ano ang "System Announcement" na lumalabas sa dashboard?
**A:** Ito ay mensahe mula sa Admin para sa lahat ng users — pwedeng updates, reminders, o importante na balita tungkol sa company o system.

### Q: Ano ang mangyayari pag nag-expire ang session ko?
**A:** Automatic kang ire-redirect sa **Login page**. Hindi mawawala ang iyong data — i-login mo lang ulit at pwede ka nang magpatuloy.

### Q: Paano mag-filter ng tasks sa Task Manager?
**A:** Sa Task Manager page, gamitin ang mga filter options sa itaas — pwede kang mag-filter ayon sa **Project**, **Status**, **Priority**, **Assignee**, o **Due Date**.

### Q: Paano ko malalaman ang performance ng team ko?
**A:** Pumunta sa **Reports** → Tignan ang **Cycle Time** report para malaman kung gaano katagal ang average na completion ng tasks. Pwede ring tignan ang **Overdue by Assignee** para malaman sino ang may pinaka-maraming overdue.

### Q: Paano ko mao-open ang sidebar kung naka-collapse?
**A:** I-click ang **arrow/toggle button** sa itaas ng sidebar area para i-expand ito. O i-click ulit para i-collapse.

### Q: Pwede bang gamitin ang system sa mobile phone?
**A:** Oo! Ang website ay **responsive** — automatic na mag-a-adjust ang layout para sa mobile. May **hamburger menu (☰)** sa itaas para ma-access ang navigation sa maliit na screen.

### Q: Ano ang Advanced Dashboard?
**A:** Extended version ng dashboard na may mas detalyadong analytics — trend analysis, team performance metrics, at iba pang advanced KPIs. Accessible sa `/dashboard/advanced`.

### Q: Paano ko malalaman kung anong tasks ang due this week?
**A:** Pumunta sa **Calendar** view para makita ang tasks ayon sa date. O sa **Task Manager**, i-filter ang tasks by due date range.

### Q: Sino ang makakatanggap ng daily email alerts?
**A:** Ang **task assignees** at ang mga naka-configure sa admin settings: Personal Alert Email, Daily Report Recipients, at Deadline Alert BCC. Pwedeng i-customize ng Admin sa Configuration page.

### Q: Paano mag-logout?
**A:** I-click ang iyong **profile/name** sa kanang itaas ng navbar → I-click ang **"Logout"** option sa dropdown menu.

---

## 🔑 Mga Shortcut at Tips

| Tip | Detalye |
|-----|---------|
| **Sidebar Toggle** | I-click ang arrow sa taas ng sidebar para i-collapse/expand |
| **Quick Chat** | I-click ang chat icon sa navbar — hindi ka aalis sa current page |
| **Enter to Send** | Sa chat, pindutin ang Enter para mag-send ng message |
| **Filter Tasks** | Sa Kanban at Task Manager, gamitin ang filter para hanapin ang specific tasks |
| **Bookmark Dashboard** | I-bookmark ang `https://taskmanagement.test/dashboard` para mabilis na access |

---

> **Kailangan ng tulong?** I-contact ang iyong **Administrator** o gamitin ang built-in **Chatbot** para sa mga karaniwang tanong.

---

*Movaflex Task Manager © 2026. Lahat ng karapatan ay nakalaan.*
