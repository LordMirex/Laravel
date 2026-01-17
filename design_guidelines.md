# Design Guidelines: Premium Influencer Landing Page Engine

## Design Approach

**Reference-Based Strategy**: Drawing from Instagram's visual hierarchy, Notion's modular block system, and Apple's premium minimalism. High-contrast, content-forward design that puts the influencer's personality first.

**Core Principle**: Modular blocks with strong visual separation, allowing each content piece to breathe while maintaining cohesive flow.

---

## Typography System

**Primary Font**: Inter (via Google Fonts CDN)
- Headlines: 700 weight, tracking-tight
- Body: 400 weight, tracking-normal
- CTAs: 600 weight, uppercase with tracking-wide

**Scale**:
- Hero/Name: text-5xl lg:text-7xl
- Block Titles: text-2xl lg:text-3xl
- Body Text: text-base lg:text-lg
- Metadata/Labels: text-sm
- Micro-copy: text-xs

---

## Layout System

**Spacing Primitives**: Use Tailwind units of 3, 4, 6, 8, 12, 16
- Component padding: p-6 to p-8
- Section gaps: gap-8 to gap-12
- Block spacing: space-y-8 to space-y-16
- Container: max-w-2xl (focused, mobile-first)

**Grid Structure**: Single-column primary layout with 2-column grids for product/content blocks at lg breakpoint

---

## Component Library

### Hero Profile Block
- Full-width image background (16:9 aspect, high-quality portrait/lifestyle)
- Centered profile content with frosted glass container (backdrop-blur-xl, semi-transparent background)
- Large circular avatar (128px) with subtle border
- Name, bio tagline, follower count
- Primary WhatsApp CTA button with blurred background treatment
- Buttons on images: backdrop-blur-md with subtle transparency, no hover effects in guidelines

### Content Blocks (Modular System)

**Link Block**: Full-width cards with icon, title, description, and arrow indicator - tappable area

**Featured Content Block**: 2-column grid of content cards (videos, posts, announcements) with thumbnail images and metadata

**Product Block**: 2-column grid at lg, single column mobile
- Product image (square aspect)
- Title, price prominently displayed
- WhatsApp "Buy Now" integration button
- Quick-view details

**About Block**: Single column, rich text content with profile details and story

**Social Links Block**: Horizontal icon row with platform logos (Instagram, YouTube, TikTok, etc.) - use Font Awesome icons

**Contact Block**: WhatsApp integration prominent
- Direct message button
- Business hours display
- Response time indicator

**Newsletter/Updates Block**: Email capture with inline form, subtle background differentiation

### Navigation
Fixed bottom mobile nav OR sticky top minimal nav with logo/brand name

### Footer
Compact: Powered by branding, privacy links, social icon row

---

## Visual Treatments

**Contrast Strategy**: 
- Strong image-to-text contrast ratios
- Sharp block boundaries with subtle shadows (shadow-lg)
- Defined borders between sections (border-t or border-b with subtle opacity)

**Card System**: Rounded corners (rounded-2xl), generous padding (p-6 to p-8), subtle shadows (shadow-md to shadow-lg)

**Interactive Elements**: Scale transforms (hover:scale-105), smooth transitions (transition-all duration-300)

---

## Images

**Hero Section**: Full-width lifestyle/portrait image showcasing influencer personality (professional quality, aspirational aesthetic). Critical for establishing brand presence.

**Product Images**: Square format (1:1), clean product photography on neutral backgrounds

**Content Thumbnails**: 16:9 or 4:5 aspect ratios for video/post previews

**Avatar**: High-quality headshot, circular crop

---

## WhatsApp Integration Specifics

- WhatsApp green accent for commerce buttons (#25D366)
- Icon + "Chat on WhatsApp" or "Buy via WhatsApp" text
- Floating WhatsApp button option (fixed bottom-right on desktop)
- Direct product inquiry buttons on product cards

---

## Animations

**Minimal Motion**:
- Fade-in on scroll for blocks (intersection observer)
- Subtle scale on button press
- Smooth page transitions
No parallax, no auto-playing carousels

---

## Responsive Strategy

Mobile-first with breakpoints at md (768px) and lg (1024px)
- Stack blocks vertically on mobile
- 2-column grids activate at lg
- Hero remains full-width across all breakpoints
- Touch-friendly tap targets (min 44px)

---

**Final Note**: This is a showcase landing page - every block should feel premium and purposeful. Rich visual hierarchy, generous whitespace between blocks, and crystal-clear CTAs. The modular system allows infinite customization while maintaining design consistency.