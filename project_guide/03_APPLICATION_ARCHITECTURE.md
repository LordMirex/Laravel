# 03 APPLICATION ARCHITECTURE

## Purpose
Internal brain of the system: data flow, system boundaries, and logic.

## Status
- [x] Not started
- [x] In progress
- [ ] Completed

## Core Philosophy
- **One App, One Owner, One Database**: Single Laravel installation per MySQL database.
- **No Multi-tenancy**: Fully isolated from other installations.
- **No Public User Accounts**: Admin-only authentication; no public signup.

## Data Storage
- **JSON-Based Content**: Blocks and layout logic stored in JSON columns for flexibility.
- **Relational Tables**: Only stable entities (products, media, subscribers) get dedicated tables.

## Runtime Modes
- **Installer Mode**: Active when `.env` is missing or `APP_INSTALLED` is false.
- **Application Mode**: Standard live website behavior after setup.

## Logic Flow
1. **Detection**: Check `storage/installed.lock` on boot.
2. **Routing**: Route to `/install` if missing, otherwise load the app.
3. **Rendering**: Theme-aware block rendering based on JSON data.
