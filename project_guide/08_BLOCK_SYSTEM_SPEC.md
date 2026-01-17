# 08 BLOCK SYSTEM SPEC

## Purpose
Exhaustive field and behavior specification for every content block type.

## Status
- [x] Not started
- [x] In progress
- [ ] Completed

## Block Architecture
- Blocks are data containers stored in `blocks` table with a `content` JSON column.
- Themes determine how these blocks are rendered visually.

## Core Block Types
- **Hero**: Title, Subtitle, CTA, Background (Image/Video).
- **Video Grid**: Youtube/TikTok links, Layout (Grid/Slider).
- **Store**: Product list, WhatsApp buy message template.
- **Newsletter**: Signup form, Headline, Description.
- **About**: Profile image, Bio text, Social links.

## Visibility & Ordering
- Admin can toggle `enabled` status.
- Order is controlled by `order_index`.
