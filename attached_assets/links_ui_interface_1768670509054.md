Below is a FULL UI DESIGN & INTERFACE REQUIREMENTS DOCUMENT written specifically for AI-first execution.
This document is meant to be fed directly to Replit AI / any coding AI so it can:
	•	understand the visual intent
	•	understand layout logic
	•	understand dynamic rules
	•	convert static UI designs, sketches, or screenshots into dynamic Laravel components
	•	scale themes without breaking data

This is not code.
This is a UI brain + design law document.

⸻

UI DESIGN & INTERFACE REQUIREMENTS DOCUMENT 🎨

Modular Influencer Engine — AI-First UI System Spec (v1.0)

⸻

1. Purpose of This Document

This document defines HOW THE UI SHOULD EXIST, not how it is coded.

It is written so that:
	•	AI can generate frontends automatically
	•	Designs can be converted into dynamic templates
	•	Themes can be added endlessly without refactoring logic
	•	The system feels premium, custom, and non drag-and-drop

This document assumes:
	•	Laravel backend
	•	Block-based rendering
	•	JSON content storage
	•	Admin-controlled feature toggles

⸻

2. Core UI Philosophy (Non-Negotiable)

2.1 This is NOT a page builder UI
	•	No drag-and-drop canvas
	•	No visible grid system to users
	•	No “builder look”

The UI must feel like:

a custom-coded, expensive website

Even though it is dynamic.

⸻

2.2 Themes are PRE-DESIGNED, not assembled

Admins do not design layouts.
They select professionally designed layouts.

Admin only edits:
	•	Text
	•	Images
	•	Links
	•	Visibility

Never structure.

⸻

2.3 Content survives everything

Changing:
	•	theme
	•	category
	•	layout
	•	color palette

Must never delete or scramble content.

⸻

3. Creator Categories (UI Drivers)

Categories exist only to guide UI defaults, not to restrict features.

Required Categories (v1)
	1.	Entertainers
	•	Skit makers
	•	Comedians
	•	Viral creators
	2.	Influencers / Personal Brands
	•	Lifestyle
	•	Fashion
	•	Twitter creators
	3.	Sellers / Brands
	•	Merch sellers
	•	Digital product sellers
	•	WhatsApp sellers
	4.	Educators
	•	Bloggers
	•	Coaches
	•	Speakers
	5.	Media Creators
	•	YouTubers
	•	Podcasters
	•	Musicians
	6.	Professionals
	•	Photographers
	•	Designers
	•	Consultants

Each category has:
	•	UI mood
	•	content priority
	•	conversion goal

⸻

4. Landing Page UI RULES (Global)

These rules apply to ALL themes.

4.1 Navigation
	•	Clean navbar
	•	Transparent over hero OR solid based on theme
	•	Social icons always visible (top or bottom)
	•	Navbar items appear only if feature is enabled

Mobile:
	•	Full-screen drawer
	•	Large tap targets
	•	Sticky CTA optional

⸻

4.2 Hero Section (Mandatory Block)

Every theme MUST have a hero.

Hero variants:
	•	Video background
	•	Image background
	•	Text-only editorial
	•	Split layout

Hero must support:
	•	Title
	•	Subtitle
	•	Primary CTA
	•	Optional secondary CTA

Hero never scrolls sideways. Vertical flow only.

⸻

4.3 Content Flow Rule

Landing page is a vertical narrative:
	1.	Identity
	2.	Proof
	3.	Value
	4.	Conversion

Themes can reorder but must respect narrative.

⸻

5. UI SYSTEM = BLOCKS + THEMES + TOKENS

5.1 Blocks (WHAT appears)

Blocks define content units:
	•	Hero
	•	Video Grid
	•	Product Grid
	•	About
	•	Newsletter
	•	Testimonials
	•	Events
	•	Contact

Blocks:
	•	Are data containers
	•	Do not define visuals
	•	Are reusable across themes

⸻

5.2 Themes (HOW it looks)

Themes define:
	•	spacing
	•	typography
	•	color usage
	•	animation
	•	layout structure

Themes NEVER:
	•	change data schema
	•	add new fields
	•	remove content

⸻

5.3 Tokens (HOW themes stay dynamic)

Every theme is powered by tokens:
	•	Colors
	•	Fonts
	•	Border radius
	•	Shadows
	•	Animation timing

Tokens allow:
	•	AI to convert designs
	•	Safe theme switching
	•	Live previews

⸻

6. Category UI BLUEPRINTS (VERY IMPORTANT)

Below is the exact UI intent per category.
AI should use this to generate layouts.

⸻

🎭 ENTERTAINERS (High energy UI)

Visual Mood
	•	Bold
	•	Dark or high contrast
	•	Motion heavy

Primary Focus
	•	Video
	•	Engagement
	•	Virality

Default Landing Flow
	1.	Video Hero (autoplay muted)
	2.	Latest Skits Grid (large thumbnails)
	3.	Viral Clips Carousel
	4.	Social Proof (followers)
	5.	Booking CTA

UI Rules
	•	Big thumbnails
	•	Short text
	•	Fast scroll rhythm
	•	Minimal paragraphs

⸻

🧍 INFLUENCERS / PERSONAL BRANDS

Visual Mood
	•	Clean
	•	Fashion-forward
	•	Editorial

Primary Focus
	•	Personal identity
	•	Social reach
	•	Brand trust

Default Landing Flow
	1.	Image Hero (portrait)
	2.	About Summary
	3.	Featured Content
	4.	Social Proof
	5.	Brand CTA

UI Rules
	•	White space
	•	Elegant fonts
	•	Balanced imagery

⸻

🛍 SELLERS / BRANDS

Visual Mood
	•	Premium store
	•	Instagram-like
	•	Collection driven

Primary Focus
	•	Products
	•	Conversion
	•	Trust

Default Landing Flow
	1.	Product Hero
	2.	Featured Collection
	3.	Best Sellers
	4.	Testimonials
	5.	WhatsApp Buy CTA

UI Rules
	•	Card-based grids
	•	Clear pricing
	•	Strong CTAs
	•	Minimal text

⸻

📚 EDUCATORS

Visual Mood
	•	Calm
	•	Professional
	•	Trustworthy

Primary Focus
	•	Knowledge
	•	Email capture
	•	Authority

Default Landing Flow
	1.	Text Hero / Quote
	2.	Featured Article or Course
	3.	Newsletter Signup
	4.	Testimonials
	5.	Resources

UI Rules
	•	Longer text allowed
	•	Readable typography
	•	Soft colors

⸻

🎥 MEDIA CREATORS

Visual Mood
	•	Studio-like
	•	Focused
	•	Content-centric

Primary Focus
	•	Episodes
	•	Subscriptions
	•	Community

Default Landing Flow
	1.	Media Hero
	2.	Latest Episodes
	3.	Platforms Links
	4.	Newsletter
	5.	Contact

UI Rules
	•	Embedded players
	•	Minimal distractions
	•	Clear play buttons

⸻

🧑‍💼 PROFESSIONALS

Visual Mood
	•	Corporate
	•	Clean
	•	Structured

Primary Focus
	•	Portfolio
	•	Credibility
	•	Booking

Default Landing Flow
	1.	Professional Hero
	2.	Services
	3.	Portfolio
	4.	Testimonials
	5.	Contact

UI Rules
	•	Grid alignment
	•	Conservative color usage
	•	Clear headings

⸻

7. THEME VARIANTS SYSTEM (Critical)

Each category must have multiple theme variants.

Example: SELLER Themes
	•	Minimal Store
	•	Luxury Brand
	•	Street Commerce
	•	Catalog Focused

Example: EDUCATOR Themes
	•	Editorial Reader
	•	Course Landing
	•	Thought Leader

Themes differ in:
	•	layout composition
	•	typography hierarchy
	•	spacing
	•	animation

NOT in:
	•	data
	•	logic
	•	features

⸻

8. Dynamic UI RULES (For AI coding)

8.1 Visibility Logic

If feature is OFF:
	•	No block rendered
	•	No navbar link
	•	No route

If feature is ON:
	•	Appears automatically in theme layout

⸻

8.2 Theme Switching Logic

When theme changes:
	•	Only tokens and layout templates change
	•	Block data remains untouched
	•	Admin preview updates instantly

⸻

8.3 Responsive Rules
	•	Desktop: full layout
	•	Tablet: stacked layout
	•	Mobile:
	•	Single column
	•	Large tap targets
	•	Reduced animations

AI must ensure:
	•	No horizontal scrolling
	•	No cropped text
	•	No hidden CTAs

⸻

9. Image & Media UI RULES
	•	All images must support focal points
	•	Background images must adapt per screen
	•	Video thumbnails must maintain aspect ratio
	•	Lazy loading everywhere except hero

Admin must be able to:
	•	upload once
	•	reuse everywhere

⸻

10. Admin UI PREVIEW RULE (Very important)

Admin must see:
	•	Desktop preview
	•	Mobile preview
	•	Theme preview before applying

Preview must use:
	•	real data
	•	real images
	•	real layout

No placeholders.

⸻

11. AI-READY DESIGN CONVERSION RULES

When AI receives:
	•	Figma
	•	Sketch
	•	Screenshot
	•	Reference site

AI must:
	1.	Identify blocks
	2.	Map blocks to system blocks
	3.	Extract tokens (colors, fonts, spacing)
	4.	Create theme variant
	5.	Bind blocks dynamically

Never hardcode content.

⸻

12. What This Document Enables

With this document:
	•	AI can generate initial UI
	•	AI can convert static designs to dynamic themes
	•	AI can expand theme library
	•	Dev logic stays clean
	•	System scales endlessly

⸻

13. Final Rule (Most Important)

Admins edit content.
Themes control appearance.
Categories guide defaults.
Blocks structure everything.

⸻
