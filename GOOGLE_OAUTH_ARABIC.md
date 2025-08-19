# دليل إعداد Google OAuth باللغة العربية

## المشكلة
تحصل على خطأ "The OAuth client was not found" لأن ملف `.env` يحتوي على قيم مؤقتة بدلاً من credentials حقيقية.

## الحل خطوة بخطوة

### 1️⃣ إنشاء Google OAuth Credentials

1. **اذهب إلى Google Cloud Console**: https://console.cloud.google.com/
2. **أنشئ مشروع جديد أو اختر مشروع موجود**
3. **فعّل Google+ API**:
   - اذهب إلى "APIs & Services" > "Library"
   - ابحث عن "Google+ API" واضغط "Enable"
4. **أنشئ OAuth 2.0 Credentials**:
   - اذهب إلى "APIs & Services" > "Credentials"
   - اضغط "Create Credentials" > "OAuth 2.0 Client IDs"
   - اختر "Web application"
   - املأ البيانات التالية:
     - **Name**: WebSec OAuth Client
     - **Authorized redirect URIs**: `http://127.0.0.1:8000/auth/google/callback`
     - **Authorized JavaScript origins**: `http://127.0.0.1:8000`
5. **انسخ Credentials**: ستجد Client ID و Client Secret

### 2️⃣ تحديث ملف .env

#### الطريقة الأولى: استخدام الـ Script
```bash
php update_env.php
```

#### الطريقة الثانية: التحديث اليدوي
افتح ملف `.env` واستبدل القيم المؤقتة:

```env
# استبدل هذه القيم المؤقتة:
GOOGLE_CLIENT_ID=your-actual-google-client-id
GOOGLE_CLIENT_SECRET=your-actual-google-client-secret

# بالقيم الحقيقية (مثال):
GOOGLE_CLIENT_ID=your-actual-google-client-id
GOOGLE_CLIENT_SECRET=your-actual-google-client-secret
```

### 3️⃣ مسح Cache

شغل هذه الأوامر بعد تحديث ملف .env:

```bash
php artisan config:clear
php artisan cache:clear
```

### 4️⃣ اختبار التطبيق

1. اذهب إلى: http://127.0.0.1:8000/login
2. اضغط على "Sign in with Google"
3. يجب أن ترى شاشة موافقة Google بدلاً من الخطأ

## حل المشاكل الشائعة

### مشكلة: "redirect_uri_mismatch"
- **الحل**: تأكد من أن redirect URI في Google Console مطابق تماماً: `http://127.0.0.1:8000/auth/google/callback`

### مشكلة: "invalid_client"
- **الحل**: تأكد من نسخ Client ID و Secret بشكل صحيح من Google Console

### مشكلة: "access_denied"
- **الحل**: تأكد من تفعيل Google+ API في Google Cloud Console

## ملاحظات الأمان

- لا تشارك credentials مع أي شخص
- استخدم متغيرات البيئة للإعدادات الحساسة
- استخدم HTTPS في الإنتاج
- غيّر credentials بانتظام 