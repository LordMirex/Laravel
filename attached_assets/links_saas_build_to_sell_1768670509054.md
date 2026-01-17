Application Packaging & Distribution Document

(Replit Build → Sellable Laravel Installation Package)

Document Type: Product & Distribution Specification
Audience: Replit AI, future developers, and technical partners
Purpose: Define how the application is built, cleaned, packaged, sold, and installed without changing the core system logic.

⸻

1. Document Purpose

This document exists to clearly separate development mode from distribution mode.

It explains:
	•	How the application is built on Replit
	•	How it is converted into a clean, sellable product
	•	How it behaves when installed on a customer’s shared hosting
	•	How the installation wizard is triggered only after packaging

This document must be read together with the main PRD.
The PRD defines what the product is.
This document defines how the product is delivered.

⸻

2. Product Delivery Model

Core Principle

The application is built once, then reused, packaged, and installed multiple times.

Each customer receives:
	•	The same Laravel codebase
	•	A fresh MySQL database
	•	A first-run installation wizard

There is:
	•	No SaaS dashboard
	•	No shared database
	•	No user registration system for customers

Each installation is fully isolated.

⸻

3. Two Operational Modes

3.1 Development Mode (Replit)

Purpose: Build and test the full system.

Characteristics
	•	Application runs like a normal Laravel app
	•	Database exists
	•	.env file exists
	•	Demo data may exist
	•	Admin login works
	•	Installer is disabled or bypassed
	•	Replit environment limitations are ignored

Allowed in this mode
	•	Hardcoded environment assumptions
	•	Test SMTP
	•	Fake products, posts, subscribers
	•	Temporary admin credentials

Replit role
Replit is treated as a factory environment, not a deployment target.

⸻

3.2 Distribution Mode (Sellable Package)

Purpose: Deliver a clean, installable product.

Characteristics
	•	No .env file
	•	No database data
	•	No admin user
	•	No site identity
	•	No cached configs
	•	Installer is enabled
	•	First page load always launches Setup Wizard

This mode is activated only after packaging.

⸻

4. Packaging Workflow (Critical Section)

This workflow is executed after development is complete.

Step 1 — Freeze the Codebase
	•	All features complete
	•	No more development changes
	•	Version number finalized

⸻

Step 2 — Sanitize the Application

The following must be removed or reset:

Environment
	•	Delete .env
	•	Keep .env.example
	•	Ensure APP_DEBUG=false in example file

Database
	•	Drop all tables
	•	Remove all seeded data
	•	Do not include SQL dumps

Users
	•	Remove admin users
	•	Disable public registration
	•	System must start with zero users

Content
	•	Remove demo products
	•	Remove demo blocks
	•	Remove demo newsletters
	•	Optional: keep sample templates only

Media
	•	Clear uploaded images
	•	Keep empty directories only

Cache
	•	Clear config cache
	•	Clear route cache
	•	Clear view cache

⸻

Step 3 — Reset Installation State

The application must contain an installation state check.

Before packaging:
	•	Installation state is reset to NOT INSTALLED

This ensures:
	•	First visit on a new server always launches the installer
	•	Installer cannot be skipped accidentally

⸻

Step 4 — Package the Application

The final package includes:
	•	Laravel application files
	•	vendor folder (if target customers lack Composer)
	•	.env.example
	•	README installation guide
	•	License file (if applicable)

The package is:
	•	Zipped
	•	Ready for upload to cPanel
	•	Ready for sale or distribution

⸻

5. Installation Behavior on Customer Hosting

First Visit Logic

When the customer visits the domain:
	1.	Application checks installation state
	2.	If NOT installed:
	•	Frontend is blocked
	•	Setup Wizard launches
	3.	If installed:
	•	Normal site loads

This check happens before routing to any page.

⸻

Setup Wizard Responsibilities

The wizard must:
	•	Collect database credentials
	•	Generate .env
	•	Test DB connection
	•	Run migrations automatically
	•	Create admin user
	•	Collect site identity details
	•	Select creator category and template
	•	Seed default layout blocks
	•	Lock itself permanently after success

⸻

6. Post-Installation State

After successful installation:
	•	Installer is disabled
	•	Installation state is set to INSTALLED
	•	Admin is redirected to dashboard
	•	Site becomes live
	•	No further setup steps are accessible

Reinstallation requires:
	•	Manual deletion of installation flag
	•	Or full reset by re-uploading the package

⸻

7. Update & Reuse Strategy

New Customer
	•	Upload the same ZIP
	•	Create new database
	•	Run installer

Product Update (future version)
	•	Build new version on Replit
	•	Repeat packaging workflow
	•	Distribute new ZIP

No customer data is shared between installations.

⸻

8. Why This Model Is Chosen

This approach:
	•	Works perfectly on shared hosting
	•	Avoids SaaS complexity
	•	Simplifies support
	•	Allows digital product sales
	•	Matches how professional Laravel scripts are sold

It is:
	•	Scalable
	•	Maintainable
	•	Easy to explain to developers
	•	Easy to automate later

⸻

9. Replit AI Instruction (Internal Prompt)

Use this instruction during development:

“Build the application in development mode only. Assume a working database and environment. The installer is not active during development. At packaging time, all environment data, database data, users, and caches will be removed, and the application will boot into installer mode for first-time setup on shared hosting.”

⸻

10. Final Summary
	•	Replit is used to build the engine
	•	Packaging converts the engine into a product
	•	Installation wizard activates only after packaging
	•	Each customer runs a fresh, isolated instance
	•	No code rewriting is required per customer

⸻

This document completes the product documentation set.

If you want next, I can:
	•	Turn this into a PDF-ready document
	•	Create a buyer-facing installation manual
	•	Create a developer handoff checklist
	•	Create a versioning and update policy

Just say the word.