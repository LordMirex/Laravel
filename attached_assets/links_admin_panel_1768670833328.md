Admin Panel Behavior Document 🖥️

Modular Influencer Engine — Admin UX & Day-to-Day Behavior (v1.0)

This document describes exactly how non-technical admins manage their site day-to-day. It is developer- and designer-ready: contains navigation, flows, microcopy, validations, endpoints/JSON shapes, keyboard shortcuts, mobile behavior, audit rules, performance tips, and acceptance criteria. Use this to build the Filament or custom admin UI.

⸻

1 — Goals & Principles 🎯
	•	Simple: non-technical creators complete common tasks in ≤ 5 clicks.
	•	Safe: theme switching and feature toggles are reversible; data never lost.
	•	Preview-first: edits should be previewable (desktop/mobile) before final publish.
	•	Mobile-capable: admin must be usable on phones (for quick edits).
	•	Guided: give clear microcopy, helper tooltips, and undo where possible.
	•	Fast: operations that can block should be chunked or queued; show progress.

⸻

2 — Top-level Admin Navigation (Structure & Behavior)

Layout (desktop)

Left vertical nav (collapsible), content area center, live preview right (resizable).
Top bar: site switch (if multi-site in future), quick create (+), notifications (toasts), user menu (profile, logout), global search.

Primary menu items
	1.	Dashboard — overview (stats shortcuts, recent changes, shortcuts).
	2.	Appearance → Theme Library, Theme Customizer.
	3.	Landing / Blocks — Block Manager (primary editor for landing page).
	4.	Media Library — uploads, edits, focal/crop.
	5.	Products — CRUD for Store items.
	6.	Events — CRUD for events.
	7.	Newsletter — Subscribers, Compose, Campaigns, Logs.
	8.	Pages — About, Contact, Legal (static pages editor).
	9.	Settings — Site settings, WhatsApp, SMTP, Feature Toggles.
	10.	Support / Docs — embedded docs & installer troubleshooting.
	11.	Logs / Activity — audit trail, change history, export.

Mobile behavior
	•	Left nav collapses into hamburger.
	•	Preview collapses to a device toggle (Preview button opens preview overlay).
	•	Key actions pinned as floating action button (FAB): Add Block / Add Product.

⸻

3 — Block Manager UX (The heart of the admin)

Purpose

Enable admin to add, remove, reorder, and edit blocks that compose the landing page. Blocks are canonical content — theme renders them.

Entry point

Landing → Block Manager shows ordered list with live thumbnail for each block.

Block list items

Each row shows:
	•	Thumbnail (mini preview)
	•	Block title (editable inline)
	•	Type badge (Hero, Store, Newsletter, etc.)
	•	Visibility toggle (eye icon)
	•	Drag handle (for reorder)
	•	Edit button (pencil)
	•	Duplicate (copy)
	•	Delete (trash) — with confirmation modal and “undo” toast

Add Block flow
	•	Click Add Block → modal or drawer shows block catalog grouped by category (Media, Conversion, Social, Info).
	•	Each block tile shows short description and sample thumbnail.
	•	Choose block → side panel opens with block form fields (see Appendix A field spec).
	•	Save: Save & Close or Save & Preview (applies change to preview pane).

Microcopy:
	•	Add button: + Add block
	•	Block tile: Add [BlockName] — [short description]

Edit Block flow (side panel)
	•	Fields presented in logical groups: Content → Media → Layout → Visibility.
	•	Device toggle (Desktop / Mobile) at top of panel. Switching shows device-specific options (mobile crop, mobile layout).
	•	Live preview auto-updates after each save. For expensive media uploads show progress bar and disable Save until finished.

Validation
	•	Required fields indicated with *.
	•	Inline validation (client-side) for format (URL, date) plus server validation on Save.
	•	Save returns block JSON saved and updated order_index.

Reorder behavior
	•	Drag & drop with instant reflow in preview.
	•	Alternative move Up/Down arrows for accessibility.
	•	Reorder persists on server immediately (optimistic UI). If server fails, revert and show toast: Unable to reorder — retry.

Visibility toggle
	•	Click eye icon toggles on/off. Tooltip: Visible on public site or Hidden from public.
	•	Turning off prompts: This block will be hidden on the live site. Hidden blocks are not deleted. (no further confirmation).

Duplicate & Delete
	•	Duplicate clones content JSON and inserts after original. Microcopy: Duplicate block → Block duplicated.
	•	Delete opens confirmation: type the word DELETE to confirm for destructive blocks (Store block delete confirms product associations).

Draft vs Publish
	•	Edits are persisted immediately but can be flagged as Draft (optional feature for Phase 2). For v1, saving updates live preview accessible to admin only until Publish clicked — choose either immediate publish (simpler) or publish step. Recommend immediate publish with admin preview, plus an optional “Revert” history.

Block JSON shape (example on save)

{
  "id": 12,
  "type": "hero",
  "enabled": true,
  "order_index": 1,
  "content": {
    "title": "Watch my latest skit",
    "subtitle": "New every Friday",
    "background": {"type":"image","media_id":34},
    "cta": [{"label":"Watch Now","action":"anchor","#target":"videos"}]
  }
}


⸻

4 — Theme Switching Behavior (Appearance → Theme Library)

Theme Library UI

Grid of theme cards with:
	•	Thumbnail
	•	Category chips
	•	Preview (open modal)
	•	Apply button

Preview
	•	Preview modal uses the current site data to render a realistic preview. Toggle device (desktop/mobile).
	•	Preview is read-only and does not change live site.

Apply Theme
	•	Click Apply → show Confirm modal:
	•	Title: Apply theme "Luxe — Campaign"?
	•	Body: This will change how your site looks but will not delete any content. You can revert to previous theme from Appearance → Theme History.
	•	Buttons: Cancel / Apply theme

What happens on Apply (system logic)
	1.	Write site_settings.theme_config = {variant_ref, token_overrides(empty)}.
	2.	Optionally copy a backup of previous theme_config to theme_history (keep last 3).
	3.	Optionally seed per-theme component settings (e.g., hero variant used).
	4.	Re-render preview for admin immediately; public site updates immediately.

Revert & History
	•	Theme History panel shows last 3 themes with Revert buttons.
	•	Revert restores previous theme_config and re-applies layout partials.

Edge cases
	•	If a theme requires component variants not present, fallback to default partials and log warning in admin Activity.

Theme Customization
	•	After applying, admin can open Theme Customizer:
	•	Color pickers (primary, accent) with live preview.
	•	Font selector (heading/body) with sample text.
	•	CTA style toggles (Rounded / Sharp).
	•	Save writes token overrides to site_settings.theme_config.custom.

Microcopy
	•	Apply confirmation: Themes change the look, not your content. Safe to try — revert any time.

⸻

5 — Feature ON/OFF Toggles (Settings → Feature Toggles)

Purpose

Switch modules on/off (Store, Events, Newsletter, Media Kit, Booking).

UI

Simple checkbox list with short descriptions and More info links:
	•	Store — Sell products via WhatsApp buy links
	•	Events — Display upcoming events and ticket links
	•	Newsletter — Collect and broadcast emails
	•	Media Kit — Show downloadable media kit
	•	Booking — Accept booking inquiries

Behavior
	•	Turning ON:
	•	Activates navbar link and public routes.
	•	Adds admin section visibility (if not present).
	•	Optionally auto-seed basic content (e.g., sample product) — show a checkbox: Auto-seed starter content.
	•	Turning OFF:
	•	Hides navbar link & public routes.
	•	Keeps data in DB but does not surface it publicly.
	•	Show This will hide the feature on your public site. Data will be preserved.

Safeguards
	•	If disabling Store while active orders tracked (v2), show warning. For v1 (no orders) less risk.

JSON toggle storage

{
  "store": true,
  "events": false,
  "newsletter": true
}


⸻

6 — Newsletter Management (Subscribers & Campaigns)

Subscribers page
	•	Table: Email, Name, Source, Subscribed (Y/N), Tags, Created At, Actions (Export, Toggle Opt-in)
	•	Search & filter by tag, opt-in status, date range
	•	Bulk actions: Export CSV, Unsubscribe, Delete (requires confirmation)
	•	Import CSV button: validate headers (email,name,tag) and show preview of rows, skip duplicates.

Compose / Campaigns
	•	Compose UI: subject line, preheader, rich text editor (simple set of formatting tools), insert image, insert dynamic placeholders ({{name}}).
	•	Recipients: All / Tag / Manual CSV upload
	•	Send options: Immediate / Schedule (requires cron; if not configured show a warning)
	•	Send mode:
	•	If queue worker available: use queued jobs
	•	Fallback: synchronous chunked sending with progress tracking (chunk size configurable)
	•	Preview & Test: Send test to admin email before send.

Campaign Logs
	•	For each campaign store: id, subject, recipients_count, status (sent/queued/failed), sent_at
	•	Per-email logs for fails (if SMTP errors)

Unsubscribe handling
	•	Every email contains unsubscribe link with token.
	•	Clicking unsub sets opt_in=false and shows a confirmation page.

Microcopy
	•	Compose CTA: Send broadcast
	•	Confirmation: Are you sure you want to send to X subscribers?
	•	Success toast: Campaign queued for sending.

⸻

7 — Media Library Behavior (uploads, crop, focal, usage)

Overview

Single source of truth for all uploaded files. Provide search, filter (images/videos/docs), collections/folders, tags.

Upload UX
	•	Drag & drop area with progress bar.
	•	Multiple files allowed; show generated thumbnails immediately.
	•	Show size limit and recommended sizes for hero/product images.

Edit modal

For each media item show:
	•	Preview
	•	Filename (editable)
	•	Alt text (required for hero/featured images) — inline validation warns if missing
	•	Crop tool (preset aspect ratios: 16:9, 4:3, 1:1, free)
	•	Focal point picker (x%, y%) — saved as focal_x, focal_y
	•	Replace file (keeps ID but replaces file path)
	•	Usage list: shows which blocks/pages reference this media (important when deleting)
	•	Tags & collections
	•	Download & Delete (delete shows confirm if used anywhere; requires admin override to remove references)

Automatic variants
	•	On upload generate sizes: xs/sm/md/lg/xl with WebP if server supports. If not, generate at least sm/md/lg JPEG.
	•	Store generated variants in media.variants JSON.

API / JSON shape

{
  "id": 42,
  "path": "/storage/uploads/hero.jpg",
  "alt": "Creator portrait",
  "width": 1920,
  "height": 1080,
  "variants": {"sm":"/...","md":"/..."},
  "focal": {"x":50,"y":30},
  "tags":["hero","profile"]
}

Deletion rules
	•	If media is referenced: show In use by X blocks (click to view). Prevent outright delete unless admin confirms to replace or remove references.
	•	Soft delete option (move to trash) with 30-day retention.

⸻

8 — Products & Store Admin Behavior

Products list
	•	Table: image, title, price, active toggle, actions (edit, duplicate, delete)
	•	Quick Add for new product (modal): title, price, image, sku, description, active toggle

Product Edit
	•	Product fields: title, price, currency, image select (media library), short & long description (rich text), buy_message_template (preview)
	•	Buy message preview shows final wa.me URL (encode phone from settings)

Bulk actions
	•	Activate/Deactivate, Export CSV

Microcopy
	•	Button Buy via WhatsApp in preview: Preview buy message
	•	Save toast: Product saved — public changes live.

⸻

9 — Pages (About, Contact, Legal) Behavior
	•	Use a rich text editor with Markdown or WYSIWYG.
	•	Template fields for meta title & description.
	•	Save updates reflect on public pages immediately.
	•	Provide “View Page” button that opens public page in new tab.

⸻

10 — Settings & Site Configuration

Key areas
	•	Site Identity: title, tagline, favicon, logo.
	•	WhatsApp: phone number (E.164 enforced), default country code helper.
	•	Localization: timezone, currency, language.
	•	Feature toggles (see earlier).
	•	SMTP & Email: host, port, username, password, encryption — test SMTP button that sends a test email to admin.
	•	Backup: Export DB schema (for packaging), Export site settings JSON, Import settings JSON.
	•	Advanced: Cron status check, storage link helper (run storage:link when possible), file permissions checker.

Microcopy
	•	SMTP test success: Test email sent to admin@example.com
	•	WhatsApp number helper: Include country code, e.g., +234XXXXXXXXX

⸻

11 — Activity Log, Audit Trail & Undo

Activity log
	•	Record major actions: block add/edit/delete, theme apply/revert, product create/delete, newsletter send, settings change.
	•	Log format: {timestamp, admin_id, action, object_type, object_id, diff(optional)}

Undo & Revert
	•	For destructive actions (delete block, delete product) show Undo toast available for 30 seconds.
	•	Theme apply stores previous theme_config for revert.
	•	Provide Restore for previous versions (basic snapshotting for last 3 theme configs and last 10 block edits) — minimal but useful.

⸻

12 — Mobile Admin Specifics
	•	Simplified Block Manager list view with quick edit modal; preview opens in full-screen.
	•	Floating + action for Add Block/Product.
	•	Lazy load images and previews to reduce bandwidth.
	•	Ensure all forms usable with on-screen keyboard and large tap targets.

⸻

13 — Keyboard Shortcuts & Accessibility

Recommended shortcuts
	•	? — Open help modal
	•	n — New Block (opens Add Block modal)
	•	s — Save current edit (if focused in editor)
	•	p — Toggle Preview
	•	Ctrl/Cmd + / — Quick search

Accessibility
	•	All interactive controls have aria-label and proper keyboard tab flow.
	•	Provide high-contrast toggle in Theme Customizer for admin readability.
	•	Modals trap focus; return focus on close.

⸻

14 — Error Handling & User Feedback
	•	Use non-blocking toasts for success/failure with clear actions: Retry / View Logs.
	•	For long ops (media generate, migration seeds), show progress bars and status polling.
	•	For failed uploads or server errors, present a single actionable error with link to docs and support contact prefilled with diagnostics.

⸻

15 — Autosave, Drafts & Conflict Resolution
	•	While editing a block, autosave drafts every 10 seconds to local storage.
	•	If admin A and admin B edit same block, on save show conflict detection: This block was changed by another admin at 10:12. Choose Merge / Overwrite / Cancel. (simple last-write wins plus manual merge UI).

⸻

16 — Import / Export Capabilities
	•	Export blocks as JSON (single page or per block) — useful to copy configuration between installs.
	•	Import block JSON uploader validates schema and previews changes.
	•	Export products CSV and import CSV (validate headers).
	•	Export subscribers CSV.

⸻

17 — Performance & Scalability Notes for Admin
	•	Limit server-side heavy operations: process media variants in background if possible (but support synchronous fallback for shared hosting).
	•	Paginate large tables (subscribers/products) and provide server-side search indexes for speed.
	•	Cache theme tokens and block render templates; invalidate on theme apply or block edit.

⸻

18 — Security & Permissions
	•	Admin panel requires HTTPS.
	•	Rate limit sensitive endpoints (login, installer).
	•	Lock admin after X failed logins and send email alerts (if SMTP configured).
	•	Session lifetime configurable; remember-me optional.

⸻

19 — QA & Acceptance Criteria (Admin Panel)

Must work:
	•	Add / edit / delete / reorder blocks with live preview updates.
	•	Apply theme and revert via Theme History.
	•	Toggle feature ON/OFF hides/shows public routes immediately.
	•	Upload media, crop, set focal point, and use image in a block.
	•	Create product and test Buy via WhatsApp message preview.
	•	Import/Export products and subscribers.
	•	Compose newsletter, schedule or send using synchronous chunking fallback.
	•	Admin actions recorded in activity log; undo available for deletes.

Test cases (examples)
	•	Add Hero block with image, test mobile crop, preview on mobile.
	•	Disable Store toggle; ensure store nav disappears and products not visible.
	•	Upload 10 images on a low-permission host and verify no timeouts (simulate chunk upload).
	•	Theme apply with custom tokens; verify content persists and preview updates.
	•	SMTP test failure shows clear error and link to SMTP docs.

⸻

20 — Deliverables for implementation
	•	Admin UI wireframes (desktop/mobile) for Dashboard, Block Manager, Theme Library, Media Editor, Product CRUD, Newsletter Compose.
	•	JSON schema for Block content and Media objects.
	•	API endpoints doc (CRUD endpoints for blocks, media, products, subscribers).
	•	Activity log schema and retention policy.
	•	Accessibility checklist and keyboard shortcuts mapping.
	•	Acceptance test plan and sample data set.

⸻

21 — Appendix: Suggested API endpoints & sample payloads (quick)
	•	GET /api/admin/blocks → list blocks
	•	POST /api/admin/blocks → create block {type, content}
	•	PUT /api/admin/blocks/{id} → update block {content, enabled}
	•	POST /api/admin/blocks/reorder → {order: [{id:12, index:1}, ...]}
	•	GET /api/admin/media → list media
	•	POST /api/admin/media → multipart upload
	•	POST /api/admin/themes/apply → {variant_ref}
	•	GET /api/admin/feature-toggles / PUT /api/admin/feature-toggles → {store:true,...}
	•	POST /api/admin/newsletter/send → {subject, body, recipients:[all|tag|csv], mode:[sync|queue]}

All endpoints return {success:boolean, message:string, data:...} and HTTP appropriate status codes.

⸻

22 — Example microcopy list (copy-ready)
	•	+ Add block
	•	Save & Preview
	•	Visible on public site / Hidden from public
	•	Apply theme → Apply theme "Luxe — Campaign"?
	•	This will hide the Store from your public site. Data will be preserved.
	•	Campaign queued for sending.
	•	Upload complete / Processing image variants...
	•	Product saved — public changes live.

