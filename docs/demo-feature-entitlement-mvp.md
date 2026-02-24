# Demo Spec: Feature Entitlement (Laravel ERP)

## 1) Tujuan

Membangun aplikasi demo baru berbasis project ERP Laravel yang mendukung model bisnis per fitur/modul, dengan kontrol penuh oleh superadmin, dan siap dievolusikan bertahap ke arsitektur microservice.

## 2) Prinsip Produk

- Client tidak otomatis mendapatkan semua modul.
- Akses client ditentukan oleh kombinasi paket + add-on.
- Entitlement harus konsisten di UI, API, dan backend action.
- Perubahan entitlement oleh superadmin harus terlihat langsung (tanpa deploy ulang).

## 3) Fitur Master (Catalog)

Setiap fitur disimpan sebagai master data:

- `code` (unik), contoh: `hr.payroll`, `crm.lead`, `project.task`
- `name`
- `description`
- `status` (`active`/`inactive` untuk kontrol global)
- `is_addon` (boolean)
- `depends_on` (opsional, daftar fitur dependensi)

Kategori awal untuk demo:

- Core: dashboard, profile, basic user management
- Business: CRM, Project, HR, Accounting, Inventory
- Opsional add-on: advanced report, approval workflow, API access

## 4) Paket + Add-On

### Paket Dasar

- `starter`
- `growth`
- `enterprise`

Setiap paket berisi kumpulan fitur bawaan (`package_features`).

### Add-On

- Add-on menambah fitur di luar paket bawaan.
- Add-on bisa diaktifkan/nonaktifkan per client kapan saja.

## 5) Entitlement Per Client

Sumber entitlement final client:

1. Fitur dari paket aktif client
2. Tambahan fitur add-on client
3. Override manual superadmin (`force_enable` / `force_disable`)

Prioritas evaluasi:

1. `force_disable`
2. `force_enable`
3. Paket + add-on
4. Default: tidak aktif

## 6) Role Superadmin

Hak akses superadmin pada demo:

- Kelola fitur master (aktif/nonaktif global)
- Kelola paket dan isi paket
- Assign paket ke client (tenant)
- Kelola add-on per client
- Set override per fitur per client
- Lihat halaman audit perubahan entitlement

## 7) Enforcement 3 Layer (Wajib)

### UI/Menu Gating

- Menu disusun dari daftar entitlement aktif.
- Menu/halaman fitur nonaktif tidak ditampilkan.

### Route/API Gating

- Middleware `feature.required:<feature_code>` untuk web/API route.
- Endpoint fitur nonaktif mengembalikan `403` dengan kode error yang konsisten.

### Backend Action Gating

- Service layer/policy tetap validasi fitur sebelum eksekusi aksi kritikal.
- Mencegah bypass dari direct request/job/internal call.

## 8) Alur Toggle (End-to-End Demo)

1. Superadmin login.
2. Superadmin assign paket `starter` ke Client A.
3. Client A login, hanya lihat modul sesuai paket starter.
4. Superadmin aktifkan add-on `advanced-report` untuk Client A.
5. Client A refresh, modul report langsung muncul.
6. Superadmin `force_disable` fitur `project.task`.
7. Client A kehilangan akses menu + endpoint `project.task` langsung `403`.
8. Audit log mencatat siapa mengubah, kapan, dan perubahan apa.

## 9) Scope MVP Demo

Fokus MVP:

- Multi-tenant sederhana berbasis `client_id` (single database).
- 5-8 fitur master untuk pembuktian gating.
- 3 paket dasar + 2 add-on.
- 3 halaman superadmin:
  - Feature Catalog
  - Package Management
  - Client Entitlement
- Middleware route + helper service `FeatureGate`.
- Satu endpoint API contoh yang terbukti terblokir saat fitur nonaktif.
- Audit log entitlement.

Di luar MVP:

- Billing/invoicing otomatis
- Provisioning infra per tenant
- Microservice runtime penuh

## 10) Rancangan Data Minimum

Tabel inti yang disarankan:

- `features`
- `packages`
- `package_features`
- `clients`
- `client_packages`
- `client_feature_addons`
- `client_feature_overrides`
- `feature_audit_logs`

## 11) Kontrak Service Entitlement

Service utama:

- `FeatureGate::isEnabled(clientId, featureCode): bool`
- `FeatureGate::assertEnabled(clientId, featureCode): void|throws`
- `FeatureGate::listEnabled(clientId): array`

Caching:

- Cache Redis per client (`entitlement:{clientId}`) dengan invalidasi saat ada perubahan oleh superadmin.

## 12) Roadmap Bertahap ke Microservice

Tahap 1 (sekarang):

- Modular monolith di Laravel + Redis cache untuk entitlement.

Tahap 2:

- Pisahkan modul bertraffic tinggi (contoh reporting) jadi service terpisah.
- Entitlement tetap sumber tunggal (shared service atau shared store).

Tahap 3:

- Dedicated Entitlement Service dengan API internal.
- Semua service memvalidasi entitlement via local cache + fallback ke service.

## 13) Acceptance Criteria Demo

- Superadmin bisa assign paket dan add-on ke client.
- UI client berubah sesuai entitlement tanpa perubahan kode manual.
- Endpoint modul nonaktif selalu `403`.
- Aksi backend modul nonaktif ditolak walau endpoint dipanggil langsung.
- Audit trail entitlement tercatat dan dapat ditampilkan.
