---
name: Athetic Editorial
colors:
  surface: '#f9faf7'
  surface-dim: '#d9dad8'
  surface-bright: '#f9faf7'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f4f1'
  surface-container: '#edeeeb'
  surface-container-high: '#e8e8e6'
  surface-container-highest: '#e2e3e0'
  on-surface: '#1a1c1b'
  on-surface-variant: '#414845'
  inverse-surface: '#2f312f'
  inverse-on-surface: '#f0f1ee'
  outline: '#717974'
  outline-variant: '#c0c8c3'
  surface-tint: '#3c6658'
  primary: '#00241a'
  on-primary: '#ffffff'
  primary-container: '#0d3b2e'
  on-primary-container: '#79a694'
  inverse-primary: '#a3d0be'
  secondary: '#5d5f5b'
  on-secondary: '#ffffff'
  secondary-container: '#e0e0db'
  on-secondary-container: '#62635f'
  tertiary: '#371410'
  on-tertiary: '#ffffff'
  tertiary-container: '#512923'
  on-tertiary-container: '#c88f86'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#beedd9'
  primary-fixed-dim: '#a3d0be'
  on-primary-fixed: '#002117'
  on-primary-fixed-variant: '#234e40'
  secondary-fixed: '#e3e3de'
  secondary-fixed-dim: '#c6c7c2'
  on-secondary-fixed: '#1a1c19'
  on-secondary-fixed-variant: '#454744'
  tertiary-fixed: '#ffdad4'
  tertiary-fixed-dim: '#f6b8ae'
  on-tertiary-fixed: '#33110c'
  on-tertiary-fixed-variant: '#673b34'
  background: '#f9faf7'
  on-background: '#1a1c1b'
  surface-variant: '#e2e3e0'
typography:
  display-2xl:
    fontFamily: Barlow Condensed
    fontSize: 80px
    fontWeight: '800'
    lineHeight: 80px
    letterSpacing: -0.02em
  display-lg:
    fontFamily: Barlow Condensed
    fontSize: 48px
    fontWeight: '800'
    lineHeight: 48px
    letterSpacing: -0.01em
  display-lg-mobile:
    fontFamily: Barlow Condensed
    fontSize: 36px
    fontWeight: '800'
    lineHeight: 36px
  headline-md:
    fontFamily: Barlow Condensed
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 28px
  body-lg:
    fontFamily: DM Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: DM Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-bold:
    fontFamily: DM Sans
    fontSize: 14px
    fontWeight: '700'
    lineHeight: 20px
    letterSpacing: 0.05em
  label-sm:
    fontFamily: DM Sans
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
spacing:
  unit: 8px
  container-max: 1280px
  gutter: 24px
  margin-desktop: 48px
  margin-mobile: 20px
---

## Brand & Style

The design system is built on the intersection of high-end editorial layouts and raw athletic intensity. It targets urban athletes and facility managers who value efficiency and prestige. The emotional response is one of confidence, momentum, and professional clarity.

The style is **Editorial Minimalism**. It leverages massive, high-impact typography typically found in sports journalism, balanced by expansive whitespace and a restrained, high-contrast color palette. Visual interest is generated through structural geometry and flat color blocks rather than decorative effects. There are no gradients or soft shadows; the UI is intentionally flat, sharp, and decisive.

## Colors

The palette is driven by the contrast between deep heritage tones and modern neon energy.

- **Primary (#0D3B2E):** Deep Forest Green. Used for primary branding, heavy headers, and sophisticated backgrounds. It represents the "turf" but in a premium, dark-mode context.
- **Accent (#C6FF00):** Electric Lime. Used exclusively for high-priority calls to action, active states, and focus indicators. This color should be used sparingly to maintain its disruptive impact.
- **Background (#F5F5F0):** Off-White. The canvas for the application. It provides a warmer, more editorial feel than pure white, reducing eye strain and feeling more "printed."
- **Text/Surface (#1A1A1A):** Charcoal. Used for primary body text and dark UI elements to ensure maximum legibility against the off-white background.

## Typography

The typography strategy uses a "Scale and Impact" model. 

**Display Styles:** Use Barlow Condensed in Extra-Bold. These must always be uppercase. For hero sections and major headers, use tight tracking (-0.02em) and tight line-height to create a blocky, architectural feel.

**Body Styles:** Use DM Sans for all functional copy. It provides a clean, geometric counterpoint to the condensed headlines, ensuring the UI remains approachable and highly readable.

**Functional Labels:** Small labels, such as "Available" or "Pitch Type," should be set in DM Sans Bold, uppercase, with increased letter spacing to ensure they remain distinct at small sizes.

## Layout & Spacing

This design system utilizes a **Fixed Grid** approach for desktop to maintain editorial control over whitespace, and a **Fluid Grid** for mobile devices.

- **Grid:** A 12-column grid on desktop with generous 24px gutters. Elements should align strictly to these columns to maintain a structured, "newspaper" feel.
- **Horizontal Rules:** Use 1px solid lines (Charcoal at 10% opacity) to separate sections. This reinforces the editorial aesthetic without adding visual weight.
- **Whitespace:** Use aggressive vertical padding between sections (80px - 120px) to allow the bold typography room to breathe.
- **Mobile Adaption:** On mobile, margins reduce to 20px. Display sizes should scale down significantly while maintaining their uppercase, bold character.

## Elevation & Depth

This system rejects shadows in favor of **Tonal Layers** and **Bold Outlines**. 

- **Flatness:** All elements sit on the same visual plane. Depth is communicated via color blocking (e.g., a Charcoal card on an Off-White background).
- **Overlays:** For modals or menus, use a solid color fill (Deep Forest Green) rather than a blur.
- **Borders:** Use thin (1px) borders in Charcoal for input fields and secondary containers. 
- **Texture:** A subtle "field-grid" pattern—repeating 1px lines or dots representing sports court markings—can be used as a low-contrast background motif in the Primary Green areas.

## Shapes

The shape language is **Sharp**. To maintain the "Editorial Minimalism" and "Sports Energy," all buttons, cards, and input fields utilize 0px border radii. 

The only exception to the sharp-edge rule is for circular icons or specific "Ball" themed graphic elements. All structural UI components remain strictly rectangular to reflect the boundaries and precision of a sports field.

## Components

**Buttons:**
- **Primary:** Electric Lime background, Charcoal text, All-caps Barlow Condensed. No border. High-impact.
- **Secondary:** Deep Forest Green background, Off-white text.
- **Ghost:** 1px Charcoal border, transparent background, Charcoal text.

**Input Fields:**
- 1px Charcoal border. Labels are always positioned above the field in all-caps DM Sans Bold. Focus state is indicated by a 2px Electric Lime bottom border.

**Cards:**
- Use a solid background of either Off-White (on Green) or Charcoal (on Off-White). No shadows. Content is padded by 24px on all sides. Use 1px rules to separate internal card content.

**Chips/Tags:**
- Small, rectangular blocks with Deep Forest Green backgrounds and Off-white text. Used for "5-a-side," "Indoor," or "Floodlights."

**Booking Grid:**
- A strict table-like structure using 1px rules. The "Selected" time slot should be filled with Electric Lime, creating a high-contrast visual indicator of the user's choice.