# تصميم قاعدة البيانات — نظام بطاقات VIP

## مخطط العلاقات (ERD)

```
users ──────────────┐
                    │ issued_by / created_by
customers ──< vip_cards
                    │
customers ──< message_logs
message_campaigns ──< message_logs
users ──< message_campaigns
```

## الجداول

### 1. users
| العمود | النوع | الوصف |
|--------|-------|-------|
| id | BIGINT PK | المعرف |
| name | VARCHAR(255) | الاسم |
| email | VARCHAR(255) UNIQUE | البريد |
| password | VARCHAR(255) | كلمة المرور |
| role | ENUM(admin, employee) | الصلاحية |
| is_active | BOOLEAN | نشط/معطل |
| remember_token | VARCHAR(100) | تذكرني |
| timestamps | | |

### 2. customers
| العمود | النوع | الوصف |
|--------|-------|-------|
| id | BIGINT PK | المعرف |
| name | VARCHAR(255) | اسم العميل |
| phone | VARCHAR(20) UNIQUE | رقم الهاتف |
| email | VARCHAR(255) NULL | البريد |
| national_id | VARCHAR(50) NULL | رقم الهوية |
| address | TEXT NULL | العنوان |
| notes | TEXT NULL | ملاحظات |
| timestamps | | |

### 3. vip_cards
| العمود | النوع | الوصف |
|--------|-------|-------|
| id | BIGINT PK | المعرف |
| customer_id | FK → customers | العميل |
| membership_number | VARCHAR(50) UNIQUE | رقم العضوية |
| card_type | ENUM(silver, gold) | نوع البطاقة |
| price | DECIMAL(10,2) | السعر |
| status | ENUM(active, expired, cancelled) | الحالة |
| issued_at | DATETIME | تاريخ الإصدار |
| expires_at | DATETIME | تاريخ الانتهاء |
| qr_token | VARCHAR(64) UNIQUE | رمز QR العام |
| issued_by | FK → users | الموظف المصدر |
| renewed_at | DATETIME NULL | آخر تجديد |
| cancelled_at | DATETIME NULL | تاريخ الإلغاء |
| cancelled_reason | TEXT NULL | سبب الإلغاء |
| timestamps | | |

### 4. message_campaigns
| العمود | النوع | الوصف |
|--------|-------|-------|
| id | BIGINT PK | المعرف |
| title | VARCHAR(255) | عنوان الحملة |
| channel | ENUM(sms, whatsapp, both) | القناة |
| message_body | TEXT | نص الرسالة |
| status | ENUM(draft, scheduled, processing, completed, failed, cancelled) | الحالة |
| source_type | ENUM(customers, excel) | مصدر المستلمين |
| import_file | VARCHAR(500) NULL | مسار ملف Excel |
| scheduled_at | DATETIME NULL | موعد الجدولة |
| started_at | DATETIME NULL | بدء الإرسال |
| completed_at | DATETIME NULL | انتهاء الإرسال |
| total_recipients | INT DEFAULT 0 | إجمالي المستلمين |
| sent_count | INT DEFAULT 0 | المرسلة |
| failed_count | INT DEFAULT 0 | الفاشلة |
| created_by | FK → users | المنشئ |
| timestamps | | |

### 5. message_logs
| العمود | النوع | الوصف |
|--------|-------|-------|
| id | BIGINT PK | المعرف |
| campaign_id | FK → message_campaigns | الحملة |
| customer_id | FK → customers NULL | العميل (إن وُجد) |
| recipient_name | VARCHAR(255) | اسم المستلم |
| recipient_phone | VARCHAR(20) | رقم الهاتف |
| channel | ENUM(sms, whatsapp) | القناة |
| status | ENUM(pending, sent, failed) | الحالة |
| error_message | TEXT NULL | رسالة الخطأ |
| sent_at | DATETIME NULL | وقت الإرسال |
| timestamps | | |

### 6. sessions (Laravel default)
### 7. cache / jobs (Laravel queue للرسائل الجماعية)

## الفهارس
- `vip_cards.status`, `vip_cards.card_type`, `vip_cards.expires_at`
- `customers.name`, `customers.phone`
- `message_logs.campaign_id`, `message_logs.status`

## قواعد العمل
- رقم العضوية: `VIP-YYYY-XXXXXX` (تسلسلي سنوي)
- QR Token: `Str::random(32)` — رابط عام `/card/{token}`
- تجديد البطاقة: تمديد `expires_at` بـ 365 يوم + تحديث الحالة إلى active
- إلغاء البطاقة: status = cancelled
- انتهاء البطاقة: تلقائي عند `expires_at < now()` أو عبر scheduled command
