Below is a FULL, BROAD, SYSTEM-LEVEL APPLICATION ARCHITECTURE & LOGIC DOCUMENT.
This is not code, not short, not shallow.
This is the internal brain of the system — how everything is structured, why decisions are made, and how the logic flows from install → admin → frontend → future installs.

This document is written so:
	•	Replit AI understands the mental model
	•	A Laravel developer understands what to build and why
	•	You can scale or refactor later without breaking the foundation

⸻

3. Application Architecture & Logic Document 🏗️

Modular Influencer Engine — Internal System Blueprint

⸻

1. Purpose of This Document

This document defines how the system is structured internally.

It does not describe UI visuals or design styles.
It does not describe business marketing copy.

It strictly explains:
	•	System boundaries
	•	Architectural rules
	•	Data flow
	•	Logic flow
	•	Feature toggles
	•	Rendering decisions
	•	Storage philosophy
	•	Install-to-runtime lifecycle

This document is the engineering constitution of the product.

⸻

2. Core Architectural Philosophy

2.1 One App, One Owner, One Database

Each installation is:
	•	A single Laravel application
	•	Connected to one MySQL database
	•	Owned and managed by one admin
	•	Fully isolated from every other installation

There is:
	•	No multi-tenant SaaS logic in v1
	•	No shared database
	•	No user-to-user relationships
	•	No cross-site dependencies

This keeps:
	•	Hosting simple
	•	Security tight
	•	Debugging predictable
	•	Selling as a digital product easy

⸻

3. Runtime Modes (Critical Concept)

The application operates in two mutually exclusive modes:

3.1 Installer Mode

Triggered when:
	•	App is freshly uploaded
	•	No .env exists OR
	•	Installation flag is not set

In this mode:
	•	Public frontend is blocked
	•	Admin dashboard is blocked
	•	Only installer routes are accessible
	•	Database may not yet exist

Purpose:
	•	Collect environment data
	•	Initialize database
	•	Seed system defaults
	•	Create admin user
	•	Select initial category and theme

⸻

3.2 Application Mode

Triggered after successful installation.

In this mode:
	•	Installer is permanently disabled
	•	Frontend routes are active
	•	Admin dashboard is active
	•	System behaves as a live website

The transition from Installer → Application mode is one-way.

⸻

4. User Model & Access Logic

4.1 No Public User Accounts

The system does not support public user registration.

There are:
	•	No customer logins
	•	No user dashboards
	•	No password resets for public users

This is intentional.

Public users can only:
	•	View content
	•	Subscribe to newsletter
	•	Click WhatsApp links
	•	Submit contact forms

⸻

4.2 Admin-Only Authentication

There is:
	•	Exactly one admin role (v1)
	•	Admin is created during installation
	•	Admin credentials are never auto-generated in production

Admin capabilities:
	•	Edit content
	•	Manage blocks
	•	Switch themes
	•	Enable or disable features
	•	Manage products
	•	Send newsletters
	•	Upload media

No permission layers needed in v1.

⸻

5. Data Storage Philosophy (Very Important)

5.1 Canonical Content vs Presentation

The system strictly separates:
	•	Canonical content (what the creator owns)
	•	Presentation logic (how it looks)

This is the backbone of safe theme switching.

⸻

5.2 JSON-Based Content Storage

Instead of rigid schemas for every content type, the system uses:
	•	Structured relational tables for entities
	•	JSON columns for layout and block content

Why JSON?
	•	Blocks vary across templates
	•	New block types should not require schema changes
	•	Themes need flexibility
	•	Future expansion without migrations

⸻

5.3 Canonical Tables (High Level)
	•	site_settings
	•	blocks
	•	products
	•	media
	•	subscribers
	•	events
	•	newsletter_campaigns
	•	admin_users

Only stable entities get tables.
Layout logic lives in JSON.

⸻

6. Block System Architecture

6.1 What Is a Block?

A Block is:
	•	A self-contained content unit
	•	Rendered independently
	•	Theme-aware
	•	Enable/disable capable
	•	Orderable

Examples:
	•	Hero
	•	Video Grid
	•	Store
	•	Newsletter
	•	Events
	•	About
	•	Contact

⸻

6.2 Block Lifecycle
	1.	Block is defined in system (type)
	2.	Block instance is created for the site
	3.	Admin edits its content (JSON)
	4.	Block is enabled or disabled
	5.	Frontend renderer loops blocks and displays enabled ones

⸻

6.3 Block Rendering Flow
	1.	Frontend loads site settings
	2.	Frontend fetches all blocks ordered by order_index
	3.	Disabled blocks are skipped
	4.	Enabled blocks are passed to renderer
	5.	Renderer:
	•	Determines block type
	•	Selects correct component
	•	Applies current theme tokens
	•	Outputs markup

Block content NEVER decides layout.
Layout is owned by the theme.

⸻

7. Theme & Rendering Logic (System View)

7.1 Themes Do Not Store Content

Themes:
	•	Do not store text
	•	Do not store images
	•	Do not store business data

Themes only define:
	•	Visual tokens
	•	Structural component variants
	•	Animation rules
	•	Layout decisions

⸻

7.2 Theme Switching Logic

When admin switches theme:
	•	Only theme reference changes
	•	JSON content remains untouched
	•	Blocks re-render using new theme rules

This guarantees:
	•	Zero data loss
	•	Safe experimentation
	•	Fast switching

⸻

8. Feature Toggle System (Critical)

8.1 What Is a Feature Toggle?

A feature toggle controls whether a major module is:
	•	Active
	•	Visible
	•	Routable

Examples:
	•	Store
	•	Events
	•	Newsletter
	•	Media Kit
	•	Booking

⸻

8.2 Feature Toggle Rules

If a feature is OFF:
	•	Block is hidden
	•	Navbar link is hidden
	•	Routes are inaccessible
	•	Admin section remains visible (with “Inactive” state)

If a feature is ON:
	•	Block renders
	•	Navbar link appears
	•	Routes activate
	•	Feature becomes part of frontend flow

⸻

8.3 Feature Toggle Storage

Feature toggles are stored in:
	•	site_settings.features (JSON)

Example:

{
  "store": true,
  "events": false,
  "newsletter": true,
  "booking": false
}

This allows:
	•	Instant toggling
	•	No migrations
	•	Safe defaults per category

⸻

9. Category Logic (Internal)

9.1 Categories Are Presets, Not Restrictions

Categories (e.g. Skit Maker, Seller, Author):
	•	Predefine initial block order
	•	Predefine recommended theme
	•	Predefine enabled features

They do not:
	•	Lock features
	•	Restrict admin actions
	•	Create separate code paths

Category = starting configuration only.

⸻

9.2 Category Application Flow

When category is selected:
	1.	Default blocks are seeded
	2.	Default feature toggles applied
	3.	Default theme selected
	4.	Admin can override everything later

⸻

10. Newsletter System Logic

10.1 Subscriber Model

Subscribers:
	•	Do not have accounts
	•	Identified by email
	•	Opt-in based
	•	Tagged by source

⸻

10.2 Newsletter Flow
	1.	Visitor subscribes
	2.	Email stored in subscribers table
	3.	Admin composes newsletter
	4.	Newsletter sent via:
	•	SMTP (preferred)
	•	PHP mail fallback
	5.	Unsubscribe link toggles opt-in state

⸻

10.3 System Guarantees
	•	Newsletter system never blocks frontend
	•	Failures are logged, not fatal
	•	Chunk sending prevents timeouts

⸻

11. WhatsApp Commerce Logic

11.1 No Checkout System

There is:
	•	No cart
	•	No order table
	•	No payment gateway

The system acts as a lead generator.

⸻

11.2 Buy Flow Logic
	1.	Product displayed
	2.	User clicks Buy
	3.	System builds WhatsApp URL
	4.	User is redirected to WhatsApp
	5.	Transaction handled manually

⸻

11.3 Why This Is Intentional
	•	Works everywhere
	•	No compliance issues
	•	No payment disputes
	•	Perfect for influencers

⸻

12. Media System Logic

12.1 Media Is Centralized

All media:
	•	Uploaded once
	•	Referenced by ID
	•	Used across blocks, products, themes

⸻

12.2 Media Processing Rules
	•	Resize on upload
	•	Store focal point
	•	Serve responsive sizes
	•	Lazy load on frontend

⸻

13. Performance & Stability Principles
	•	No background workers required
	•	No real-time dependencies
	•	Minimal JS
	•	Cache-friendly frontend
	•	Predictable DB queries

⸻

14. Why This Architecture Works Long-Term
	•	Easy to maintain
	•	Easy to sell
	•	Easy to debug
	•	Easy to refactor into SaaS later
	•	Hard to break accidentally

⸻

15. Final Architectural Rule (Memorize This)

Content lives in JSON.
Presentation lives in themes.
Features live in toggles.
The installer controls the lifecycle.
