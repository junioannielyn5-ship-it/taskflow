# Attachments Module (Module 6)

## Overview
This module allows users to upload, store, and securely download files related to specific tasks. All files are stored privately and access is restricted to project members.

---

## Directory Structure
```
app/Modules/Attachments/
├── Http/
│   ├── Controllers/AttachmentController.php
│   └── Requests/UploadAttachmentRequest.php
├── Models/TaskAttachment.php
├── Providers/AttachmentsServiceProvider.php
├── Routes/api.php
```

---

## Database Migration
- Table: `task_attachments`
- Fields: id, task_id, user_id, path, filename, mime_type, size, created_at, updated_at
- Foreign keys: `task_id` → tasks.id, `user_id` → users.id

---

## Endpoints
- **POST** `/tasks/{task}/attachments` — Upload a file to a task
- **GET** `/attachments/{attachment}/download` — Securely download a file
- **DELETE** `/attachments/{attachment}` — Delete an attachment (record + file)

All endpoints require authentication (`auth:sanctum`).

---

## Storage & Security
- Files are stored in the `private` disk (`storage/app/private`).
- No public URLs are exposed.
- Downloads are streamed via the controller after verifying project membership.
- Only allowed file types: pdf, png, jpg, jpeg, docx, gif, xlsx, txt (max 10MB).

---

## Access Control
- Upload/download/delete is only allowed for project members (checked via `ProjectService::isMember`).
- Only the owner or an admin can delete an attachment.

---

## Cleanup
- When an attachment record is deleted, the file is also deleted from storage (handled in the model's `deleting` event).

---

## Feature Tests
- User cannot download attachment from unauthorized project
- File is stored in private disk, not public
- Attachment record and file are deleted together

---

## Integration
- `AttachmentsServiceProvider` loads routes automatically.
- Provider is registered in `bootstrap/providers.php`.

---

## Example Usage
**Upload:**
```
POST /tasks/1/attachments
Headers: Authorization: Bearer <token>
Body: file=@mydoc.pdf
```
**Download:**
```
GET /attachments/10/download
Headers: Authorization: Bearer <token>
```
**Delete:**
```
DELETE /attachments/10
Headers: Authorization: Bearer <token>
```

---

## Notes
- Ensure the `private` disk is configured in `config/filesystems.php`.
- Run migrations: `php artisan migrate`
- Run tests: `php artisan test tests/Feature/Modules/Attachments/`
