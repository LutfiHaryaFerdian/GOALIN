# GOALIN Design System

> **Versi:** 2.0  
> **Terakhir diperbarui:** 2026-05-28  
> **Filosofi:** Nike / Adidas — bold typography, white-dominant, green hanya sebagai aksen.

---

## Prinsip Desain

1. **White sebagai kanvas utama** — background halaman adalah `#f8f8f6`, surface card `#ffffff`
2. **Hijau hemat** — hanya dipakai di CTA utama, active badge, indikator ketersediaan, dan aksen kecil
3. **Hitam untuk authority** — heading, border hover, dark button pakai `#0a0a0a`
4. **Whitespace agresif** — section minimal `py-24 md:py-32`, card `p-6 md:p-8`
5. **No shadows** — hierarki lewat border, bukan box-shadow tebal
6. **SVG-only icons** — tidak ada emoji, semua icon adalah Heroicons outline/stroke

---

## Warna

```css
:root {
  /* Canvas */
  --white:        #ffffff;
  --off-white:    #f8f8f6;   /* body background */
  --surface:      #ffffff;   /* card, panel */

  /* Green — HANYA aksen */
  --green:        #16a34a;   /* CTA, active badge, available slot */
  --green-dark:   #15803d;   /* hover on green elements */
  --green-light:  #f0fdf4;   /* unread notif bg, selected slot bg */
  --green-border: #bbf7d0;   /* border tipis hijau */

  /* Tipografi */
  --ink:          #0a0a0a;   /* heading, border hover, dark button */
  --ink-2:        #404040;   /* body text, nav links */
  --ink-3:        #737373;   /* muted, label, placeholder */
  --line:         #e5e5e5;   /* border default */
  --line-light:   #f5f5f5;   /* divider tipis, hover row bg */

  /* Status */
  --amber:        #d97706;   /* pending */
  --red:          #dc2626;   /* cancelled, error */
  --blue:         #2563eb;   /* completed booking */
}
```

### Aturan Warna
| Situasi | Warna |
|---------|-------|
| Heading utama | `#0a0a0a` |
| Body text | `#404040` |
| Label/muted/placeholder | `#737373` |
| Border default | `#e5e5e5` |
| Border hover | `#0a0a0a` |
| CTA / available slot | `#16a34a` |
| Unread notif border | `#16a34a` |
| Error / danger | `#dc2626` |
| Warning / pending | `#d97706` |

---

## Tipografi

### Font
```html
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
```

| Font | Penggunaan |
|------|-----------|
| **Barlow Condensed** | H1, H2, hero text, stat number besar, section display |
| **Inter** | Semua teks lain — body, label, button, nav, form |

### Scale
```
Display / Hero:   font-display text-[10rem] font-black uppercase tracking-tighter leading-none
H1 Landing:       font-display text-4xl md:text-5xl font-black uppercase tracking-tight
H1 App Page:      font-display text-4xl font-black uppercase tracking-tight
H2 Section:       font-display text-3xl md:text-5xl font-bold uppercase
Section label:    text-xs font-semibold uppercase tracking-[0.15em] text-[#737373]
Body:             text-base font-normal leading-relaxed text-[#404040]
Small:            text-sm text-[#737373]
Mono (kode):      font-mono text-xs text-[#a3a3a3]
```

---

## Komponen

### Button

```html
<!-- Primary (green) — untuk aksi terpenting -->
<button class="inline-flex items-center gap-2 bg-[#16a34a] text-white text-sm font-semibold px-6 py-3 rounded-full hover:bg-[#15803d] transition-colors duration-200">
  Cari Lapangan
</button>

<!-- Dark (hitam) — untuk aksi sekunder penting, submit, CTA -->
<button class="inline-flex items-center gap-2 bg-[#0a0a0a] text-white text-sm font-semibold px-6 py-3 rounded-full hover:bg-[#404040] transition-colors duration-200">
  Daftar Sekarang
</button>

<!-- Secondary (outline) -->
<button class="inline-flex items-center gap-2 border border-[#e5e5e5] text-[#0a0a0a] text-sm font-semibold px-6 py-3 rounded-full hover:border-[#0a0a0a] transition-colors duration-200">
  Lihat Semua
</button>

<!-- Ghost (text) -->
<button class="text-sm font-semibold text-[#16a34a] hover:underline underline-offset-4">
  Selengkapnya
</button>
```

**Aturan tombol:**
- `rounded-full` hanya untuk button dan chip/pill
- Jangan `rounded-full` pada container/card
- Auth form submit: selalu dark button (bukan green)

### Card

```html
<!-- Default card -->
<div class="bg-white rounded-2xl border border-[#e5e5e5] p-6">...</div>

<!-- Hoverable card -->
<div class="bg-white rounded-2xl border border-[#e5e5e5] hover:border-[#0a0a0a] transition-colors duration-300">...</div>

<!-- Booking card sidebar — lebih besar rounded -->
<div class="bg-white rounded-3xl border border-[#e5e5e5] p-6 sticky top-24">...</div>
```

### Field Card

```html
<div class="group bg-white rounded-2xl overflow-hidden border border-[#e5e5e5] hover:border-[#0a0a0a] transition-colors duration-300">
  <!-- aspect-[4/3] image -->
  <div class="p-5">
    <div class="flex items-center justify-between mb-2">
      <span class="text-xs font-semibold uppercase tracking-widest text-[#737373]">Kategori</span>
      <span class="text-xs font-semibold text-[#16a34a]">Tersedia</span>
    </div>
    <h3 class="text-base font-bold text-[#0a0a0a] leading-tight">Nama Lapangan</h3>
    <p class="text-sm text-[#737373] mt-1">Kota</p>
    <div class="flex items-center justify-between mt-4 pt-4 border-t border-[#f5f5f5]">
      <span class="text-base font-bold text-[#0a0a0a]">Rp75.000<span class="text-xs font-normal text-[#737373]">/jam</span></span>
      <span class="text-xs font-semibold underline underline-offset-2">Pesan →</span>
    </div>
  </div>
</div>
```

### Status Badge

```html
<!-- Pending -->
<span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">Menunggu</span>

<!-- Confirmed -->
<span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">Dikonfirmasi</span>

<!-- Cancelled -->
<span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 text-red-700 border border-red-200">Dibatalkan</span>

<!-- Completed -->
<span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-[#f5f5f5] text-[#737373] border border-[#e5e5e5]">Selesai</span>
```

### Input Form

```html
<div class="space-y-1.5">
  <label class="text-xs font-semibold uppercase tracking-[0.1em] text-[#737373]">Email</label>
  <input type="email"
    class="w-full border border-[#e5e5e5] rounded-xl px-4 py-3 text-sm text-[#0a0a0a] placeholder-[#a3a3a3] focus:outline-none focus:border-[#0a0a0a] transition-colors bg-white"
    placeholder="kamu@email.com">
</div>
```

### Time Slots

```html
<!-- Available -->
<button class="slot-available">08:00 – 09:00</button>

<!-- Booked -->
<button class="slot-booked" disabled>09:00 – 10:00</button>

<!-- Selected -->
<button class="slot-selected">10:00 – 11:00</button>

<!-- Closed -->
<button class="slot-closed" disabled>11:00 – 12:00</button>
```

### Sidebar (Owner/Admin)

```html
<!-- Default link -->
<a class="sidebar-link">Dashboard</a>

<!-- Active link — border kiri hitam -->
<a class="sidebar-link active">Lapangan Saya</a>
```

### Section Label

```html
<!-- Pakai di atas setiap heading section -->
<p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#737373]">JENIS LAPANGAN</p>
```

---

## Navbar

- Background: `white` dengan `border-b border-[#e5e5e5]`
- `sticky top-0 z-50`
- Logo: `GOALIN` Barlow Condensed bold + titik hijau kecil (`w-1.5 h-1.5 rounded-full bg-[#16a34a]`)
- Nav links: Inter `text-sm font-medium text-[#737373] hover:text-[#0a0a0a]`
- Active link: `text-[#0a0a0a]` saja — tidak ada border bawah atau underline
- Avatar: circle hitam `w-8 h-8 rounded-full bg-[#0a0a0a]` dengan initial huruf
- Bell: SVG Heroicons outline, badge hijau `#16a34a`
- **TIDAK ada box-shadow**, **TIDAK ada green background** di navbar

---

## Landing Page

### Struktur Sections (urutan wajib)
1. **Hero** — putih, headline masif Barlow Condensed, stat bar
2. **Kategori** — `bg-[#f8f8f6]`, chip filter pill
3. **Lapangan Unggulan** — `bg-white`, grid 3 kolom
4. **Cara Kerja** — `bg-[#f8f8f6]`, 3 steps dengan nomor dekoratif besar
5. **Stats** — `bg-[#0a0a0a]` satu-satunya section gelap
6. **CTA Bottom** — `bg-white`, center-aligned
7. **Footer** — minimal 1 baris

### Hero Pattern
```
- Eyebrow: section-label
- Headline: font-display, min text-[7rem], font-black uppercase
- Kata kunci diberi underline hijau tebal (h-2 md:h-3 bg-[#16a34a])
- Subtext: text-lg text-[#404040] max-w-md
- CTA: dark button + ghost button
- Stat bar: 3 angka dipisah divider vertikal
- Texture: pitch-lines CSS (opacity rendah, pointer-events-none)
```

---

## Auth Pages (Guest Layout)

- Background: `bg-[#f8f8f6]`
- Card: `bg-white rounded-3xl border border-[#e5e5e5] p-8 md:p-10`
- Card width: `max-w-md`
- Logo: kiri atas, kecil
- Heading: `font-display` uppercase
- Submit button: **dark** (`bg-[#0a0a0a] rounded-full`), bukan green
- Link kembali: pojok kanan atas

---

## Dashboard (Owner/Admin)

- Layout: `flex` — sidebar 60 + main flex-1
- Sidebar: `w-60 bg-white border-r border-[#e5e5e5]`
- Sidebar active: `border-l-2 border-[#0a0a0a] bg-[#f8f8f6]`
- Stat card: angka besar `font-display text-3xl font-black`, label kecil section-label
- Table rows: `hover:bg-[#f8f8f6]`, NO zebra stripes

---

## Anti-AI Checklist

Sebelum deploy, verifikasi semua item:

- [ ] Tidak ada gradient warna-warni (hanya solid atau `from-black/x to-transparent`)
- [ ] Tidak ada `box-shadow` tebal — max `shadow-sm` atau tidak ada
- [ ] `rounded-full` hanya di button dan chip/pill, bukan container besar
- [ ] Tidak lebih dari 3 warna di satu halaman (putih, hitam, hijau)
- [ ] Tidak ada emoji — semua icon adalah SVG Heroicons outline/stroke
- [ ] Tidak ada section gradient ungu/biru/orange
- [ ] Max 1 `<h1>` per halaman
- [ ] Tidak ada "feature grid" 6 icon + teks pendek (klise AI template)
- [ ] Font Barlow Condensed **hanya** di heading besar, tidak di tombol/label kecil
- [ ] Warna hijau hemat — hanya CTA, active state, badge success, aksen kecil
- [ ] Spacing konsisten — tidak ada elemen rapat atau mengambang sendiri
- [ ] Semua icon menggunakan SVG inline atau komponen `<x-icon>`

---

## Tailwind Custom Classes (dari `app.css`)

| Class | Fungsi |
|-------|--------|
| `btn-primary` | Tombol hijau rounded-full |
| `btn-dark` | Tombol hitam rounded-full |
| `btn-secondary` | Tombol outline border rounded-full |
| `btn-ghost` | Teks hijau + underline hover |
| `btn-danger` | Tombol merah rounded-full |
| `card` | `bg-white rounded-2xl border border-[#e5e5e5]` |
| `card-hover` | Card + `hover:border-[#0a0a0a]` |
| `input` | Input field dengan focus border ink |
| `label` | Label form uppercase tracking |
| `section-label` | Eyebrow label atas heading |
| `badge-pending` | Badge amber |
| `badge-confirmed` | Badge hijau |
| `badge-cancelled` | Badge merah |
| `badge-completed` | Badge abu |
| `slot-available` | Slot hijau ringan |
| `slot-booked` | Slot strikethrough |
| `slot-selected` | Slot hitam dipilih |
| `slot-closed` | Slot abu tutup |
| `sidebar-link` | Link sidebar |
| `sidebar-link.active` | Link sidebar aktif (border kiri hitam) |
| `font-display` | Barlow Condensed font |
| `pitch-lines` | Tekstur garis lapangan (subtile) |
